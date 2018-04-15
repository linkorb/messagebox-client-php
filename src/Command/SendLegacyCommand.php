<?php

namespace MessageBox\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MessageBox\Client\Model\Message;

class SendLegacyCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('message:send-legacy')
            ->setDescription('Send a message through MessageBox - LEGACY MODE')
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
        $json = file_get_contents($filename);
        $data = json_decode($json, true);

        $fromUsername = $data['from_username'];
        $subject = $data['subject'];
        $contentType = $data['content_type'];
        $content = base64_decode($data['content']);
        $contentType = $data['content_type'];
        $to = $data['to'];
        $metadata = $data['metadata'];

        $factory = new ClientFactory();
        $client = $factory->createClient();

        $messageId = $client->legacySend($fromUsername, $to, $subject, $content, $contentType, $metadata);
        if ($messageId) {
            echo "MessageID: $messageId\n";
        }
    }
}
