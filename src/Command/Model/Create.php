<?php
namespace Agl\Cli\Command\Model;

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
 * Create a new AGL Model.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Model
 * @version 0.1.0
 */

class Create
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('model:create')
            ->setDescription('Create new AGL Model.')
            ->addArgument(
                'model',
                InputArgument::REQUIRED,
                'Model name (ex: user)'
            )
            ->addOption(
               'override',
               NULL,
               InputOption::VALUE_NONE,
               'Override if Model exists'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $model    = $pInput->getArgument('model');
        $override = $pInput->getOption('override');

        if (! preg_match('/^[a-z0-9_-]+$/', $model)) {
            throw new Exception("Model syntax is incorrect");
        }

        $classDir = APP_PATH
                    . Agl::APP_PHP_DIR
                    . ModelInterface::APP_PHP_DIR
                    . DS;

        $classFile    = $classDir . $model . Agl::PHP_EXT;

        $classContent = '<?php
class ' . $model . 'Model
    extends Model
{

}
';

        if (! file_exists($classFile) or $override) {
            if (FileData::write($classFile, $classContent) === false) {
                    if (file_exists($classFile)) {
                        FileData::delete($classFile);
                    }

                    throw new Exception("Model creation failed");
            }
        }
    }
}
