<?php

namespace Framework\Session;

use Framework\Contracts\SessionInterface;

class Session implements SessionInterface
{

    public function start(): void
    {
        session_start();
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function regenerate(): void
    {
        session_regenerate_id();
    }

    public function set(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    public function get(string $name)
    {
        return $_SESSION[$name];
    }

    public function delete(string $name)
    {
        unset($_SESSION[$name]);
    }
}