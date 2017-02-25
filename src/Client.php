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
    private $baseUrl = "https://www.messagebox.web/";
    private $boxBaseUrl;

    public function __construct($account, $box, $username, $password, $baseUrl = null)
    {
        $this->account = $account;
        $this->box = $box;
        $this->username = $username;
        $this->password = $password;
        if ($baseUrl) {
            $this->baseUrl = $baseUrl;
        }
        $this->boxBaseUrl = $this->baseUrl . '/api/v1/' . $account . '/' . $box;
    }

    private $guzzleclient;

    private function getGuzzleClient()
    {
        if ($this->guzzleclient) {
            return $this->guzzleclient;
        }
        $this->guzzleclient = new GuzzleClient();
        return $this->guzzleclient;
    }

    public function getHeaders($status = 'NEW')
    {
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->boxBaseUrl . '/messages';
        $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        $body = $res->getBody();
        //echo $body;
        $rows = json_decode($body, true);
        $messages = array();
        foreach ($rows as $row) {
            $messages[] = $this->row2message($row);
        }
        return $messages;
    }

    public function getMessage($messageid)
    {
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->boxBaseUrl . '/messages/' . $messageid;
        $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        $body = $res->getBody();
        $row = json_decode($body, true);
        $message = $this->row2message($row);
        return $message;
    }

    public function archive($messageid)
    {
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->boxBaseUrl . '/messages/' . $messageid . '/archive';
        $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        $body = $res->getBody();
        return true;
    }

    public function unarchive($messageid)
    {
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->boxBaseUrl . '/messages/' . $messageid . '/unarchive';
        $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        $body = $res->getBody();
        return true;
    }


    public function getContent($messageid)
    {
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->boxBaseUrl . '/messages/' . $messageid . '/content';
        $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        $content = $res->getBody();
        return $content;
    }

    private function row2message($row)
    {
        $message = new Message();
        $message->setId($row['id']);
        $message->setSubject($row['subject']);
        $message->setFromBox($row['from_account'] . '/' . $row['from_name']);
        $message->setFromDisplayname($row['from_username']);
        /*
        $message->setToBox($row['to_box']);
        $message->setToDisplayname($row['to_displayname']);
        */
        $message->setCreatedAt($row['created_at']);
        //$message->setDeletedAt($row['deleted_at']);
        //$message->setSeenAt($row['seen_at']);
        $message->setArchivedAt($row['archived_at']);
        $message->setContentType($row['content_type']);
        if (isset($row['content'])) {
            $message->setContent($row['content']);
        }
        return $message;
    }

    public function send($fromUsername, $to, $subject, $content, $contentType)
    {

        $guzzleclient = $this->getGuzzleClient();
        $url = $this->boxBaseUrl . '/send';

        $data = [];
        $data['from_username'] = $fromUsername;
        $data['to'] = $to;
        $data['subject'] = $subject;
        $data['content'] = base64_encode($content);
        $data['content_type'] = base64_encode($contentType);
        $json = json_encode($data);
        //echo $json;
        $res = $guzzleclient->post($url, ['auth' =>  [$this->username, $this->password], 'body' => $json]);
        $json = $res->getBody();
        $data = json_decode($json, true);
        $messageId = $data['message_id'];
        return $messageId;
    }
}
