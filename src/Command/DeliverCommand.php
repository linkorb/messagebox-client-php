<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Model\Message;

class DeliverCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:deliver')
            ->setDescription('Deliver a message into a MessageBox inbox')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL,
                'Filename'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        if ($filename) {
            $json = file_get_contents($filename);
            $envelope = json_decode($json, true);
        } else {
            $envelope = [
                'id' => '{stamp}@{hostname}',
                'subject' => 'Example subject {stamp}',
                'from' => [
                    'displayName' => 'Alice Alisson',
                    'address' => 'alice',
                ],
                'to' => [
                    [
                        'displayName' => 'Bob Bobson',
                        'address' => 'bob',
                    ],
                ],
                'dateTime' => '{dateTime}',
                'contentType' => 'text/plain',
                'content' => 'Hello Bob!',
            ];
        }

        // Support some simple search/replace code for variantion
        foreach ($envelope as $key=>$value) {
            $envelope[$key] = str_replace('{stamp}', time(), $envelope[$key]);
            $envelope[$key] = str_replace('{dateTime}', date('c'), $envelope[$key]);
            $envelope[$key] = str_replace('{hostname}', gethostname(), $envelope[$key]);
        }

        $factory = new ClientFactory();
        $client = $factory->createClient();

        $res = $client->deliver($envelope);
        print_r($res);
    }
}
