<?php
error_reporting(E_ALL);

$s = @stream_socket_server("tcp://127.0.0.1:8080", $errno, $errstr);

var_dump($s);
var_dump($errno);
var_dump($errstr);

if ($s) fclose($s);
