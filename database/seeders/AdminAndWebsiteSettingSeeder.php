<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAndWebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin SoftiFY',
                'password' => Hash::make('vegaganteng1'),
                'is_admin' => true,
                'is_banned' => false,
            ]
        );

        $defaults = [
            'premium_price_monthly' => '49000',
            'premium_feature_lines' => "AI Mode 2 generate 2-5 task per hari\nPrioritas schedule lebih fleksibel\nCocok untuk planning belajar intensif",
            'homepage_how_it_works' => "Login terlebih dahulu|Masuk ke akun Anda untuk membuka dashboard belajar, melihat progres, dan mengakses semua fitur yang sudah dipersonalisasi.\nAtur jadwal belajar|Tentukan waktu belajar harian sesuai ritme Anda. Sistem akan membantu menjaga konsistensi dengan pengingat otomatis.\nBuat target mingguan|Susun target yang jelas agar fokus belajar lebih terarah. Anda bisa memantau progres setiap target secara real-time.\nSelesaikan tugas harian|Kerjakan daftar tugas satu per satu dan tandai yang selesai. Setiap pencapaian akan masuk ke statistik produktivitas Anda.\nGunakan AI Asisten|Tanyakan materi, minta ringkasan, atau rekomendasi strategi belajar. AI Asisten membantu Anda belajar lebih cepat dan efektif.\nReview progres rutin|Lihat perkembangan streak, jam belajar, dan capaian target. Dari sana Anda bisa evaluasi dan optimalkan strategi belajar berikutnya.",
        ];

        foreach ($defaults as $key => $value) {
            WebsiteSetting::query()->firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
