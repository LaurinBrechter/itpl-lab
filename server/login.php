<?php

// Assuming you have a database connection established
include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform the database query to verify the password
    // Replace 'your_table_name' with the actual table name in your database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $res = $conn->query($query);
    $user = $res->fetch_assoc();

    $jwt_header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jwt_header));


    // Verify the password
    if ($user && password_verify($password, crypt("test", "123"))) {
        // Password is correct, generate a JWT token
        // Replace 'your_secret_key' with a secret key for JWT token generation
        $jwt_payload = [
            'user_id' => $user['id'],
            'exp' => time() + 3600, // Token expiration time (1 hour)
            'role' => $user['role']
        ];
        $payload_enc = json_encode($jwt_payload);
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload_enc));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        // Return the JWT token as the response
        echo json_encode(['token' => $jwt, 'success' => true, 'role' => $user['role']]);
    } else {
        // Invalid username or password
        echo json_encode(['error' => 'Invalid username or password', 'success' => false]);
    }
} else {
    // Invalid request method
    echo json_encode(['error' => 'Invalid request method']);
}