
<div class="naveachfolder">
    <form action="../dashboardHome.php" method="get">
        <input type="hidden" name="previous_id" value=<?php echo $path[0] ?>>
        <input style="min-width:130px; margin:0vh 0.5vw" type="submit" name="previous" value=<?php echo "'" . "Home" . "'" ?>>
    </form>
</div>
<?php
for ($i = 1; $i < count($path) - 1; $i++) {
?>
    <div class="naveachfolder">
        <form action="manageCoursesAdmin.php" method="get">
            <input type="hidden" name="previous_id" value=<?php echo $path[$i] ?>>
            <input style="min-width:130px; margin:0vh 0.5vw" type="submit" name="previous" value=<?php echo "'" . $pathNames[$i] . "'" ?>>
        </form>
    </div>
<?php
}
?>