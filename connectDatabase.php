<?php

        require "vendor/autoload.php";
        $client = new MongoDB\Client;
        $db = $client->storage;
        if(!$db){
                die('Could not connect :');
        }
?>