<?php

namespace Mintellity\LaravelTabbedSession\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mintellity\LaravelTabbedSession\Exceptions\NoTabIdFoundException;
use Mintellity\LaravelTabbedSession\LaravelTabbedSession;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class TabbedSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     *
     * @throws NoTabIdFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->query(LaravelTabbedSession::getTabQueryParameterName('old')) != null) {
            $newTabId = Str::uuid()->toString();

            $oldTab = browserTab(request()->query(LaravelTabbedSession::getTabQueryParameterName('old')));
            $newTab = browserTab($newTabId, true)->copy($oldTab);

            return redirect()->to(request()->fullUrlWithQuery([
                LaravelTabbedSession::getTabQueryParameterName('new') => $newTab->getId(),
                LaravelTabbedSession::getTabQueryParameterName('old') => null,
            ]));
        }

        $referrer = parse_url(request()->header('referer'));
        parse_str($referrer['query'] ?? '', $query);

        if (! (request()->query(LaravelTabbedSession::getTabQueryParameterName()) || request()->query(LaravelTabbedSession::getTabQueryParameterName('new')) || array_key_exists(LaravelTabbedSession::getTabQueryParameterName(), $query) || array_key_exists(LaravelTabbedSession::getTabQueryParameterName('new'), $query))) {
            return redirect()->to(request()->fullUrlWithQuery([
                LaravelTabbedSession::getTabQueryParameterName('new') => Str::uuid()->toString(),
                LaravelTabbedSession::getTabQueryParameterName('old') => null,
            ]));
        }

        return $next($request);
    }
}
