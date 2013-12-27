<?php
namespace Agl\Cli\Command\Dir;

use Agl\Cli\Command\CommandInterface,
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
        implements CommandInterface
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

        if (! is_dir($dir) and ! mkdir($dir, 0777, true)) {
            throw new Exception("Creation of directory '$dir' failed.");
        }

        $pOutput->writeln(static::EXEC_RETURN_SUCCESS);
    }
}
