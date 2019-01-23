# Adldap2

[Adldap2](https://github.com/Adldap2/Adldap2) integration into Nette Framework.

## Installation

The recommended way to is via Composer:

```
composer require surda/adldap2-nette
```

After that you have to register extension in config.neon:

```yaml
extensions:
    adldap: Surda\Adldap\DI\AdldapExtension
```

## Minimal configuration

```yaml
adldap:
    hosts: { 'corp-dc1.corp.acme.org', 'corp-dc2.corp.acme.org' }
    base_dn: 'dc=corp,dc=acme,dc=org'
    username: 'admin'
    password: 'password'
```

List of all configuration options:
```yaml
adldap:
    # Mandatory configuration options
    hosts: { 'corp-dc1.corp.acme.org', 'corp-dc2.corp.acme.org' }
    base_dn: 'dc=corp,dc=acme,dc=org'
    username: 'admin'
    password: 'password'

    # Optional configuration options
    schema: \Adldap\Schemas\ActiveDirectory
    account_prefix: 'ACME-'
    account_suffix: '@@acme.org'
    port: 389
    follow_referrals: FALSE
    use_ssl: false
    use_tls: false
    version: 3
    timeout: 5
```

## Usage

```php
use Adldap\Adldap;

class Foo
{
    /** @var Adldap */
    private $adldap;

    /**
     * @param Adldap $adldap
     */
    public function __construct(Adldap $adldap)
    {
        $this->adldap = $adldap;
    }

    public function bar()
    {
        $provider = $this->adldap->connect();
        // ...
    }
}
```

More in the [Adldap2 documentation](http://adldap2.github.io/Adldap2/).
