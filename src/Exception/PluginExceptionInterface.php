<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\Exception;

interface PluginExceptionInterface extends \Throwable
{
    public function getErrorCode(): string;

    public function getParameters(): array;
}