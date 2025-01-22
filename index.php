<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/classes/ParsePlayTechOneLogin.php';

use App\Http\Service\ParsePlayTechOneLogin;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$users = ['NotLikeUs',];
		
$parser = new ParsePlayTechOneLogin($_ENV['IMS_USER'],$_ENV['IMS_PASSWORD'],'reports');

$parser->handle($users);