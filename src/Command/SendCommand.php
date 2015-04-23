<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Client as MessageBoxClient;
use MessageBox\Client\Model\Message;

class SendCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:send')
            ->setDescription('Send a message through MessageBox')
            ->addOption(
                'to',
                null,
                InputOption::VALUE_REQUIRED,
                'To Box ID'
            )
            ->addOption(
                'subject',
                null,
                InputOption::VALUE_OPTIONAL,
                'Subject'
            )
            ->addOption(
                'content',
                null,
                InputOption::VALUE_OPTIONAL,
                'Content'
            )
        ;
    }
    private function getClient(InputInterface $input)
    {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = new ClientFactory();
        $client = $factory->createClient();
        
        $message = new Message();
        $tobox = $input->getOption('to');
        $message->setToBox($tobox);
        if ($input->hasOption("subject")) {
            $message->setSubject($input->getOption("subject"));
        }
        $message->setContent($input->getOption('content'));
        
        if (!$message) {
            $message = "No message content";
        }
        $results = $client->send($message);
        print_r($results);
    }
}
