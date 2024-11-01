<?php

return [
    'displayErrorDetails' => 'prod' !== $app->getEnvironment(),
    'determineRouteBeforeAppMiddleware' => true,
    'addContentLengthHeader' => true
];
