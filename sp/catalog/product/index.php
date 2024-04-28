


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$request_uri = $_SERVER['REQUEST_URI'];

// Remove any query parameters
$url_parts = explode('?', $request_uri);
$url = rtrim($url_parts[0], '/');

// Split the URL into segments
$segments = explode('/', $url);

// The first segment is usually the controller or resource
$controller = !empty($segments[0]) ? $segments[0] : 'home';

// The second segment might be the action or an identifier
$action_or_id = !empty($segments[1]) ? $segments[1] : '';

echo $segments[3];

?>
    product 1
</body>
</html>