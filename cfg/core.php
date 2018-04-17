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
        $user = mysqli_fetch_object($res);
        if($user != NULL){
            $_SESSION['username'] = $user->username;
            $_SESSION['user_id'] = $user->id;
         }

        $count = $res->num_rows;

        echo $count;
    }

    function getEvents(){
        $res = mysqli_query($this->link, "Select * From event");
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    function getEventsToJS(){
        $res = mysqli_query($this->link, "Select * From event");

        $response = array();
        while($row = mysqli_fetch_assoc($res)) $response[] = $row;

        $jsonData = json_encode($response);

        echo $jsonData;
    }

    function saveEvents($events){
        mysqli_query($this->link, "delete from event");
        foreach ($events as &$value){
            $date = $value["date"];
            $title = $value["title"];
            mysqli_query($this->link, "insert into event values (default, null, '$date', '$title', null)");
        }
    }
}