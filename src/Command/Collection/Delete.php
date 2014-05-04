<?php
namespace Agl\Cli\Command\Collection;

use \Agl\Core\Agl,
    \Agl\Core\Data\File as FileData,
    \Agl\Core\Db\Collection\CollectionInterface,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Delete AGL Collection.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Collection
 * @version 0.1.0
 */

class Delete
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('collection:delete')
            ->setDescription('Delete AGL Collection.')
            ->addArgument(
                'collection',
                InputArgument::REQUIRED,
                'Collection name (ex: user)'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $collection = $pInput->getArgument('collection');
        if (! preg_match('/^[a-z0-9_-]+$/', $collection)) {
            throw new Exception("Collection syntax is incorrect");
        }

        $classDir = APP_PATH
                    . Agl::APP_PHP_DIR
                    . CollectionInterface::APP_PHP_DIR
                    . DS;

        $classFile    = $classDir . $collection . Agl::PHP_EXT;

        if (file_exists($classFile)) {
            FileData::delete($classFile);
        }
    }
}
