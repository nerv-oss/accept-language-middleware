<?php

namespace Nerv\AcceptLanguageMiddleware;

use Illuminate\Support\ServiceProvider;

class AcceptLanguageMiddlewareProvider extends ServiceProvider {
    public function register() {
        $this->mergeConfigFrom(
            __DIR__.'/config/accept-language-middleware.php', 'accept-language-middleware'
        );
    }

    public function boot() {
        $this->publishes([
            __DIR__.'/config/accept-language-middleware.php' => config_path('accept-language-middleware.php'),
        ], 'accept-language-middleware');
    }
}
