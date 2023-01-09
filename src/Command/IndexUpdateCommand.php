<?php

namespace App\Command;

use App\Enum\IndexList;
use App\Message\IndexListRequest;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:index-update',
    description: 'Add a short description for your command',
)]
class IndexUpdateCommand extends Command
{
    protected const ALLOW_VALUES = ['all', 'sp500', 'nasdaq', 'dowjones'];
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus,string $name = null)
{
    parent::__construct($name);
    $this->messageBus = $messageBus;
}

    protected function configure(): void
    {
        $this
            ->addArgument('indexName', InputArgument::REQUIRED, 'allow values: all, sp500, nasdaq, dowjones');
        //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $indexName = $input->getArgument('indexName');

        if (!$this->validate($indexName)) {
            $io->error('Allowed values: ' . implode(',', self::ALLOW_VALUES));
            return Command::FAILURE;
        }

        if ($indexName == 'all') {
            $this->messageBus->dispatch(new IndexListRequest(null));
            $io->note('Запустили апдейт всех индексов');
        } else {
            $index = IndexList::from($indexName);
            $this->messageBus->dispatch(new IndexListRequest($index));
            $io->note(sprintf('Запускаем апдейт одного индекса %s', $index->value));
        }
        return Command::SUCCESS;
    }

    private function validate(string $indexName): bool
    {
        return in_array($indexName, self::ALLOW_VALUES);
    }
}
