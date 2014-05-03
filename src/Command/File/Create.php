<?php
namespace Agl\Cli\Command\File;

use \Agl\Core\Data\Dir as DirData,
    \Agl\Core\Data\File as FileData,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Create an empty file , and override it if requested.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_File
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
            ->setName('file:create')
            ->setDescription('Create new file.')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'File to create'
            )
            ->addOption(
               'override',
               NULL,
               InputOption::VALUE_NONE,
               'Override if file exists'
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
        $file     = $pInput->getArgument('file');
        $override = $pInput->getOption('override');

        if (! file_exists($file) or $override) {
            $fileDir = dirname($file);

            if (! DirData::create($fileDir) or ! FileData::create($file)) {
                throw new Exception("Creation of '$file' failed.");
            }
        }
    }
}
