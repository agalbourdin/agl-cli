<?php
/**
 * Register autoloader if required, dynamically load commands, initialize
 * and run the application.
 */

if (! CLI) {
    exit;
}

spl_autoload_register(function($pClass)
{
    if (strpos($pClass, 'Symfony') === 0) {
        require(COMPOSER_DIR . 'symfony/console/' . str_replace('\\', '/', $pClass) . '.php');
    } else if (strpos($pClass, 'Agl\Cli') === 0) {
        require(COMPOSER_DIR . 'agl/cli/src/' . str_replace(array('Agl\Cli\\', '\\'), array('', '/'), $pClass) . '.php');
    }
});

$app = new Symfony\Component\Console\Application();

$commandDir = realpath(__DIR__ . '/Command') . DS;
$files      = \Agl\Core\Data\Dir::listFilesRecursive($commandDir);
foreach ($files as $file) {
    $class = '\Agl\Cli\Command\\' . str_replace(array(
        $commandDir,
        '.php',
        DS
    ), array(
        '',
        '',
        '\\'
    ), $file);

    $app->add(new $class);
}

$app->run();
