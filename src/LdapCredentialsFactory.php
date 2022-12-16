<?php declare(strict_types=1);

namespace Surda\Adldap;

class LdapCredentialsFactory
{
    public function __construct(private string $upnPrefix, private string $upnSuffix)
    {
    }

    public function create(string $username, string $password): LdapCredentials
    {
        if (strpos($username, '\\') !== FALSE) {
            [$upn, $username] = explode('\\', $username);
            $dn = sprintf('%s\%s', $upn, $username);
        } elseif (strpos($username, '@') !== FALSE) {
            [$username, $upn] = explode('@', $username);
            $dn = sprintf('%s@%s', $username, $upn);
        } else {
            $dn = sprintf('%s%s%s', $this->upnPrefix, $username, $this->upnSuffix);
        }

        return new LdapCredentials($username, $password, $dn);
    }
}