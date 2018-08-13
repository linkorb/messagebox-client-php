<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Model\Message;

class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:list')
            ->setDescription('List messages in a MessageBox')
            ->addOption(
                'properties',
                null,
                InputOption::VALUE_OPTIONAL,
                'Filter by properties'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = new ClientFactory();
        $client = $factory->createClient();

        $properties = $input->getOption('properties');

        $propertyArray = [];
        if ($properties) {
            $properties = str_replace(',', '&', $properties);
            parse_str($properties, $propertyArray);
        }
        print_r($propertyArray);
        $messages = $client->listMessages('NEW', $propertyArray);
        print_r($messages);
    }
}
