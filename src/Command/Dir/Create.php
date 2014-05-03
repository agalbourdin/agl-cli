<?php
namespace Agl\Cli\Command\Dir;

use \Agl\Core\Data\Dir as DirData,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Create a directory (recursively).
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Dir
 * @version 0.1.0
 */

class Create
    extends Command
{

    /**
     * Configure the "create" command.
     */
    protected function configure()
    {
        $this
            ->setName('dir:create')
            ->setDescription('Create a directory (recursively).')
            ->addArgument(
                'dir',
                InputArgument::REQUIRED,
                'Directory to create'
            );
    }

    /**
     * Execute the "create" command.
     *
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $dir = $pInput->getArgument('dir');

        if (! DirData::create($dir)) {
            throw new Exception("Creation of directory '$dir' failed.");
        }
    }
}
