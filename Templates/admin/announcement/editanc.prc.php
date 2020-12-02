<?php
session_start();
if(isset($_POST['anc_delete'])||isset($_POST['anc_update'])){
    include '../../../connectDatabase.php';
    $folders=$db->folders;
    $res=$folders->findOne(["_id" => $_SESSION['parent_id']],["announcements"=>1]);
    $annoucements=iterator_to_array($res['announcements']);
    echo $annoucements[$_POST['anc_oldidx']];
    unset($annoucements[$_POST['anc_oldidx']]);
    $res = $folders->updateOne(
        // $_SESSION['parent_id'] contains the id of folder where announcement is done
        ["_id" => $_SESSION['parent_id']],
        ['$set' => ["announcements" =>$annoucements]]
    );
    var_dump($res);
    if(isset($_POST['anc_update'])){
        echo "updating";
        $annoucement = ['heading' => $_POST['anc_header'], 'description' => $_POST['anc_desc']];
        $annoucementJSON = json_encode($annoucement);
        $res = $folders->updateOne(
            // $_SESSION['parent_id'] contains the id of folder where announcement is done
            ["_id" => $_SESSION['parent_id']],
            ['$push' => ["announcements" => $annoucementJSON]]
        ); 
        var_dump($res);
    }
    if($_SESSION['parent_id']==$_SESSION['accessId']){
        header("Location: ../dashboardHome.php");
    }
    else{
        header("Location: ../courses/manageCoursesAdmin.php");
    }
}