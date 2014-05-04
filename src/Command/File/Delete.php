<?php
namespace Agl\Cli\Command\File;

use \Agl\Core\Data\File as FileData,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Delete a file.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_File
 * @version 0.1.0
 */

class Delete
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('file:delete')
            ->setDescription('Delete file.')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'File to delete'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $file = $pInput->getArgument('file');

        if (! FileData::delete($file)) {
            throw new Exception("Deletion of '$file' failed.");
        }
    }
}
