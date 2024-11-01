<?php

$json = file_get_contents(__DIR__ . '/../database.json');
$database = json_decode($json);

$array = [
    'path' => [
        $app->getRootDir() . '/templates'
    ],
    'options' => [
        'cache' => $app->getCacheDir() . '/twig',
    ]
];

if (isset($_SERVER['REQUEST_URI'])) {
  $url = explode("/", $_SERVER['REQUEST_URI']);
  if (isset($url[1])
    && ($url[1] == 'log-usuario' || $url[1] == 'log-sistema')
  ) {
    $array['options']['debug'] = true;
  }
}

$arrayRetorno = [
  'twig' => $array,
  'monolog' => [
    'name' => 'app',
    'path' => $app->getLogDir() . '/' . $app->getEnvironment() . '_' . str_replace('.', '_', $app->getIp()) . '-' . date("d-m-Y") . '.log',
    'level' => Monolog\Logger::ERROR
  ],
  'doctrine' => [
    'driver' => $_SERVER['APP_DATABASE_DRIVER'],
    'host' => $database->APP_DATABASE_HOST,
    'port' => $database->APP_DATABASE_PORT,
    'user' => $database->APP_DATABASE_USERNAME,
    'password' => $database->APP_DATABASE_PASSWORD,
    'dbname' => $database->APP_DATABASE_DATABASE,
    'service' => $_SERVER['APP_DATABASE_SERVICE'],
    'servicename' => $database->APP_DATABASE_SERVICENAME,
    'charset' => $_SERVER['APP_DATABASE_CHARSET'],
    'pooled' => true,
    'persistent' => true
  ]
];


return $arrayRetorno;