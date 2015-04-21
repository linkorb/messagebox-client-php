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
                'username',
                null,
                InputOption::VALUE_REQUIRED,
                'Username for the messagebox server'
            )
            ->addOption(
                'password',
                null,
                InputOption::VALUE_REQUIRED,
                'Password for the messagebox server'
            )
            ->addOption(
                'baseurl',
                null,
                InputOption::VALUE_REQUIRED,
                'Base URL of the messagebox server'
            )
            ->addOption(
                'content',
                null,
                InputOption::VALUE_REQUIRED,
                'Content'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $c = new MessageBoxClient($input->getOption('username'), $input->getOption('password'));
        $message = new Message();
        $message->setToBox('test2');
        $message->setSubject("Subject");
        
        $message->setContent($input->getOption('content'));
        $c->setBaseUrl($input->getOption('baseurl'));
        
        $results = $c->send($message);
        print_r($results);
    }
}
