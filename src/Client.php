<?php

namespace MessageBox\Client;

use MessageBox\Client\Model\Message;
use GuzzleHttp\Client as GuzzleClient;

class Client
{
    protected $username;
    protected $password;
    protected $account;
    protected $box;
    private $baseUrl = 'https://www.messagebox.web/';
    private $apiBaseUrl;
    private $guzzleclient;

    public function __construct($username, $password, $baseUrl, $box)
    {
        $this->username = $username;
        $this->password = $password;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->box = $box;
        $this->apiBaseUrl = $this->baseUrl.'/api/v1/' . $this->box;
        $this->guzzleclient = new GuzzleClient();
    }

    public function call($uri, $body = null)
    {
        $url = $this->apiBaseUrl . $uri;
        // echo "Requesting: $url" . PHP_EOL;
        if ($body) {
            $res = $this->guzzleclient->request(
                'POST',
                $url,
                [
                    'auth' => [
                        $this->username,
                        $this->password
                    ],
                    'body' => $body,
                ]
            );
        } else {
            $res = $this->guzzleclient->request(
                'GET',
                $url,
                [
                    'auth' => [
                        $this->username,
                        $this->password
                    ]
                ]
            );
        }
        // echo $res->getStatusCode() . PHP_EOL;

        $body = $res->getBody();
        // echo $body;
        $data = json_decode($body, true);
        return $data;
    }

    public function listMessages($status = 'NEW', $properties = array())
    {
        $queryString = null;
        if ($properties) {
            $queryString = http_build_query($properties);
        }
        $data = $this->call('/messages?' . $queryString);
        // print_r($data); exit();
        return $data;
    }

    public function getMessage($xuid)
    {
        $data = $this->call('/messages/' . $xuid);
        return $data;
    }

    public function archive($xuid)
    {
        $data = $this->call('/messages/' . $xuid . '/archive');
        return $data;
    }

    public function unarchive($xuid)
    {
        $data = $this->call('/messages/' . $xuid . '/unarchive');
        return $data;
    }

    public function getContent($xuid)
    {
        $data = $this->call('/messages/' . $xuid . '/content');
        return $content;
    }

    public function getView($xuid)
    {
        $data = $this->call('/messages/' . $xuid . '/view');
        return $data;
    }

    public function legacySend($fromUsername, $to, $subject, $content, $contentType, $metadata)
    {
        $data = [];
        $data['from_username'] = $fromUsername;
        $data['to'] = $to;
        $data['subject'] = $subject;
        $data['content'] = base64_encode($content);
        $data['content_type'] = $contentType;
        $data['metadata'] = base64_encode($metadata);
        $json = json_encode($data);

        $data = $this->call('/default/send', $json);

        // print_r($data);

        $messageId = $data['message_id'];

        return $messageId;
    }

    public function send($envelope)
    {
        $json = json_encode($envelope, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        return $this->call('/send', $json);
    }

    public function deliver($envelope)
    {
        $json = json_encode($envelope, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        return $this->call('/deliver', $json);
    }

    public function setProperty($xuid, $name, $value)
    {
        $data = [
            'name' => $name,
            'value' => $value
        ];
        $json = json_encode($data);

        return $this->call('/messages/' . $xuid . '/properties', $json);
    }

    public function createBox($accountName, $boxName, $adminUsername)
    {
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->baseUrl.'/api/v1/'.$accountName.'/new?name='.$boxName.'&admin='.$adminUsername;

        $res = $guzzleclient->post($url, ['auth' => [$this->username, $this->password]]);
        $content = $res->getBody();
        $content = json_decode($content, true);

        return $content;
    }
}
