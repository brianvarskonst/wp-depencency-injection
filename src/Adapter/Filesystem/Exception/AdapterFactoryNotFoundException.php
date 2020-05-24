<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\Adapter\Filesystem\Exception;

class AdapterFactoryNotFoundException extends \Exception
{
    public function __construct(string $type)
    {
        parent::__construct("Adapter factory for type {$type} was not found.");
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__FILESYSTEM_ADAPTER_NOT_FOUND';
    }
}