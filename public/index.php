<?php

include '../vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use App\Service\ParseArgs;
use App\Exception\NotCorrectCardException;

$longopts  = array(
    ParseArgs::BOARD_PARAM,
);
$options = getopt(null, $longopts);
$board = $options[ParseArgs::BOARD_KEY];

$kernel = new App\Kernel();
try {
    $kernel->start($board, ParseArgs::parsePlayers($argv));
} catch(NotCorrectCardException $e) {
    echo 'error: {cards are not correct}';
}
