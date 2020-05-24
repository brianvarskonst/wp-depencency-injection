<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\Adapter\Filesystem\Exception;

use Wordpress\DependencyInjection\Exception\PluginException;

class AdapterFactoryNotFoundException extends PluginException
{
    public function __construct(string $type)
    {
        parent::__construct(
            'Adapter factory for type "{{ type }}" was not found.',
            ['type' => $type]
        );
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__FILESYSTEM_ADAPTER_NOT_FOUND';
    }
}