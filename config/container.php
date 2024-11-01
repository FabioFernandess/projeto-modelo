<?php

use App\Application;
use App\Services\Settings;
use App\Services\UsuarioService;
use App\Twig\AssetExtension;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;

return static function (Application $app, ContainerBuilder $container) {
    $container->addDefinitions([
        Settings::class => DI\factory([Settings::class, 'load']),
        LoggerInterface::class => static function () use ($app) {
            return (new Logger('main'))
                ->pushProcessor(new UidProcessor())
                ->pushHandler(new StreamHandler($app->getLogsDir().'/'.$app->getEnvironment().'.log', Logger::DEBUG));
        },
        Twig::class => static function () use ($app) {
            $twig = Twig::create($app->getProjectDir().'/template', [
                'cache' => $app->getCacheDir().'/twig',
                'debug' => $app->getEnvironment() !== 'prod'
            ]);

            $twig->addExtension(new AssetExtension($app->getBasePath()));

            return $twig;
        },
        \Doctrine\DBAL\Connection::class => static function (Settings $settings, Doctrine\ORM\Configuration $conf): Doctrine\DBAL\Connection {
            return \Doctrine\DBAL\DriverManager::getConnection($settings->get('doctrine.connection'), $conf);
        },
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
        'em' => static function (\Doctrine\ORM\Configuration $config, \Doctrine\DBAL\Connection $connection): EntityManager {
            return new EntityManager($connection, $config);
        },
        'usuarioService'=>function($container){
            return new UsuarioService($container);
        },  
    ]);
};
