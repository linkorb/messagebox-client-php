<?php

namespace MessageBox\Client\Command;
use MessageBox\Client\Client;

class ClientFactory
{
    public function createClient(InputInterface $input = null)
    {
        $config = array();
        $config['box'] = getenv('MESSAGEBOX_BOX');
        $config['username'] = getenv('MESSAGEBOX_USERNAME');
        $config['password'] = getenv('MESSAGEBOX_PASSWORD');
        $config['baseurl'] = getenv('MESSAGEBOX_URL');

        if ($input) {
            // Load from cli provided options
            if ($input->hasOption('box')) {
                $config['box'] = $input->getOption('box');
            }
            if ($input->hasOption('username')) {
                $config['username'] = $input->getOption('username');
            }
            if ($input->hasOption('password')) {
                $config['password'] = $input->getOption('password');
            }
            if ($input->hasOption('baseurl')) {
                $config['baseurl'] = $input->getOption('baseurl');
            }
        }

        // Sanity checks
        if (!$config['box']) {
            throw new RuntimeException("No box provided");
        }
        if (!$config['username']) {
            throw new RuntimeException("No username provided");
        }
        if (!$config['password']) {
            throw new RuntimeException("No password provided");
        }
        if (!$config['baseurl']) {
            throw new RuntimeException("No baseurl provided");
        }

        $client = new Client($config['username'], $config['password'], $config['baseurl'], $config['box']);
        return $client;
    }
}
