<?php

namespace ArtisanBuild\Browsio;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BrowsioProvider extends ServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'browsio');

        Route::post('/browsio/{hit}', function(Request $request, $hit) {
            \Cache::remember('browsio-' . $hit
                , config('browsio.ttl', 300)
                , fn() => $request->post('contents'));
            return response()->noContent(200);
        })->name('browsio');
    }
}
