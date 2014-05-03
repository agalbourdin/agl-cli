<?php
namespace Agl\Cli\Command\File;

use \Agl\Core\Data\File as FileData,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Replace a string by another in a file content, then save file.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_File
 * @version 0.1.0
 */

class Replace
    extends Command
{

    /**
     * Configure the "replace" command.
     */
    protected function configure()
    {
        $this
            ->setName('file:replace')
            ->setDescription('Replace string by another string and save file.')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'File path'
            )
            ->addArgument(
                'to_replace',
                InputArgument::REQUIRED,
                'String to replace'
            )
            ->addArgument(
                'replace_by',
                InputArgument::REQUIRED,
                'Replace by this string'
            );
    }

    /**
     * Execute the "copy" command.
     *
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $file      = $pInput->getArgument('file');
        $toReplace = $pInput->getArgument('to_replace');
        $replaceBy = $pInput->getArgument('replace_by');

        $content = file_get_contents($file);
        $content = str_replace($toReplace, $replaceBy, $content);
        if (! FileData::write($file, $content)) {
            throw new Exception("Content replacement in '$file' failed.");
        }
    }
}
