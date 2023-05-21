<?php

namespace Atournayre\Bundle\FixtureBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class FixtureExtension extends Extension
{
    public const ALIAS = 'atournayre_fixture';

    public function getAlias(): string
    {
        return self::ALIAS;
    }

    public static function parameterFullName(string $name): string
    {
        return sprintf('%s.%s', self::ALIAS, $name);
    }

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @return void
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('services.php');

        $container->setParameter(self::parameterFullName('ending_message'), $config['ending_message']);
    }
}
