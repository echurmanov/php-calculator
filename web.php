<?php
require_once('parser.php');

$expression = file_get_contents('php://input');

$result = array(
    'success' => false,
    'result' => 0,
    'message' => '',
);

if ($expression) {
    try {
        $result['result'] = parse($expression);
        $result['success'] = true;
    } catch (Exception $e) {
        $result['message'] = $e->getMessage();
    }
} else {
    $result['message'] = 'Missing data';
}

header("Content-Type: application/json");
echo json_encode($result);