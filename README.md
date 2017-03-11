MessageBox client for PHP
==============

## Send a message
```php
<?php

use MessageBox\Client\Client;

$client = new Client($account, $box, $username, $password, $baseUrl);
$client->send($fromUsername, $to, $subject, $content, $contentType);
```
