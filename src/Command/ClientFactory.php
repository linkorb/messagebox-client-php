<?php

namespace MessageBox\Client\Command;
use MessageBox\Client\Client;

class ClientFactory
{
    public function createClient(InputInterface $input = null)
    {
        $config = array();
        $filename = 'config.json';
        if (file_exists($filename)) {
            $json = file_get_contents($filename);
            $data = json_decode($json, true);
            if (isset($data['username'])) {
                $config['username'] = $data['username'];
            }
            if (isset($data['password'])) {
                $config['password'] = $data['password'];
            }
            if (isset($data['baseurl'])) {
                $config['baseurl'] = $data['baseurl'];
            }
        }
        
        if ($input) {
            // Load from cli provided options
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
        
        if (!$config['username']) {
            throw new RuntimeException("No username provided");
        }
        if (!$config['password']) {
            throw new RuntimeException("No password provided");
        }
        if (!$config['baseurl']) {
            throw new RuntimeException("No baseurl provided");
        }
        
        $client = new Client($config['username'], $config['password']);
        $client->setBaseUrl($config['baseurl']);
        return $client;
    }
}
