<?php

namespace Atournayre\Bundle\FixtureBundle\Command;

use Atournayre\Bundle\FixtureBundle\DependencyInjection\FixtureExtension;
use Atournayre\Bundle\FixtureBundle\Event\AfterFixturesEvent;
use Atournayre\Bundle\FixtureBundle\Event\BeforeFixturesEvent;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: FixturesCommand::NAME,
    description: 'Run fixtures and perform before/after actions.',
)]
#[When('dev')]
class FixturesCommand extends Command
{
    public const NAME = 'fixtures';

    private SymfonyStyle $io;

    public function __construct(
        private readonly ContainerInterface       $container,
        private readonly EventDispatcherInterface $eventDispatcher,
        string                                    $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addOption('memory-limit', null, InputOption::VALUE_OPTIONAL, 'The memory limit to set.', '4G');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $memoryLimit = $input->getOption('memory-limit');
        Assert::string($memoryLimit);

        $this->eventDispatcher->dispatch(new BeforeFixturesEvent($this->io));
        $this->runFixtures($output);
        $this->eventDispatcher->dispatch(new AfterFixturesEvent($this->io, $memoryLimit));

        $this->io->success('Fixtures successful.');

        $this->io->text([
            $this->container->getParameter(FixtureExtension::parameterFullName('ending_message')),
            '',
        ]);

        return Command::SUCCESS;
    }

    /**
     * @param OutputInterface $output
     *
     * @return void
     * @throws ExceptionInterface
     */
    private function runFixtures(OutputInterface $output): void
    {
        $this->io->section('Fixtures');

        $this->runCommand(
            $output,
            $this->container->getParameter(FixtureExtension::parameterFullName('command')),
            [
                '--no-interaction' => true,
            ]
        );
    }

    /**
     * @param OutputInterface $output
     * @param string $commandName
     * @param array<string, int|string|bool> $arguments
     *
     * @return void
     * @throws ExceptionInterface
     */
    private function runCommand(OutputInterface $output, string $commandName, array $arguments = []): void
    {
        $application = $this->getApplication();

        Assert::notNull($application);

        $command = $application->find($commandName);
        $greetInput = new ArrayInput($arguments);

        $command->run($greetInput, $output);
    }
}
