<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\Adapter\Filesystem\Exception;

class DuplicateFilesystemFactoryException extends \Exception
{
    public function __construct(string $type)
    {
        parent::__construct("The type of factory {$type} must be unique.");
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__DUPLICATE_FILESYSTEM_FACTORY';
    }
}