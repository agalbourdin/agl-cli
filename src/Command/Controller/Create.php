<?php
namespace Agl\Cli\Command\Controller;

use \Agl\Core\Agl,
    \Agl\Core\Data\Dir as DirData,
    \Agl\Core\Data\File as FileData,
    \Agl\Core\Mvc\Controller\Controller,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    \Exception;

/**
 * Create a new AGL Controller.
 *
 * @category Agl_Cli
 * @package Agl_Cli_Command_Controller
 * @version 0.1.0
 */

class Create
    extends Command
{
    protected function configure()
    {
        $this
            ->setName('controller:create')
            ->setDescription('Create new AGL Controller.')
            ->addArgument(
                'controller',
                InputArgument::REQUIRED,
                'Controller name (ex: home/index)'
            )
            ->addOption(
               'override',
               NULL,
               InputOption::VALUE_NONE,
               'Override if Controller exists'
            );
    }

    /**
     * @param InputInterface $pInput
     * @param OutputInterface $pOnput
     */
    protected function execute(InputInterface $pInput, OutputInterface $pOutput)
    {
        $controller = $pInput->getArgument('controller');
        $override   = $pInput->getOption('override');

        if (! preg_match('/^([a-z0-9]+)\/([a-z0-9_-]+)$/', $controller)) {
            throw new Exception("Controller syntax is incorrect");
        }

        $controllerArr = explode('/', $controller);

        $classDir = APP_PATH
                    . Agl::APP_PHP_DIR
                    . Controller::APP_PHP_DIR
                    . DS
                    . $controllerArr[0]
                    . DS;

        $classFile    = $classDir . $controllerArr[1] . Agl::PHP_EXT;

        $classContent = '<?php
class ' . $controllerArr[0] . ucfirst($controllerArr[1]) . 'Controller
    extends Controller
{
    /**
     * GET action.
     * This is the default action which render the view template.
     *
     * @return string
     */
    public function getAction()
    {
        return parent::getAction();
    }

    /**
     * POST action.
     */
    public function postAction()
    {
        //
    }

    /**
     * PUT action.
     */
    public function putAction()
    {
        //
    }

    /**
     * DELETE action.
     */
    public function deleteAction()
    {
        //
    }
}
';

        if (! file_exists($classFile) or $override) {
            if (! DirData::create($classDir)
                or FileData::write($classFile, $classContent) === false) {
                if (file_exists($classFile)) {
                    FileData::delete($classFile);
                }

                DirData::delete($classDir);

                throw new Exception("Controller creation failed");
            }
        }
    }
}
