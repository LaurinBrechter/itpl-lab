<?php

function connect()
{


    $DB_SERVER = "localhost";
    $DB_PORT = "3306";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "test_db";
    $CONN = "";

    try {
        $CONN = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
        // echo "Connected to database";
    } catch (Exception $e) {
        echo "Failed to connect to database";
    }

    return $CONN;

}

$conn = connect();
// GLOBAL $conn;

// $sql = "CREATE TABLE test_db.service_partners IF NOT EXISTS (
//     id int primary key auto_increment,
//     name varchar(255)
// ); CREATE TABLE test_db.orders IF NOT EXISTS (
//     id int primary key auto_increment,
//     total float,
//     created_at DEFAULT CURRENT_TIMESTAMP);
// CREATE TABLE test_db.order_items IF NOT EXISTS (
//     id int primary key auto_increment,
//     sku int,
//     amount int);";
// $result = $conn->query($sql);

// $sql_index = "CREATE INDEX name_index on test_db.service_partners"