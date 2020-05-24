<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\Adapter\Filesystem;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Wordpress\DependencyInjection\Bundle\Bundle;

class Filesystem extends Bundle
{
    protected $name = 'Filesystem';

    public function build(ContainerBuilder $containerBuilder): void
    {
        parent::build($containerBuilder);

        $loader = new XmlFileLoader($containerBuilder, new FileLocator(__DIR__ . '/DependencyInjection/'));
        $loader->load('services.xml');
    }
}