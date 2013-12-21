<?php
namespace Agl\Cli;

use Symfony\Component\Console\Application;

$app = new Application();

$app->add(new \Agl\Cli\Command\File\Copy());
$app->add(new \Agl\Cli\Command\File\Replace());

$app->run();
