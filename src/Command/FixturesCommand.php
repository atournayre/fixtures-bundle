<?php

namespace Atournayre\Bundle\FixtureBundle\Command;

use Atournayre\Bundle\FixtureBundle\DependencyInjection\FixtureExtension;
use Atournayre\Bundle\FixtureBundle\Event\AfterFixturesEvent;
use Atournayre\Bundle\FixtureBundle\Event\BeforeFixturesEvent;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\LoaderInterface as AliceBundleLoaderInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
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
        private readonly KernelInterface            $kernel,
        private readonly ContainerInterface         $container,
        private readonly EventDispatcherInterface   $eventDispatcher,
        private readonly EntityManagerInterface     $entityManager,
        private readonly AliceBundleLoaderInterface $loader,
        string                                      $name = null
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
        $this->runFixtures($input, $output);
        $this->eventDispatcher->dispatch(new AfterFixturesEvent($this->io, $memoryLimit));

        $this->io->success('Fixtures successful.');

        $this->io->text([
            $this->container->getParameter(FixtureExtension::parameterFullName('ending_message')),
            '',
        ]);

        return Command::SUCCESS;
    }

    /**
     * @param InputInterface $input
     *
     * @return void
     * @throws ExceptionInterface
     */
    private function runFixtures(InputInterface $input): void
    {
        $this->io->section('Fixtures');

        $this->loader->load(
            new Application($this->kernel),
            $this->entityManager,
            [],
            $input->getOption('env'),
            false,
            false
        );
    }
}
