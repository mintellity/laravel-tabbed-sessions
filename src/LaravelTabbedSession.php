<?php

namespace Mintellity\LaravelTabbedSession;

use Illuminate\Support\Str;

class LaravelTabbedSession
{
    public static function getTabQueryParameterName(string $prefix = ''): string
    {
        if ($prefix == null)
            return config('tabbed-session.url-parameter-name');

        return $prefix . Str::ucfirst(config('tabbed-session.url-parameter-name'));
    }
}
