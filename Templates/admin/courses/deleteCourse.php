<?php
function getAllInsideIds($fid)
{
    global $folders;
    global $fidsDelete;
    array_push($fidsDelete, $fid);
    $cursor = $folders->find(["_id" => new MongoDB\BSON\ObjectID($fid)], ["content" => 1, "_id" => 0]);
    foreach ($cursor as $content) {
        if (array_key_exists('content', $content)) {
            foreach ($content['content'] as $ids) {
                getAllInsideIds($ids);
            }
        }
    }
}

if (isset($_GET["deleteFolder"])) {
    $fidsDelete = array();
    getAllInsideIds($_GET["clickedfolder_id"]);
    foreach ($fidsDelete as $fid) {
        $folders->deleteOne(["_id" => new MongoDB\BSON\ObjectID($fid)]);
        $result=$accounts->updateOne(
            ["_id"=>  new MongoDB\BSON\ObjectID($_SESSION["adminid"])],
            ['$pull'=> ["subjects"=>new MongoDB\BSON\ObjectID($fid)]]
        );
    }
    $result=$folders->updateOne(
        ["_id"=> $_SESSION['parent_id']],
        ['$pull'=> ["content"=>new MongoDB\BSON\ObjectID($_GET["clickedfolder_id"])]]
    );
    $result=$accounts->updateOne(
        ["_id"=>  new MongoDB\BSON\ObjectID($_SESSION["adminid"])],
        ['$pull'=> ["subjects"=>new MongoDB\BSON\ObjectID($_GET["clickedfolder_id"])]]
    );
}

?>