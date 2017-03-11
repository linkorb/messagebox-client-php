<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Model\Message;

class GetCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:get')
            ->setDescription('Get a message from a MessageBox')
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

        $message = $client->getMessage($messageId);
        echo 'ID       : '.$message->getId()."\n";
        echo 'From     : '.$message->getFromBox().' ('.$message->getFromDisplayname().")\n";
        echo 'Subject  : '.$message->getSubject()."\n";
        echo 'Created  : '.$message->getCreatedAt()."\n";
        echo 'Archived : '.$message->getArchivedAt()."\n";
        echo 'Seen     : '.$message->getSeenAt()."\n";
        echo 'Deleted  : '.$message->getDeletedAt()."\n";
        echo 'Type     : '.$message->getContentType()."\n";
        echo 'Metadata : '.$message->getMetadata()."\n";
        //print_r($messages);
    }
}
