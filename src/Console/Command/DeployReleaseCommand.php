<?php

namespace Accompli\Console\Command;

use Accompli\Accompli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * DeployReleaseCommand.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
class DeployReleaseCommand extends Command
{
    /**
     * Configures this command.
     */
    protected function configure()
    {
        $this
            ->setName('deploy-release')
            ->setDescription('Deploys a release to all configured hosts of a stage.')
            ->addArgument('version', InputArgument::REQUIRED, 'The version to deploy.')
            ->addArgument('stage', InputArgument::REQUIRED, 'The stage to select hosts for.')
            ->addOption('project-dir', null, InputOption::VALUE_OPTIONAL, 'The location of the project directory.', getcwd());
    }

    /**
     * Executes this command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = new ParameterBag();
        $parameters->set('working_directory', $input->getOption('project-dir'));
        $parameters->set('configuration.file', $input->getOption('project-dir').DIRECTORY_SEPARATOR.'accompli.json');
        $parameters->set('console.output_interface', $output);

        $accompli = new Accompli($parameters);
        $accompli->initialize();

        $successfulInstall = $accompli->deploy($input->getArgument('version'), $input->getArgument('stage'));
        if ($successfulInstall) {
            return 0;
        }

        return 1;
    }
}
