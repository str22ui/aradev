<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // 1️⃣ Paginator menggunakan Bootstrap
        Paginator::useBootstrap();

        // 2️⃣ Blade directive untuk format tanggal
        Blade::directive('datetime', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->locale('id')->isoFormat('D MMMM YYYY'); ?>";
        });

        // 3️⃣ MorphMap untuk polymorphic referral
       Relation::morphMap([
            'user' => 'App\Models\User',
            'agent' => 'App\Models\Agent',   // perhatikan "agent", bukan "agents"
            'affiliate' => 'App\Models\Affiliate',
        ]);

    }
}
