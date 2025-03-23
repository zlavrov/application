<?php

declare(strict_types=1);

namespace App\Command;

use \Firebase\JWT\JWT;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:key', description: 'Add a short description for your command')]
class KeyCommand extends Command
{
    public function __construct() {parent::__construct();}

    protected function configure(): void
    {
        $this->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        exec('openssl rand -base64 32', $outputData, $resultData);

        $key = current($outputData);
        $alg = 'HS256';

        $publish = ['mercure' => ['publish' => ['*'], 'subscribe' => ['*']]];

        $output->writeln(sprintf('Key JWT: %s', $key));

        $output->writeln(sprintf('Publisher JWT: %s', JWT::encode($publish, $key, $alg)));

        $subscribe = ['mercure' => ['subscribe' => ['*']]];

        $output->writeln(sprintf('Subscriber JWT: %s', JWT::encode($subscribe, $key, $alg)));

        return Command::SUCCESS;
    }
}
