<?php

use Mintellity\LaravelTabbedSession\Entities\Tab;
use Mintellity\LaravelTabbedSession\Exceptions\NoTabIdFoundException;


/**
 * Get the tab instance.
 *
 * @param string|null $tabId
 * @param bool $isNew
 * @return Tab
 * @throws NoTabIdFoundException
 */
function tab(string $tabId = null, bool $isNew = false): Tab
{
    if ($tabId) {
        return app(Tab::class, [
            'tabId' => $tabId,
            'isNew' => $isNew,
        ]);
    }

    if (request()->query('tabId')) {
        return app(Tab::class, [
            'tabId' => request()->query('tabId'),
        ]);
    }

    if (request()->query('newTabId')) {
        return app(Tab::class, [
            'tabId' => request()->query('newTabId'),
            'isNew' => true,
        ]);
    }

    $referrer = parse_url(request()->header('referer'));
    parse_str($referrer['query'] ?? '', $query);

    if (array_key_exists('tabId', $query)) {
        return app(Tab::class, [
            'tabId' => $query['tabId'],
        ]);
    }

    if (array_key_exists('newTabId', $query)) {
        return app(Tab::class, [
            'tabId' => $query['newTabId'],
            'isNew' => true,
        ]);
    }

    throw new NoTabIdFoundException();
}
