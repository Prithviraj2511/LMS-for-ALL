<?php
include 'addanc.prc.php';

// annoucements for all are in general folder so we are fetching that announcements here
$particular_folder = $folders->findOne(['_id' => $_SESSION['genral_id']]);
if (isset($particular_folder['announcements'])) {
    foreach ($particular_folder['announcements'] as $key=>$announcementJSON) {
        $announcement = json_decode($announcementJSON, true);
        $heading = $announcement['heading'];
        $description = $announcement['description'];
?>
<div class="announcement">
    <div class="insideAnc">
        
            <input type="hidden" name="anc_old" value='<?php echo $announcementJSON ?>'>
            <input type="hidden" name="anc_oldidx" value='<?php echo $key ?>'>
            <label for="anc_header"><?php echo $heading ?></label>
            <br>
            <label for="anc_desc">Description</label>
            <br>
            <textarea name="anc_desc" rows="6" cols="50" required disabled><?php echo $description ?></textarea>
            <br>
  
    </div>
</div>
<?php
    }
}


// announcements for particular folder
$particular_folder = $folders->findOne(['_id' => $_SESSION['parent_id']]);
if (isset($particular_folder['announcements'])) {
    foreach ($particular_folder['announcements'] as $key=>$announcementJSON) {
        $announcement = json_decode($announcementJSON, true);
        $heading = $announcement['heading'];
        $description = $announcement['description'];
?>
<div class="announcement">
    <div class="insideAnc">
        <form action="announcement/editanc.prc.php" method="post">
            <input type="hidden" name="anc_old" value='<?php echo $announcementJSON ?>'>
            <input type="hidden" name="anc_oldidx" value='<?php echo $key ?>'>
            <label for="anc_header">Heading</label>
            <br>
            <input type="text" name="anc_header" placeholder="enter header ..." value="<?php echo $heading ?>" required>
            <br>
            <label for="anc_desc">Description</label>
            <br>
            <textarea name="anc_desc" rows="6" cols="50" required><?php echo $description ?></textarea>
            <br>
            <input type="submit" name="anc_update" value="Update">
            <input type="submit" name="anc_delete" value="Delete">
        </form>
    </div>
</div>
<?php
    }
}
?>

<!-- Create New annoucement -->
<div class="announcement">
    <div class="insideAnc">
        <form id="anc" action="dashboardHome.php" method="POST">
            <label for="anc_header">Heading</label>
            <br>
            <input type="text" name="anc_header" placeholder="enter header ..." required>
            <br>
            <label for="anc_desc">Description</label>
            <br>
            <textarea name="anc_desc" rows="6" cols="50" required></textarea>
            <br>
            <input type="submit" name="anc_button" value="broadcast">
        </form>
    </div>
</div>