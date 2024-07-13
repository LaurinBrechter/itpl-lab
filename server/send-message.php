<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use WebSocket\Client;

function sendMsg($payload)
{
    // try {
    // Create a WebSocket client instance
    $client = new Client("ws://localhost:8080");

    // Connect to the WebSocket server
    $client->send($payload);

    // Receive the response
    // $response = $client->receive();
    // echo "Received: {$response}\n";
    // } 
    // catch (Exception $e) {
    // echo "Error: " . $e->getMessage() . "\n";
    // }
}

// sendMsg('{ "type": "message", "data": "Hello, WebSocket!" }');