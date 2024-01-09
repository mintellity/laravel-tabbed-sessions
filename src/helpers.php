<?php

use Mintellity\LaravelTabbedSession\Entities\Tab;
use Mintellity\LaravelTabbedSession\Exceptions\NoTabIdFoundException;
use Mintellity\LaravelTabbedSession\Exceptions\TabDisabledException;
use Mintellity\LaravelTabbedSession\LaravelTabbedSession;

/**
 * Get the tab instance.
 *
 * @throws NoTabIdFoundException
 * @throws TabDisabledException
 */
function browserTab(string $tabId = null, bool $isNew = false): Tab
{
    if ($tabId) {
        return app(Tab::class, [
            'tabId' => $tabId,
            'isNew' => $isNew,
        ]);
    }

    if (LaravelTabbedSession::disabledForPath()) {
        throw new TabDisabledException();
    }

    if (request()->query(LaravelTabbedSession::getTabQueryParameterName())) {
        return app(Tab::class, [
            'tabId' => request()->query(LaravelTabbedSession::getTabQueryParameterName()),
        ]);
    }

    if (request()->query(LaravelTabbedSession::getTabQueryParameterName('new'))) {
        return app(Tab::class, [
            'tabId' => request()->query(LaravelTabbedSession::getTabQueryParameterName('new')),
            'isNew' => true,
        ]);
    }

    $referrer = parse_url(request()->header('referer'));
    parse_str($referrer['query'] ?? '', $query);

    if (array_key_exists(LaravelTabbedSession::getTabQueryParameterName(), $query)) {
        return app(Tab::class, [
            'tabId' => $query[LaravelTabbedSession::getTabQueryParameterName()],
        ]);
    }

    if (array_key_exists(LaravelTabbedSession::getTabQueryParameterName('new'), $query)) {
        return app(Tab::class, [
            'tabId' => $query[LaravelTabbedSession::getTabQueryParameterName('new')],
            'isNew' => true,
        ]);
    }

    throw new NoTabIdFoundException();
}
