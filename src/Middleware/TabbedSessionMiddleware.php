<?php

namespace Mintellity\TabbedSession\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mintellity\TabbedSession\Exceptions\NoTabIdFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class TabbedSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     * @throws NoTabIdFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->query('oldTabId') != null) {
            $newTabId = Str::uuid()->toString();

            $oldTab = tab(request()->query('oldTabId'));
            $newTab = tab($newTabId, true)->copy($oldTab);

            return redirect()->to(request()->fullUrlWithQuery([
                'newTabId' => $newTab->getId(),
                'oldTabId' => null,
            ]));
        }

        $referrer = parse_url(request()->header('referer'));
        parse_str($referrer['query'] ?? '', $query);

        if (!(request()->query('tabId') || request()->query('newTabId') || array_key_exists('tabId', $query) || array_key_exists('newTabId', $query))) {
            return redirect()->to(request()->fullUrlWithQuery([
                'newTabId' => Str::uuid()->toString(),
                'oldTabId' => null,
            ]));
        }

        return $next($request);
    }
}
