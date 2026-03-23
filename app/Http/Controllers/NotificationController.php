<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = $this->appView->notifications($user);
        $title = 'Notifications';

        return view('app.notifications', compact('notifications', 'title'));
    }
}
