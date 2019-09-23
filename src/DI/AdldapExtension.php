<?php declare(strict_types=1);

namespace Surda\Adldap\DI;

use Adldap\Adldap;
use Adldap\Schemas\ActiveDirectory;
use Nette\DI\Definitions\Statement;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class AdldapExtension extends CompilerExtension
{
    public function getConfigSchema(): Schema
    {
        return Expect::structure([
            // Mandatory Configuration Options
            'hosts' => Expect::array()
                ->default([]),
            'base_dn' => Expect::string()
                ->default(NULL),
            'username' => Expect::string()
                ->default(NULL),
            'password' => Expect::string()
                ->default(NULL),

            // Optional Configuration Options
            'schema' => Expect::anyOf(
                Expect::string(),
                Expect::type(Statement::class)
            )->default(ActiveDirectory::class),
            'account_prefix' => Expect::string()
                ->default(''),
            'account_suffix' => Expect::string()
                ->default(''),
            'port' => Expect::int()
                ->default(389),
            'follow_referrals' => Expect::bool()
                ->default(FALSE),
            'use_ssl' => Expect::bool()
                ->default(FALSE),
            'use_tls' => Expect::bool()
                ->default(FALSE),
            'version' => Expect::int()
                ->default(3),
            'timeout' => Expect::int()
                ->default(5),

            // Custom LDAP Options
            'custom_options' => Expect::array()
                ->default([
                    // See: http://php.net/ldap_set_option
                    LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_HARD,
                ]),
        ]);
    }

    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('factory'))
            ->setFactory(Adldap::class)
            ->addSetup('addProvider', [(array) $this->config]);
    }
}