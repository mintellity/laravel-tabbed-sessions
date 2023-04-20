<?php

namespace Mintellity\LaravelTabbedSession\Routing;

use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Routing\Route;
use Illuminate\Routing\UrlGenerator;
use Mintellity\LaravelTabbedSession\Exceptions\NoTabIdFoundException;

class TabbedUrlGenerator extends UrlGenerator
{
    /**
     * @param Route $route
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     * @throws UrlGenerationException
     */
    public function toRoute($route, $parameters, $absolute): string
    {
        try {
            if (is_array($parameters)) {
                $parameters['tabId'] = tab()->getId();
            } else {
                $parameters = [$parameters, 'tabId' => tab()->getId()];
            }
        } catch (NoTabIdFoundException) {
            // Do nothing
        }

        return parent::toRoute($route, $parameters, $absolute);
    }
}
