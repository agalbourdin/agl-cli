<?php
namespace Agl\Cli\Command\Helper;

use \Agl\Core\Agl,
    \Agl\Core\Data\File as FileData,
    \Agl\Core\Mvc\Model\ModelInterface,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Create a new AGL Helper.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Helper
 * @version 0.1.0
 */

class Create
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('helper:create')
            ->setDescription('Create new AGL Helper.')
            ->addArgument(
                'helper',
                InputArgument::REQUIRED,
                'Helper name (ex: image)'
            )
            ->addOption(
               'override',
               NULL,
               InputOption::VALUE_NONE,
               'Override if Helper exists'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $helper   = $pInput->getArgument('helper');
        $override = $pInput->getOption('override');

        if (! preg_match('/^[a-z0-9_-]+$/', $helper)) {
            throw new Exception("Helper syntax is incorrect");
        }

        $classDir = APP_PATH
                    . Agl::APP_PHP_DIR
                    . ModelInterface::APP_PHP_HELPER_DIR
                    . DS;

        $classFile    = $classDir . $helper . Agl::PHP_EXT;

        $classContent = '<?php
class ' . $helper . 'Helper
{

}
';

        if (! file_exists($classFile) or $override) {
            if (FileData::write($classFile, $classContent) === false) {
                if (file_exists($classFile)) {
                    FileData::delete($classFile);
                }

                throw new Exception("Helper creation failed");
            }
        }
    }
}
