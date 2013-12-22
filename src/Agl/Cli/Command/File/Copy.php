<?php
namespace Agl\Cli\Command\File;

use Agl\Cli\Command\CommandInterface,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Copy a file from a source to a destination, and override it if requested.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_File
 * @version 0.1.0
 */

class Copy
    extends Command
        implements CommandInterface
{

    /**
     * Configure the "copy" command.
     */
    protected function configure()
    {
        $this
            ->setName('file:copy')
            ->setDescription('Copy file from source to destination.')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'Source file'
            )
            ->addArgument(
                'destination',
                InputArgument::REQUIRED,
                'Destination file'
            )
            ->addOption(
               'override',
               NULL,
               InputOption::VALUE_NONE,
               'Override destination file.'
            )
        ;
    }

    /**
     * Execute the "copy" command.
     *
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $source      = $pInput->getArgument('source');
        $destination = $pInput->getArgument('destination');
        $override    = $pInput->getOption('override');

        $destinationDir = dirname($destination);

        if ((is_dir($destinationDir) and ! is_writable($destinationDir))
            or (! is_dir($destinationDir) and ! mkdir($destinationDir, 0777, true))
            or ! copy($source, $destination)) {
            throw new Exception("Copy of '$source' to '$destination' failed.");
        }

        $pOutput->writeln(static::EXEC_RETURN_SUCCESS);
    }
}
