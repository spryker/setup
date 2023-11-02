<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Setup\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @deprecated Will be removed without replacement. Use `vendor/bin/install` instead.
 *
 * @method \Spryker\Zed\Setup\Communication\SetupCommunicationFactory getFactory()
 * @method \Spryker\Zed\Setup\Business\SetupFacadeInterface getFacade()
 */
class InstallConsole extends Console
{
    /**
     * @var string
     */
    public const COMMAND_NAME = 'setup:install';

    /**
     * @var string
     */
    public const DESCRIPTION = 'Setup the application';

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
        $this->warning('This command is deprecated. Use `spryker/install` tool and `vendor/bin/install` instead.');

        $setupInstallCommandNames = $this->getFactory()->getSetupInstallCommandNames();

        foreach ($setupInstallCommandNames as $key => $value) {
            if (is_array($value)) {
                $this->runDependingCommand($key, $value);
            } else {
                $this->runDependingCommand($value);
            }

            if ($this->hasError()) {
                return $this->getLastExitCode();
            }
        }

        return static::CODE_SUCCESS;
    }
}
