<?php
if (isset($_POST['anc_button'])) {

    $annoucement = ['heading' => $_POST['anc_header'], 'description' => $_POST['anc_desc']];

    $annoucementJSON = json_encode($annoucement);

    $res = $folders->updateOne(
        // $_SESSION['parent_id'] contains the id of folder where announcement is done
        ["_id" => new MongoDB\BSON\ObjectID($_SESSION['parent_id'])],
        ['$push' => ["announcements" => $annoucementJSON]]
    );
}

