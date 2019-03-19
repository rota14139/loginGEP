<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "logingep";
$table = "users";
$connectionToServerDB = new mysqli($host,$username,$password);

if(!$connectionToServerDB->connect_error)
{
    $connectionToServerDB->query("create database if not exists $db");
    $connectionToServerDB->query("use $db");
    $connectionToServerDB->query("create table if not exists $table(username varchar(30) primary key not null,password varchar(32) not null,date date not null)");
}
?> 