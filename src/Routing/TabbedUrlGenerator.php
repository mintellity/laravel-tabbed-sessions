<?php

namespace Mintellity\TabbedSession\Routing;

use Exception;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Routing\Route;
use Illuminate\Routing\UrlGenerator;
use Mintellity\TabbedSession\Exceptions\NoTabIdFoundException;

class TabbedUrlGenerator extends UrlGenerator
{
    /**
     * @param Route $route
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     * @throws UrlGenerationException
     * @throws NoTabIdFoundException
     */
    public function toRoute($route, $parameters, $absolute): string
    {
        if (is_array($parameters)) {
            $parameters['tabId'] = tab()->getId();
        } else {
            $parameters = [$parameters, 'tabId' => tab()->getId()];
        }

        return parent::toRoute($route, $parameters, $absolute);
    }
}
