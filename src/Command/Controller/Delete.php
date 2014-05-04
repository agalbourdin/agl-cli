<?php
namespace Agl\Cli\Command\Controller;

use \Agl\Core\Agl,
    \Agl\Core\Data\Dir as DirData,
    \Agl\Core\Data\File as FileData,
    \Agl\Core\Mvc\Controller\Controller,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Delete AGL Controller.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Controller
 * @version 0.1.0
 */

class Delete
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('controller:delete')
            ->setDescription('Delete AGL Controller.')
            ->addArgument(
                'controller',
                InputArgument::REQUIRED,
                'Controller name (ex: home/index)'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $controller = $pInput->getArgument('controller');
        if (! preg_match('/^([a-z0-9]+)\/([a-z0-9_-]+)$/', $controller)) {
            throw new Exception("Controller syntax is incorrect");
        }

        $controllerArr = explode('/', $controller);

        $classDir = APP_PATH
                    . Agl::APP_PHP_DIR
                    . Controller::APP_PHP_DIR
                    . DS
                    . $controllerArr[0]
                    . DS;

        $classFile = $classDir . $controllerArr[1] . Agl::PHP_EXT;

        if (file_exists($classFile)) {
            FileData::delete($classFile);
        }

        DirData::delete($classDir);
    }
}
