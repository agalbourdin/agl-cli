<?php
namespace Agl\Cli\Command\Dir;

use \Agl\Core\Data\Dir as DirData,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Delete a directory (recursively if requested).
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Dir
 * @version 0.1.0
 */

class Delete
    extends Command
{

    /**
     * Configure the "delete" command.
     */
    protected function configure()
    {
        $this
            ->setName('dir:delete')
            ->setDescription('Delete a directory (recursively).')
            ->addArgument(
                'dir',
                InputArgument::REQUIRED,
                'Directory to delete'
            )
            ->addOption(
               'recursive',
               NULL,
               InputOption::VALUE_NONE,
               'Delete recursively'
            );
    }

    /**
     * Execute the "delete" command.
     *
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $dir       = $pInput->getArgument('dir');
        $recursive = $pInput->getOption('recursive');

        if ($recursive) {
            DirData::deleteRecursive($dir);
        } else if (! DirData::delete($dir)) {
            throw new Exception("Deletion of directory '$dir' failed: directory is not empty");
        }
    }
}
