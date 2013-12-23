<?php
if (! CLI) {
    exit;
}

spl_autoload_register(function($pClass)
{
    if (strpos($pClass, 'Symfony') === 0) {
        require(COMPOSER_DIR . 'symfony/console/' . str_replace('\\', '/', $pClass) . '.php');
    } else if (strpos($pClass, 'Agl\Cli') === 0) {
        require(COMPOSER_DIR . 'agl/cli/src/' . str_replace('\\', '/', $pClass) . '.php');
    }
});

$app = new Symfony\Component\Console\Application();

$app->add(new \Agl\Cli\Command\File\Copy());
$app->add(new \Agl\Cli\Command\File\Replace());

$app->run();
