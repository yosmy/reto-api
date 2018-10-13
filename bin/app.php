<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Debug\Debug;
use Symsonte\Cli\App;
use Symsonte\ServiceKit\PerpetualCachedContainer;

Debug::enable();

$app = new App(new PerpetualCachedContainer(
    sprintf('%s/../config/parameters.yml', __DIR__),
    [],
    sprintf('%s/../var/cache', __DIR__),
    ['Reto\\', 'Yosmy\\', 'Symsonte\\']
));
$app->execute(
    'reto.cli.server.command_dispatcher',
    sprintf('%s/../src', __DIR__)
);
