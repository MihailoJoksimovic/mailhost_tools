<?php

require_once 'vendor/autoload.php';
require_once 'MailhostChecker.php';

$phpMailer = new \PHPMailer();

$checker = new \Mixa\Mailing\MailhostChecker($phpMailer);

$email = 'sales@sunsetnames.eu';

var_dump($checker->checkEmailWorks($email));

echo "\nLast error is: \n";
var_dump($checker->getLastError());

echo "\n";

