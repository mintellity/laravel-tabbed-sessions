<?php

namespace Mintellity\LaravelTabbedSession\Exceptions;

use Exception;

class TabDisabledException extends Exception
{
    protected $message = 'Tabbed session is excluded from this path. Don\'t use the browserTab() on this route.';
}
