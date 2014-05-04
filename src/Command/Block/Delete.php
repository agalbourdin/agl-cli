<?php
namespace Agl\Cli\Command\Block;

use \Agl\Core\Agl,
    \Agl\Core\Data\Dir as DirData,
    \Agl\Core\Data\File as FileData,
    \Agl\Core\Mvc\Block\BlockInterface,
    Agl\Core\Mvc\View\Type\Html,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Delete AGL Block.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Block
 * @version 0.1.0
 */

class Delete
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('block:delete')
            ->setDescription('Delete AGL Block.')
            ->addArgument(
                'block',
                InputArgument::REQUIRED,
                'Block ID (ex: page/nav)'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $block = $pInput->getArgument('block');
        if (! preg_match('#^([a-z0-9]+)/([a-z0-9_-]+)$#', $block)) {
            throw new Exception("Block syntax is incorrect");
        }

        $blockArr = explode('/', $block);

        $classDir = APP_PATH
                    . Agl::APP_PHP_DIR
                    . BlockInterface::APP_PHP_DIR
                    . DS
                    . $blockArr[0]
                    . DS;

        $templateDir = APP_PATH
                    . Agl::APP_TEMPLATE_DIR
                    . BlockInterface::APP_HTTP_DIR
                    . DS
                    . $blockArr[0]
                    . DS;

        $classFile    = $classDir . $blockArr[1] . Agl::PHP_EXT;
        $templateFile = $templateDir . $blockArr[1] . Html::FILE_EXT;

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
