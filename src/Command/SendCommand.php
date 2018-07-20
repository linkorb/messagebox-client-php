<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Model\Message;

class SendCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:send')
            ->setDescription('Send a message through MessageBox by placing it the outbox')
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Filename'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        if (!file_exists($filename)) {
            throw new RuntimeException("File not found: " . $filename);
        }
        $json = file_get_contents($filename);
        $envelope = json_decode($json, true);
        if (!$envelope) {
            throw new RuntimeException("JSON parse error");
        }

        // Support some simple search/replace code for variantion
        foreach ($envelope as $key=>$value) {
            $envelope[$key] = str_replace('{stamp}', time(), $envelope[$key]);
            $envelope[$key] = str_replace('{dateTime}', date('c'), $envelope[$key]);
            $envelope[$key] = str_replace('{hostname}', gethostname(), $envelope[$key]);
        }

        $factory = new ClientFactory();
        $client = $factory->createClient();

        $res = $client->send($envelope);
        print_r($res);
    }
}
