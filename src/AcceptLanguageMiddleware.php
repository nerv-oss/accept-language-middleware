<?php

namespace Nerv\AcceptLanguageMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AcceptLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $this->getPreferredAvilableLocale($request);
        $sessionLocale = $request->session()->get(config('accept-language-middleware.session_property'));

        if ($sessionLocale) {
            app()->setLocale($sessionLocale);
        } else if ($locale) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }

    /**
     *
     *
     * @param Request $request
     * @return string|null
     */
    private function getPreferredAvilableLocale($request): string | null {
        $availableLocales = config('accept-language-middleware.available_locales');
        $preferredLocales = $this->parseHttpLocales($request);

        foreach ($preferredLocales as $preferredLocale) {
            if (in_array($preferredLocale, $availableLocales)) {
                return $preferredLocale;
            }
        }

        return null;
    }

    private function parseHttpLocales(Request $request): array
    {
        $list = explode(',', $request->server('HTTP_ACCEPT_LANGUAGE', ''));

        $locales = Collection::make($list)
            ->map(function ($locale) {
                $parts = explode(';', $locale);

                $mapping['locale'] = trim($parts[0]);

                if (isset($parts[1])) {
                    $factorParts = explode('=', $parts[1]);

                    $mapping['factor'] = $factorParts[1];
                } else {
                    $mapping['factor'] = 1;
                }

                return $mapping;
            })
            ->sortByDesc(function ($locale) {
                return $locale['factor'];
            });

        return $locales->pluck('locale')->all();
    }
}
