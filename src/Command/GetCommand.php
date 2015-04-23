<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Client as MessageBoxClient;
use MessageBox\Client\Model\Message;

class GetCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:get')
            ->setDescription('Get a message from a MessageBox')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = new ClientFactory();
        $client = $factory->createClient();
        $messageid = 27;
    
        $message = $client->getMessage($messageid);
        echo "From    : " . $message->getFromBox() . " - " . $message->getFromDisplayname() . "\n";
        echo "To      : " . $message->getToBox() . " - " . $message->getToDisplayname() . "\n";
        echo "Subject : " . $message->getSubject() . "\n";
        echo "Created : " . $message->getCreatedAt() . "\n";
        echo "Seen    : " . $message->getSeenAt() . "\n";
        echo "Deleted : " . $message->getDeletedAt() . "\n";
        echo "Type    : " . $message->getContentType() . "\n";
        echo "-----------------------------------\n";
        echo $message->getContent() . "\n";
        echo "-----------------------------------\n";
        //print_r($messages);
    }
}
