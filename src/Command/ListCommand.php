<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Client as MessageBoxClient;
use MessageBox\Client\Model\Message;

class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:list')
            ->setDescription('List messages in a MessageBox')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = new ClientFactory();
        $client = $factory->createClient();
        
    
        $messages = $client->getHeaders();
        foreach ($messages as $message) {
            echo "#" . $message->getId() . ": " . $message->getFromBox() . '(' . $message->getFromDisplayname() .") " .
                $message->getSubject() . "\n";
        }
        //print_r($messages);
    }
}
