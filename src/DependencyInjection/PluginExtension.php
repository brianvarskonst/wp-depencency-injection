<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class PluginExtension extends Extension
{
    private const ALIAS = "plugin";

    public function getAlias(): string
    {
        return self::ALIAS;
    }

    public function load(array $configs, ContainerBuilder $containerBuilder): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $this->addConfiguration($containerBuilder, $this->getAlias(), $config);
    }

    private function addConfiguration(
        ContainerBuilder $containerBuilder,
        string $alias,
        array $options
    ): void {
        foreach ($options as $key => $option) {
            $key = "{$alias}.{$key}";
            $containerBuilder->setParameter($key, $option);

            if (\is_array($option)) {
                $this->addConfiguration($containerBuilder, $key, $option);
            }
        }
    }
}