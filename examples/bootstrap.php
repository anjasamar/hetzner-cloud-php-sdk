<?php

require_once __DIR__ . '/../vendor/autoload.php';
$apiKey = '{InsertApiTokenHere}';

$hetznerClient = new \atsicorp\HetznerCloud\HetznerAPIClient($apiKey);
