<?php
namespace MessageBox\Client;

use MessageBox\Client\Model\Message;
use GuzzleHttp\Client as GuzzleClient;

class Client
{
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
    
    private $baseurl = "http://www.messagebox.web/";
    
    private $guzzleclient;
    
    private function getGuzzleClient()
    {
        if ($this->guzzleclient) {
            return $this->guzzleclient;
        }
        $this->guzzleclient = new GuzzleClient();
        return $this->guzzleclient;
    }
    
    public function setBaseUrl($baseurl)
    {
        $this->baseurl = $baseurl;
    }
    
    public function getHeaders($status = 'NEW')
    {
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->baseurl . '/api/v1/messages';
        $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        $rows = $res->json();
        //print_r($rows);
        $messages = array();
        foreach ($rows as $row) {
            //print_r($row);
            $messages[] = $this->row2message($row);
        }
        return $messages;
    }

    public function getMessage($messageid)
    {
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->baseurl . '/api/v1/messages/' . $messageid;
        $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        $row = $res->json();
        $message = $this->row2message($row);
        return $message;
    }
    
    private function row2message($row)
    {
        $message = new Message();
        $message->setId($row['id']);
        $message->setSubject($row['subject']);
        $message->setFromBox($row['from_box']);
        $message->setFromDisplayname($row['from_displayname']);
        $message->setToBox($row['to_box']);
        $message->setToDisplayname($row['to_displayname']);
        $message->setCreatedAt($row['created_at']);
        $message->setDeletedAt($row['deleted_at']);
        $message->setSeenAt($row['seen_at']);
        $message->setContentType($row['content_type']);
        if (isset($row['content'])) {
            $message->setContent($row['content']);
        }
        return $message;
    }

    public function send(Message $message)
    {
        
        $guzzleclient = $this->getGuzzleClient();
        $url = $this->baseurl . '/api/v1/send';
        $url .= "?to_box=" . $message->getToBox();
        $url .= "&subject=" . urlencode($message->getSubject());
        // $url .= "&content=" . urlencode($message->getContent());
        $url .= "&content_type=" . urlencode($message->getContentType());
        // $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        $res = $guzzleclient->post($url, ['auth' =>  [$this->username, $this->password], 'body' => ['content' => $message->getContent()]]);
        //echo $res->getStatusCode();
        //echo $res->getHeader('content-type');
        //echo $res->getBody();
        $data = $res->json();
        $messageid = $data['id'];
        return true;
    }
}
