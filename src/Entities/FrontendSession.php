<?php

namespace Mintellity\LaravelTabbedSession\Entities;

class FrontendSession
{
    private array $frontendCookie;

    public function __construct(
        private readonly string $tabId,
    ) {
        $this->frontendCookie = json_decode(request()->cookie(config('tabbed-session.frontend-cookie-name'), '{}'), true);
    }

    /**
     * Get all frontend session data.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->frontendCookie[$this->tabId] ?? [];
    }

    public function get(string $key): mixed
    {
        return $this->all()[$key] ?? null;
    }

    public function set(string $key, mixed $value): void
    {
        if (!isset($this->frontendCookie[$this->tabId])) {
            $this->frontendCookie[$this->tabId] = [];
        }

        $this->frontendCookie[$this->tabId][$key] = $value;

        setcookie(config('tabbed-session.frontend-cookie-name'), json_encode($this->frontendCookie));
    }
}
