<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\IniFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Wordpress\DependencyInjection\Bundle\Bundle;
use Wordpress\DependencyInjection\DependencyInjection\PluginExtension;

class Plugin extends Bundle
{
    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    /**
     * @var string
     */
    private string $env;

    /**
     * Plugin constructor.
     *
     * @param string $env
     */
    public function __construct(string $env) {
        $this->env = $env;
    }

    public function getContainerExtension(): Extension
    {
        return new PluginExtension();
    }

    public function build(ContainerBuilder $containerBuilder): void
    {
        $this->buildConfiguration(
            $containerBuilder,
            $this->env
        );

        $loader = new XmlFileLoader(
            $containerBuilder,
            new FileLocator(__DIR__ . '/DependencyInjection/')
        );
        $loader->load('services.xml');
        $loader->load('filesystem.xml');

        parent::build($containerBuilder);
    }

    public function buildConfiguration(ContainerBuilder $containerBuilder, $environment): void
    {
        $locator = new FileLocator('Resources/config');

        $resolver = new LoaderResolver([
            new XmlFileLoader($containerBuilder, $locator),
            new YamlFileLoader($containerBuilder, $locator),
            new IniFileLoader($containerBuilder, $locator),
            new PhpFileLoader($containerBuilder, $locator),
            new GlobFileLoader($containerBuilder, $locator),
            new DirectoryLoader($containerBuilder, $locator),
            new ClosureLoader($containerBuilder),
        ]);

        $configLoader = new DelegatingLoader($resolver);
        $configDirectory = $this->getPath() . '/Resources/config';

        if (is_readable("{$configDirectory}/packages/")) {
            $configLoader->load("{$configDirectory}/{packages}/*" . self::CONFIG_EXTS, 'glob');
            $configLoader->load("{$configDirectory}/{packages}/{$environment}/*" . self::CONFIG_EXTS, 'glob');
        }
    }
}