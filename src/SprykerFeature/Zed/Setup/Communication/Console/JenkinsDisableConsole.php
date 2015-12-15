<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Setup\Communication\Console;

use Spryker\Zed\Console\Business\Model\Console;
use Spryker\Zed\Setup\Business\SetupFacade;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method SetupFacade getFacade()
 */
class JenkinsDisableConsole extends Console
{

    const COMMAND_NAME = 'setup:jenkins:disable';
    const DESCRIPTION = 'Disable jenkins';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->getFacade()->disableJenkins();

        $output->writeln($result);
    }

}
