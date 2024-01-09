<?php

namespace Mintellity\LaravelTabbedSession;

use Illuminate\Support\Str;

class LaravelTabbedSession
{
    public static function getTabQueryParameterName(string $prefix = ''): string
    {
        if ($prefix == null) {
            return config('tabbed-session.url-parameter-name');
        }

        return $prefix.Str::ucfirst(config('tabbed-session.url-parameter-name'));
    }

    public static function disabledForPath(): bool
    {
        return collect(config('tabbed-session.excluded'))->search(fn (string $pattern) => @preg_match($pattern, request()->path()) || $pattern === request()->path()) !== false;
    }
}
