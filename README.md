MessageBox client for PHP
==============

## Send a message
```php
<?php

$client = new Client($username, $password);
$message = new Message();
$message->setToBox('0000');
$message->setSubject('Yeeehah');
$message->setContent($rawjsonstring);
$message->setContentType('formidable/json');
$client->send($message);
```
