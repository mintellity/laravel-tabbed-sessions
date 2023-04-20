<?php

namespace Mintellity\TabbedSession\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mintellity\TabbedSession\TabbedSession
 */
class TabbedSession extends Facade
{
    /**
     * @return class-string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Mintellity\TabbedSession\TabbedSession::class;
    }
}
