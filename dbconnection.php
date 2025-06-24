<?php
function getPDO() {
    $host = 'localhost';
    $db = 'rexx_event_booking_system';
    $user = 'root';
    $pass = '';
    return new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
