<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 15.04.2018
 * Time: 21:35
 */
require_once($_SERVER[DOCUMENT_ROOT]."/cfg/core.php");
$db = new myDB();
session_start();

if (isset($_REQUEST["register"])) {
    $db->connect();

    $login = $_REQUEST["username"];
    $pass = $_REQUEST["password"];
    $res = $db->addUser($login, $pass);

    $db->close();

    return $res;
}

if (isset($_REQUEST["sign-in"])) {
    $db->connect();

    $login = $_REQUEST["username"];
    $pass = $_REQUEST["password"];
    $res = $db->signIn($login, $pass);
    $_SESSION['username'] = $login;

    $db->close();

    echo $res;
}

