<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Setup\Communication\Console;

use Spryker\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder\ClientMethodTagBuilder;
use Spryker\Zed\Console\Business\Model\Console;
use Spryker\Zed\Kernel\IdeAutoCompletion\IdeAutoCompletionGenerator;
use Spryker\Zed\Kernel\IdeAutoCompletion\IdeBundleAutoCompletionGenerator;
use Spryker\Zed\Kernel\IdeAutoCompletion\IdeFactoryAutoCompletionGenerator;
use Spryker\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder\ConsoleMethodTagBuilder;
use Spryker\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder\ConstructableMethodTagBuilder;
use Spryker\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder\FacadeMethodTagBuilder;
use Spryker\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder\GeneratedInterfaceMethodTagBuilder;
use Spryker\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder\PluginMethodTagBuilder;
use Spryker\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder\QueryContainerMethodTagBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateZedIdeAutoCompletionConsole extends Console
{

    const COMMAND_NAME = 'setup:generate-zed-ide-auto-completion';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('This Command will generate the bundle ide auto completion interface for Yves.');
        $this->setDescription('Generate zed ide auto completion files');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->generateZedInterface();
        $this->generateZedBundleInterface();
        $this->generateZedFactoryInterface();
    }

    /**
     * @return void
     */
    protected function generateZedInterface()
    {
        $options = $this->getZedDefaultOptions();

        $generator = new IdeAutoCompletionGenerator($options, $this);
        $generator
            ->addMethodTagBuilder(new GeneratedInterfaceMethodTagBuilder());

        $generator->create('');

        $this->info('Generate Zed IdeAutoCompletion file');
    }

    /**
     * @return array
     */
    protected function getZedDefaultOptions()
    {
        $options = [
            IdeAutoCompletionGenerator::OPTION_KEY_NAMESPACE => 'Generated\Zed\Ide',
            IdeAutoCompletionGenerator::OPTION_KEY_LOCATION_DIR => APPLICATION_SOURCE_DIR . '/Generated/Zed/Ide/',
        ];

        return $options;
    }

    /**
     * @return void
     */
    protected function generateZedBundleInterface()
    {
        $options = $this->getZedDefaultOptions();
        $options[IdeBundleAutoCompletionGenerator::OPTION_KEY_INTERFACE_NAME] = 'BundleAutoCompletion';

        $generator = new IdeBundleAutoCompletionGenerator($options);
        $generator
            ->addMethodTagBuilder(new FacadeMethodTagBuilder())
            ->addMethodTagBuilder(new QueryContainerMethodTagBuilder())
            ->addMethodTagBuilder(new ConsoleMethodTagBuilder())
            ->addMethodTagBuilder(new ClientMethodTagBuilder())
            ->addMethodTagBuilder(new PluginMethodTagBuilder([PluginMethodTagBuilder::OPTION_KEY_APPLICATION => 'Zed']));

        $generator->create('');

        $this->info('Generate Zed IdeBundleAutoCompletion file');
    }

    /**
     * @return void
     */
    protected function generateZedFactoryInterface()
    {
        $businessMethodTagGenerator = new ConstructableMethodTagBuilder([
            ConstructableMethodTagBuilder::OPTION_KEY_PATH_PATTERN => 'Business/',
            ConstructableMethodTagBuilder::OPTION_KEY_APPLICATION => 'Zed',
        ]);
        $communicationMethodTagGenerator = new ConstructableMethodTagBuilder([
            ConstructableMethodTagBuilder::OPTION_KEY_PATH_PATTERN => 'Communication/',
            ConstructableMethodTagBuilder::OPTION_KEY_APPLICATION => 'Zed',
        ]);

        $options = [
            IdeFactoryAutoCompletionGenerator::OPTION_KEY_NAMESPACE => 'Generated\Zed\Ide\FactoryAutoCompletion',
            IdeFactoryAutoCompletionGenerator::OPTION_KEY_LOCATION_DIR => APPLICATION_SOURCE_DIR . '/Generated/Zed/Ide/',
        ];

        $generator = new IdeFactoryAutoCompletionGenerator($options);
        $generator
            ->addMethodTagBuilder($businessMethodTagGenerator)
            ->addMethodTagBuilder($communicationMethodTagGenerator);

        $generator->create('');

        $this->info('Generate Zed IdeFactoryAutoCompletion file');
    }

}