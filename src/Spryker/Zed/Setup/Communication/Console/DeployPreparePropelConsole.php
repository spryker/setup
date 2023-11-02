<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Setup\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Spryker\Zed\Propel\Communication\Console\BuildModelConsole;
use Spryker\Zed\Propel\Communication\Console\ConvertConfigConsole;
use Spryker\Zed\Propel\Communication\Console\SchemaCopyConsole;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @deprecated Use {@link \Spryker\Zed\Propel\Communication\Console\DeployPreparePropelConsole} instead.
 *
 * @method \Spryker\Zed\Setup\Business\SetupFacadeInterface getFacade()
 * @method \Spryker\Zed\Setup\Communication\SetupCommunicationFactory getFactory()
 */
class DeployPreparePropelConsole extends Console
{
    /**
     * @var string
     */
    public const COMMAND_NAME = 'setup:deploy:prepare-propel';

    /**
     * @var string
     */
    public const DESCRIPTION = 'Prepares Propel configuration on appserver';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->warning(sprintf('The console command `%s` is deprecated. Use `propel:deploy:prepare` instead', static::COMMAND_NAME));

        $dependingCommands = [
            ConvertConfigConsole::COMMAND_NAME,
            SchemaCopyConsole::COMMAND_NAME,
            BuildModelConsole::COMMAND_NAME,
        ];

        foreach ($dependingCommands as $commandName) {
            $exitCode = $this->runDependingCommand($commandName);

            if ($this->hasError()) {
                return $exitCode;
            }
        }

        return static::CODE_SUCCESS;
    }

    /**
     * @param string $command
     * @param array $arguments
     *
     * @return int
     */
    protected function runDependingCommand($command, array $arguments = [])
    {
        $command = $this->getApplication()->find($command);
        $arguments['command'] = $command;
        $input = new ArrayInput($arguments);

        return $command->run($input, $this->output);
    }
}
