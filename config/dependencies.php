<?php

declare(strict_types=1);

use App\Service\AuthService;
use App\Service\PerfilUsuarioFuncdeService;
use App\Service\Settings;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Views\Twig;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use App\Twig\AssetExtension;

return [
    // Doctrine Dbal connection
    \Doctrine\DBAL\Connection::class => static function (Settings $settings, Doctrine\ORM\Configuration $conf): Doctrine\DBAL\Connection {
        return \Doctrine\DBAL\DriverManager::getConnection($settings->get('doctrine.connection'), $conf);
    },
    // Doctrine Config used by entity manager and Tracy
    \Doctrine\ORM\Configuration::class => static function (Settings $settings): Doctrine\ORM\Configuration {
        if ($settings->get('debug')) {
            $queryCache = new ArrayAdapter();
            $metadataCache = new ArrayAdapter();
        } else {
            $queryCache = new PhpFilesAdapter('queries', 0, $settings->get('cache_dir'));
            $metadataCache = new PhpFilesAdapter('metadata', 0, $settings->get('cache_dir'));
        }

        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCache($metadataCache);
        $driverImpl = new \Doctrine\ORM\Mapping\Driver\AttributeDriver($settings->get('doctrine.entity_path'), true);
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCache($queryCache);
        $config->setProxyDir($settings->get('cache_dir') . '/proxy');
        $config->setProxyNamespace('App\Proxies');

        if ($settings->get('debug')) {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        return $config;
    },
    // Doctrine EntityManager.
    EntityManager::class => static function (\Doctrine\ORM\Configuration $config, \Doctrine\DBAL\Connection $connection): EntityManager {
        return new EntityManager($connection, $config);
    },
    EntityManagerInterface::class => DI\get(EntityManager::class),
    // Settings.
    Settings::class => DI\factory([Settings::class, 'load']),
    Logger::class => static function (Settings $settings): Logger {
        $logger = new Logger($settings->get('logger.name'));
        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($settings->get('logger.path'), $settings->get('logger.level'));
        $logger->pushHandler($handler);

        return $logger;
    },
    Twig::class => static function (Settings $settings, \Twig\Profiler\Profile $profile): Twig {
        $view = Twig::create($settings->get('view.template_path'), $settings->get('view.twig'));
        if ($settings->get('debug')) {
            // Add extensions
            $view->addExtension(new \Twig\Extension\ProfilerExtension($profile));
            $view->addExtension(new \Twig\Extension\DebugExtension());
        }
        $view->addExtension(new AssetExtension(''));

        return $view;
    },
    AuthService::class=>function($container){
        return new AuthService($container);
    },
    'constante'=> static function (Settings $settings){
        return $settings->get('constantes');
    },
    'menu'=>static function (Settings $settings){
        return $settings->get('menu');
    },
    PerfilUsuarioFuncdeService::class => function($container){
        return new PerfilUsuarioFuncdeService($container);
    },
    'session'=>function(){
        return new \SlimSession\Helper();
    }
];
