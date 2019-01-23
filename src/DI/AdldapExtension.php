<?php declare(strict_types=1);

namespace Surda\Adldap\DI;

use Adldap\Adldap;
use Adldap\Schemas\ActiveDirectory;
use Nette\DI\CompilerExtension;

class AdldapExtension extends CompilerExtension
{
    /** @var array */
    public $defaults = [
        // Mandatory Configuration Options
        'hosts' => [],
        'base_dn' => NULL,
        'username' => NULL,
        'password' => NULL,

        // Optional Configuration Options
        'schema' => ActiveDirectory::class,
        'account_prefix' => 'ACME-',
        'account_suffix' => '@@acme.org',
        'port' => 389,
        'follow_referrals' => FALSE,
        'use_ssl' => FALSE,
        'use_tls' => FALSE,
        'version' => 3,
        'timeout' => 5,

        // Custom LDAP Options
        'custom_options' => [
            // See: http://php.net/ldap_set_option
            LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_HARD
        ]
    ];

    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        $builder->addDefinition($this->prefix('adldap'))
            ->setFactory(Adldap::class)
            ->addSetup('addProvider', [$config]);
    }
}