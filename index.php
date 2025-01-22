<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/classes/ParsePlayTechOneLogin.php';

use App\Http\Service\ParsePlayTechOneLogin;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$users = ['Designer',];

try {

    $parser = new ParsePlayTechOneLogin($_ENV['IMS_USER'], $_ENV['IMS_PASSWORD'], 'reports', $_ENV['REPORT_URL'], $_ENV['URL'], $_ENV['WAIT_TIMEOUT'], $_ENV['SELENIUM_URL']);

    $parser->handle($users);

} catch (Exception $e) {
    //print_r($e->getMessage());
}