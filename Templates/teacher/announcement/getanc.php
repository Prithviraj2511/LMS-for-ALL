<?php
include  '../../../connectDatabase.php';
$folders=$db->folders;

$access_id=new MongoDB\BSON\ObjectID('5fc46bd8980c0000880022e6');
$clg_id=new MongoDB\BSON\ObjectID('5fc46bbb980c0000880022e4');

function getAccData($particular_folder) {
    foreach ($particular_folder['announcements'] as $announcementJSON) {
        $announcement=json_decode($announcementJSON,true);
        $heading=$announcement['heading'];
        $description=$announcement['description'];
        var_dump($heading);
        var_dump($description);
    }    
}

// annoucements for their department only
$particular_folder=$folders->findOne(['_id'=>$access_id]);
getAccData($particular_folder);
// annoucements for all
$particular_folder=$folders->findOne(['_id'=>$clg_id]);
getAccData($particular_folder);

