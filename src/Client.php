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
    
    public function setBaseUrl($baseurl)
    {
        $this->baseurl = $baseurl;
    }

    public function send(Message $message)
    {
        $guzzleclient = new GuzzleClient();
        $url = $this->baseurl . '/api/v1/send';
        $url .= "?to_box=" . $message->getToBox();
        $url .= "&subject=" . urlencode($message->getSubject());
        $url .= "&content=" . urlencode($message->getContent());
        echo "URL: $url\n";
        $res = $guzzleclient->get($url, ['auth' =>  [$this->username, $this->password]]);
        //echo $res->getStatusCode();
        //echo $res->getHeader('content-type');
        //echo $res->getBody();
        $data = $res->json();
        if ($data['numFound']>0) {
        }
        return true;
    }
}
