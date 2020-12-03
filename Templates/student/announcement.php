<?php

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
            <br>
            <label for=""><?php echo $heading ?></label>            
            <br>
            <textarea name="anc_desc"  rows="6" cols="50" disabled required><?php echo $description ?></textarea>
            <br>
    </div>
</div>
<?php
    }
}

$particular_folder = $folders->findOne(['_id' => $_SESSION['parent_id']]);
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
            <br>
            <label for=""><?php echo $heading ?></label>            
            <br>
            <textarea name="anc_desc"  rows="6" cols="50" disabled required><?php echo $description ?></textarea>
            <br>
    </div>
</div>
<?php
    }
}
?>