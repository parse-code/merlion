<?php

namespace Merlion\Components\Concerns\Panel;

use Closure;

trait HasAuth
{
    protected string $guard = 'web';
    protected bool $login = true;

    protected Closure $canAccessUsing;

    public function login($login): static
    {
        $this->login = $login;
        return $this;
    }

    public function withLogin(): bool
    {
        return $this->login;
    }

    public function getLoginUrl()
    {
        return $this->route('login');
    }

    public function getGuard(): string
    {
        return $this->guard;
    }

    public function getAuthCredential(): array
    {
        return ['email', 'password'];
    }

    public function auth()
    {
        return auth($this->guard);
    }

    public function canAccessUsing(Closure $canAccess): static
    {
        $this->canAccessUsing = $canAccess;
        return $this;
    }

    public function canAccess($user): bool
    {
        if (!empty($this->canAccessUsing)) {
            return call_user_func($this->canAccessUsing, $user);
        }
        return true;
    }
}
