<?php
namespace Agl\Cli\Command\Collection;

use \Agl\Core\Agl,
    \Agl\Core\Data\File as FileData,
    \Agl\Core\Db\Collection\CollectionInterface,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Create a new AGL Collection.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Collection
 * @version 0.1.0
 */

class Create
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('collection:create')
            ->setDescription('Create new AGL Collection.')
            ->addArgument(
                'collection',
                InputArgument::REQUIRED,
                'Collection name (ex: user)'
            )
            ->addOption(
               'override',
               NULL,
               InputOption::VALUE_NONE,
               'Override if Collection exists'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $collection = $pInput->getArgument('collection');
        $override   = $pInput->getOption('override');

        if (! preg_match('/^[a-z0-9_-]+$/', $collection)) {
            throw new Exception("Collection syntax is incorrect");
        }

        $classDir = APP_PATH
                    . Agl::APP_PHP_DIR
                    . CollectionInterface::APP_PHP_DIR
                    . DS;

        $classFile    = $classDir . $collection . Agl::PHP_EXT;

        $classContent = '<?php
class ' . $collection . 'Collection
    extends Collection
{

}
';

        if (! file_exists($classFile) or $override) {
            if (FileData::write($classFile, $classContent) === false) {
                    if (file_exists($classFile)) {
                        FileData::delete($classFile);
                    }

                    throw new Exception("Collection creation failed");
            }
        }
    }
}
