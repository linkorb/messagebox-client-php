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
            if (isset($data['account'])) {
                $config['account'] = $data['account'];
            }
            if (isset($data['box'])) {
                $config['box'] = $data['box'];
            }
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
            if ($input->hasOption('account')) {
                $config['account'] = $input->getOption('account');
            }
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
        if (!$config['account']) {
            throw new RuntimeException("No account provided");
        }
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

        $client = new Client($config['account'], $config['box'], $config['username'], $config['password'], $config['baseurl']);
        return $client;
    }
}
