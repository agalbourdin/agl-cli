<?php
namespace Agl\Cli\Command\Chmod;

use Agl\Cli\Command\CommandInterface,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Chmod a file or a directory.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Chmod
 * @version 0.1.0
 */

class Chmod
    extends Command
        implements CommandInterface
{

    /**
     * Configure the "create" command.
     */
    protected function configure()
    {
        $this
            ->setName('chmod')
            ->setDescription('CHMOD a file or a directory.')
            ->addArgument(
                'target',
                InputArgument::REQUIRED,
                'File or directory'
            )
            ->addArgument(
                'chmod',
                InputArgument::REQUIRED,
                'CHMOD to apply (integer, ex: 755)'
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
        $target = $pInput->getArgument('target');
        $chmod  = $pInput->getArgument('chmod');

        if (strpos($chmod, '0') !== 0) {
            $mode = octdec('0' . $chmod);
        } else {
            $mode = octdec($chmod);
        }

        if (! chmod($target, $mode)) {
            throw new Exception("CHMOD '$chmod' can't be applied to '$target'.");
        }

        $pOutput->writeln(static::EXEC_RETURN_SUCCESS);
    }
}
