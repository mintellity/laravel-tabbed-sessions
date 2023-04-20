<?php

namespace Mintellity\LaravelTabbedSession\Exceptions;

use Exception;

class NoTabIdFoundException extends Exception
{
    protected $message = 'No tabId found in this request. Neither in the query string nor in the referrer.';
}
