<?php
        require "vendor/autoload.php";
        $client = new MongoDB\Client('mongodb+srv://TaskApp:raj12345patil@cluster0.ypfhs.mongodb.net/storage?retryWrites=true&w=majority');
        $db = $client->storage;
        if(!$db){
                die('Could not connect :');
        }
?>