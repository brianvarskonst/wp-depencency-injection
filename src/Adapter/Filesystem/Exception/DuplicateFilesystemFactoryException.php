<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\Adapter\Filesystem\Exception;

use Wordpress\DependencyInjection\Exception\PluginException;

class DuplicateFilesystemFactoryException extends PluginException
{
    public function __construct(string $type)
    {
        parent::__construct('The type of factory "{{ type }}" must be unique.', ['type' => $type]);
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__DUPLICATE_FILESYSTEM_FACTORY';
    }
}