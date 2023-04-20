<?php

namespace Mintellity\TabbedSession\Entities;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Tab
{
    public function __construct(
        private readonly string $tabId,
        private readonly bool   $isNew = false,
    )
    {
    }

    /**
     * Get the id of this tab.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->tabId;
    }


    /**
     * If this tab was newly created in the last request.
     *
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->isNew;
    }

    /**
     * Access the tabs session data.
     *
     * @return TabSession
     */
    public function session(): TabSession
    {
        return app(TabSession::class, ['tabId' => $this->tabId]);
    }

    /**
     * Copy all session data form the old tab to this tab.
     *
     * @param Tab $tab
     * @return $this
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function copy(Tab $tab): Tab
    {
        $this->session()->put($tab->session()->all());

        return $this;
    }
}
