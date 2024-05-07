<?php

include $_SERVER['DOCUMENT_ROOT'] . '/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // log the request body

    echo $_POST;

    $sql = "select * from products";
    $conn->query($sql);
}
// echo $_SERVER['REQUEST_METHOD'];