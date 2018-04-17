<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 15.04.2018
 * Time: 18:03
 */


class myDB
{
    var $link;

    function connect() {
        $this->link = mysqli_connect('127.0.0.1', 'root', 'new_password', 'useless');
    }

    function close() {
         mysqli_close($this->link);
    }

    function addUser($username, $password){
        $res = mysqli_query($this->link, "Insert into user VALUES (default, null, '$username', '$password')");

        echo $res;
    }

    function signIn($username, $password){
        $res = mysqli_query($this->link, "Select * From user where username = '$username' and password = '$password'");
        $count = $res->num_rows;

        echo $count;
    }
}