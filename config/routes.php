<?php

use App\Application;

return static function (Application $app) {
    // $app->get('/[{name}]', App\Action\HomepageAction::class)->setName('home');
    $app->get('/', callable: [\App\Controller\HomeController::class, 'index'])->setName('home');

};
