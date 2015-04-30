MessageBox client for PHP
==============

## Send a message
```php
<?php

use MessageBox\Client\Client as MessageBoxClient;
use MessageBox\Client\Model\Message;

$client = new MessageBoxClient($username, $password);
$message = new Message();
$message->setToBox('0000');
$message->setSubject('Yeeehah');
$message->setContent($rawjsonstring);
$message->setContentType('formidable/json');
$client->send($message);
```
