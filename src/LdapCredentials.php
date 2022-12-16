<?php declare(strict_types=1);

namespace Surda\Adldap;

class LdapCredentials
{
    public function __construct(private string $username, private string $password, private string $dn)
    {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDn(): string
    {
        return $this->dn;
    }
}