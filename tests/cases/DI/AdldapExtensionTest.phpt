<?php declare(strict_types=1);

namespace Tests\Surda\Ldap\DI;

use Adldap\Adldap;
use Surda\Adldap\DI\AdldapExtension;
use Tester\Assert;
use Tester\TestCase;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class AdldapExtensionTest extends TestCase
{
    /**
     * @param array $config
     * @return Container
     */
    protected function createContainer(array $config = []): Container
    {
        $loader = new ContainerLoader(TEMP_DIR, TRUE);
        $class = $loader->load(function (Compiler $compiler) use ($config): void {
            $compiler->addConfig($config);
            $compiler->addExtension('adldap', new AdldapExtension());
        });

        return new $class();
    }

    public function testExtension()
    {
        $container = $this->createContainer();

        $adldap = $container->getService('adldap.factory');
        Assert::true($adldap instanceof Adldap);

        $adldap = $container->getByType(Adldap::class);
        Assert::true($adldap instanceof Adldap);
    }
}

(new AdldapExtensionTest())->run();
