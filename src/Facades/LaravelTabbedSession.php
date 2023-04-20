<?php

namespace Mintellity\LaravelTabbedSession\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mintellity\LaravelTabbedSession\LaravelTabbedSession
 */
class LaravelTabbedSession extends Facade
{
    /**
     * @return class-string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Mintellity\LaravelTabbedSession\LaravelTabbedSession::class;
    }
}
