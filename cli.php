<?php
require_once('parser.php');

$expression = $_SERVER['argv'][1];
try {
    echo PHP_EOL . $expression . " = " . parse($expression) . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
