<?php

namespace Mintellity\LaravelTabbedSession\Routing;

use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Routing\Route;
use Illuminate\Routing\UrlGenerator;
use Mintellity\LaravelTabbedSession\Exceptions\NoTabIdFoundException;
use Mintellity\LaravelTabbedSession\LaravelTabbedSession;

class TabbedUrlGenerator extends UrlGenerator
{
    /**
     * @param  Route  $route
     * @param  mixed  $parameters
     * @param  bool  $absolute
     *
     * @throws UrlGenerationException
     */
    public function toRoute($route, $parameters, $absolute): string
    {
        try {
            if (is_array($parameters)) {
                $parameters[LaravelTabbedSession::getTabQueryParameterName()] = browserTab()->getId();
            } else {
                $parameters = [$parameters, LaravelTabbedSession::getTabQueryParameterName() => browserTab()->getId()];
            }
        } catch (NoTabIdFoundException) {
            // Do nothing
        }

        return parent::toRoute($route, $parameters, $absolute);
    }
}
