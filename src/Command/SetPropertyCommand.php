<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use MessageBox\Client\Model\Message;

class SetPropertyCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:set-property')
            ->setDescription('Set a message property through MessageBox')
            ->addArgument(
                'messageId',
                InputArgument::REQUIRED,
                'Message ID'
            )
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'Property name required.'
            )
            ->addOption(
                'value',
                null,
                InputOption::VALUE_REQUIRED,
                'Property value required.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $messageId = $input->getArgument('messageId');

        $propertyName = $input->getOption('name');
        $propertyValue = $input->getOption('value');

        $factory = new ClientFactory();
        $client = $factory->createClient();

        $message = $client->setProperty($messageId, $propertyName, $propertyValue);

        $output->writeln([
        implode(' ', $message['error']),
            '============',
        ]);
    }
}
