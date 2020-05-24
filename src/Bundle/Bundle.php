<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\Bundle;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

abstract class Bundle implements BundleInterface
{
    use ContainerAwareTrait;

    protected $name;
    protected $extension;
    protected $path;
    private $namespace;

    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function shutdown(): void
    {
    }

    /**
     * {@inheritdoc}
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     */
    public function build(): void
    {
    }

    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface|null The container extension
     *
     * @throws \LogicException
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if ($this->extension === null) {
            $extension = $this->createContainerExtension();

            switch(true) {
                case $extension !== null:
                    if (!$extension instanceof ExtensionInterface) {
                        throw new \LogicException(sprintf('Extension "%s" must implement Symfony\Component\DependencyInjection\Extension\ExtensionInterface.', get_debug_type($extension)));
                    }

                    // check naming convention
                    // TODO: Maybe check if the Extension cannot be found because of Bundle
                    $basename = preg_replace('/Bundle$/', '', $this->getName());
                    $expectedAlias = Container::underscore($basename);

                    if ($expectedAlias !== $extension->getAlias()) {
                        throw new \LogicException(sprintf('Users will expect the alias of the default extension of a bundle to be the underscored version of the bundle name ("%s"). You can override "Bundle::getContainerExtension()" if you want to use "%s" or another alias.', $expectedAlias, $extension->getAlias()));
                    }

                    $this->extension = $extension;

                    break;
                case $extension === null:
                default:
                    $this->extension = false;
                    break;
            }
        }

        return $this->extension ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace(): ?string
    {
        if ($this->namespace === null) {
            $this->parseClassName();
        }

        return $this->namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        if ($this->path === null) {
            $reflected = new \ReflectionObject($this);
            $this->path = \dirname($reflected->getFileName());
        }

        return $this->path;
    }

    /**
     * Returns the bundle name (the class short name).
     */
    final public function getName(): string
    {
        if ($this->name === null) {
            $this->parseClassName();
        }

        return $this->name;
    }

    /**
     * Returns the bundle's container extension class.
     *
     * @return string
     */
    protected function getContainerExtensionClass(): string
    {
        $basename = preg_replace('/Bundle$/', '', $this->getName());

        return $this->getNamespace().'\\DependencyInjection\\'.$basename.'Extension';
    }

    /**
     * Creates the bundle's container extension.
     *
     * TODO: Check return type can be bot nullable, instead return false
     *
     * @return ExtensionInterface|null
     */
    protected function createContainerExtension(): ?bool
    {
        $class = $this->getContainerExtensionClass();

        return class_exists( ($class) ? new $class() : null);
    }

    private function parseClassName(): void
    {
        $pos = strrpos(static::class, '\\');

        $this->namespace = $pos === false ? '' : substr(static::class, 0, $pos);

        if ($this->name === false) {
            $this->name = $pos === false ? static::class : substr(static::class, $pos + 1);
        }
    }
}
