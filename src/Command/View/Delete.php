<?php
namespace Agl\Cli\Command\View;

use \Agl\Core\Agl,
    \Agl\Core\Data\Dir as DirData,
    \Agl\Core\Data\File as FileData,
    Agl\Core\Mvc\View\Type\Html,
    \Agl\Core\Mvc\View\ViewInterface,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Delete AGL HTML View.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_View
 * @version 0.1.0
 */

class Delete
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('view:delete')
            ->setDescription('Delete AGL HTML View.')
            ->addArgument(
                'view',
                InputArgument::REQUIRED,
                'View name (ex: home/download)'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $view = $pInput->getArgument('view');
        if (! preg_match('/^([a-z0-9]+)\/([a-z0-9_-]+)$/', $view)) {
            throw new Exception("View syntax is incorrect");
        }

        $viewArr = explode('/', $view);

        $classDir = APP_PATH
                    . Agl::APP_PHP_DIR
                    . ViewInterface::APP_PHP_DIR
                    . DS
                    . $viewArr[0]
                    . DS;

        $templateDir = APP_PATH
                    . Agl::APP_TEMPLATE_DIR
                    . ViewInterface::APP_HTTP_DIR
                    . DS
                    . $viewArr[0]
                    . DS;

        $classFile    = $classDir . $viewArr[1] . Agl::PHP_EXT;
        $templateFile = $templateDir . $viewArr[1] . Agl::PHP_EXT;

        if (file_exists($classFile)) {
            FileData::delete($classFile);
        }

        if (file_exists($templateFile)) {
            FileData::delete($templateFile);
        }

        DirData::delete($classDir);
        DirData::delete($templateDir);
    }
}
