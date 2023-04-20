<?php

namespace Mintellity\TabbedSession\Entities;

use Closure;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TabSession
{
    public function __construct(
        private readonly string $tabId,
    )
    {

    }

    public function key(string|array $key): string|array
    {
        if (is_array($key))
            return collect($key)->mapWithKeys(fn($value, $key) => ['tabs.' . $this->tabId . '.' . $key => $value])->toArray();

        return 'tabs.' . $this->tabId . '.' . $key;
    }

    /**
     * Get all the session data.
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function all(): array
    {
        return session()->get('tabs.' . $this->tabId) ?? [];
    }

    /**
     * Get a subset of the session data.
     *
     * @param  array  $keys
     * @return array
     */
    public function only(array $keys): array
    {
        return session()->only($this->key($keys));
    }

    /**
     * Checks if a key exists.
     *
     * @param array|string $key
     * @return bool
     */
    public function exists(array|string $key): bool
    {
        return session()->exists($this->key($key));
    }

    /**
     * Determine if the given key is missing from the session data.
     *
     * @param array|string $key
     * @return bool
     */
    public function missing(array|string $key): bool
    {
        return session()->missing($this->key($key));
    }

    /**
     * Checks if a key is present and not null.
     *
     * @param array|string $key
     * @return bool
     */
    public function has(array|string $key): bool
    {
        return session()->has($this->key($key));
    }

    /**
     * Get an item from the session.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return session()->get($this->key($key), $default);
    }

    /**
     * Get the value of a given key and then forget it.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function pull(string $key, mixed $default = null): mixed
    {
        return session()->pull($this->key($key), $default);
    }

    /**
     * Determine if the session contains old input.
     *
     * @param string|null $key
     * @return bool
     */
    public function hasOldInput(string $key = null): bool
    {
        return session()->hasOldInput($this->key($key));
    }

    /**
     * Get the requested item from the flashed input array.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getOldInput(string $key = null, mixed $default = null): mixed
    {
        return session()->getOldInput($this->key($key), $default);
    }

    /**
     * Replace the given session attributes entirely.
     *
     * @param  array  $attributes
     * @return void
     */
    public function replace(array $attributes): void
    {
        session()->replace($this->key($attributes));
    }

    /**
     * Put a key / value pair or array of key / value pairs in the session.
     *
     * @param array|string $key
     * @param mixed|null $value
     * @return void
     */
    public function put(array|string $key, mixed $value = null): void
    {
        session()->put($this->key($key), $value);
    }

    /**
     * Get an item from the session, or store the default value.
     *
     * @param string $key
     * @param Closure $callback
     * @return mixed
     */
    public function remember(string $key, Closure $callback): mixed
    {
        return session()->remember($this->key($key), $callback);
    }

    /**
     * Push a value onto a session array.
     *
     * @param string $key
     * @param  mixed  $value
     * @return void
     */
    public function push(string $key, mixed $value): void
    {
        session()->push($this->key($key), $value);
    }

    /**
     * Increment the value of an item in the session.
     *
     * @param string $key
     * @param int $amount
     * @return int
     */
    public function increment(string $key, int $amount = 1): int
    {
        return session()->increment($this->key($key), $amount);
    }

    /**
     * Decrement the value of an item in the session.
     *
     * @param string $key
     * @param int $amount
     * @return int
     */
    public function decrement(string $key, int $amount = 1): int
    {
        return session()->decrement($this->key($key), $amount);
    }

    /**
     * Flash a key / value pair to the session.
     *
     * @param  string  $key
     * @param bool|mixed $value
     * @return void
     */
    public function flash(string $key, mixed $value = true): void
    {
        session()->flash($this->key($key), $value);
    }

    /**
     * Flash a key / value pair to the session for immediate use.
     *
     * @param string $key
     * @param  mixed  $value
     * @return void
     */
    public function now(string $key, mixed $value): void
    {
        session()->now($this->key($key), $value);
    }

    /**
     * Reflash a subset of the current flash data.
     *
     * @param mixed|null $keys
     * @return void
     */
    public function keep(mixed $keys = null): void
    {
        session()->keep($this->key($keys));
    }

    /**
     * Remove an item from the session, returning its value.
     *
     * @param string $key
     * @return mixed
     */
    public function remove(string $key): mixed
    {
        return session()->remove($this->key($key));
    }

    /**
     * Remove one or many items from the session.
     *
     * @param array|string $keys
     * @return void
     */
    public function forget(array|string $keys): void
    {
        session()->forget($this->key($keys));
    }
}
