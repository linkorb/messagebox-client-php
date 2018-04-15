<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Client as MessageBoxClient;
use MessageBox\Client\Model\Message;

class UnarchiveCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:unarchive')
            ->setDescription('Unarchive a message')
            ->addArgument(
                'messageId',
                InputArgument::REQUIRED,
                'Message ID'
            )
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = new ClientFactory();
        $client = $factory->createClient();
        $messageId = $input->getArgument('messageId');

        $result = $client->unarchive($messageId);
        print_r($result);
    }
}
