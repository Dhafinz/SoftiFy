<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function publicIndex()
    {
        try {
            $averageRating = round((float) Review::query()->avg('rating'), 1);
            $totalReviews = Review::query()->count();

            $reviews = Review::query()
                ->with('user:id,name')
                ->latest('id')
                ->paginate(12);
        } catch (QueryException) {
            $averageRating = 0;
            $totalReviews = 0;
            $reviews = new LengthAwarePaginator([], 0, 12, 1, ['path' => url()->current()]);
        }

        return view('reviews', compact('averageRating', 'totalReviews', 'reviews'));
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $notifications = $this->appView->notifications($user);
        $title = 'Ulasan Pengguna';

        try {
            $myReview = Review::query()->where('user_id', $user->id)->first();

            $recentReviews = Review::query()
                ->with('user:id,name')
                ->latest('id')
                ->limit(10)
                ->get();

            $averageRating = round((float) Review::query()->avg('rating'), 1);
            $totalReviews = Review::query()->count();
        } catch (QueryException) {
            $myReview = null;
            $recentReviews = collect();
            $averageRating = 0;
            $totalReviews = 0;
        }

        return view('app.reviews', compact(
            'notifications',
            'title',
            'myReview',
            'recentReviews',
            'averageRating',
            'totalReviews'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'min:10', 'max:1200'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        try {
            Review::query()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'rating' => $validated['rating'],
                    'message' => trim($validated['message']),
                ]
            );
        } catch (QueryException) {
            return back()->withErrors(['message' => 'Tabel ulasan belum siap. Jalankan migrasi dulu.']);
        }

        return back()->with('success', 'Ulasan kamu berhasil disimpan. Terima kasih sudah menilai SoftiFy.');
    }
}
