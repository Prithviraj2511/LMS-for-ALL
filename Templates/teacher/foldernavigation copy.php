
<?php
for ($i = 0; $i < count($path) - 1; $i++) {
?>
    <div class="naveachfolder">
        <form action="./dashboardHome.php" method="get">
            <input type="hidden" name="previous_id" value=<?php echo $path[$i] ?>>
            <input style="min-width:130px; margin:0vh 0.5vw" type="submit" name="previous" value=<?php echo "'" . $pathNames[$i] . "'" ?>>
        </form>
    </div>
<?php
}
?>