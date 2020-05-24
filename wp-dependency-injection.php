<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection;

/**
 * Plugin Name:       Wordpress Dependency Injection
 * Description:       WordPress Plugin that implements Symfony Dependency Injection Component
 * Plugin URI:        https://github.com/brianvarskonst/wp-dependency-injection
 * Author:            Brianvarskonst
 * Author URI:        https://github.com/brianvarskonst
 * Version:           1.0.0
 * License:           MIT
 * Text Domain:       wp-dependency-injection
 * Requires PHP:      7.4
 */

if (! defined('ABSPATH')) {
    return;
}

if (!class_exists(PluginConfig::class) && !file_exists(__DIR__ . '/vendor/autoload.php')) {

    return;
}

$classLoader = require_once __DIR__ . '/vendor/autoload.php';

add_action('plugins_loaded', static function () {
});