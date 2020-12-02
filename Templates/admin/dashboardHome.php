<?php
session_start();
if (isset($_SESSION["adminid"])) {
    $_SESSION["user_id"] = $_SESSION["adminid"];

    // collections from the database are accessed
    include "../../connectDatabase.php";
    $folders = $db->folders;
    $accounts = $db->accounts;
    $studentAccounts = $db->studentAccounts;
    $teacherAccounts = $db->teacherAccounts;

    // We will get clg id from the session
    $clg_id = $_SESSION["adminid"];
    $access_id = $_SESSION['accessId'];
    $_SESSION['path'] = $access_id;
    $_SESSION['pathNames'] = "general";
    $_SESSION['parent_id'] = new MongoDB\BSON\ObjectID($access_id);

    $path = explode("-", $_SESSION['path']);
    $parentFolderId = $_SESSION['parent_id'];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin Dashboard</title>

        <link rel="stylesheet" href="../../CSS/admin/dashboardHome.css">
        <link rel="stylesheet" href="../../CSS/navStyle.css">
        <link rel="stylesheet" href="../../CSS/Folder/folder.css">
        <link rel="stylesheet" href="../../CSS/Folder/addFolder.css">
        <link rel="stylesheet" href="../../CSS/admin/announcement.css">
        <link rel="stylesheet" href="../../CSS/admin/overlay.css">
        
    </head>

    <body>
        <!-- The overlay -->
        <div id="myNav" class="overlay">

            <!-- Button to close the overlay navigation -->
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

            <!-- Overlay content -->
            <div class="overlay-content">
                <form method="POST" action="#" enctype="multipart/form-data">
                    ...................
                    <input type="file" name="image">
                    ..................
                    <button type="submit" name="imageUpload">Submit</button>
                </form>
            </div>

        </div>

        <div id="top"></div>

        <div class="wrapper">
            <?php
            include "dashboardHeader.php";
            ?>
            <div class="content" style="z-index: 10;">
                <div class="manageCourse" style="height: 200px;">
                    <?php
                    include "courses/manageCourses.php"
                    ?>
                </div>
                <div class="accounts" id="accounts">
                    <div class="a">
                        <form action="accounts/manageAccounts.php" method="post">
                        <label class="accountButton">
                        <svg style="width: 120px; height:120px" xmlns="http://www.w3.org/2000/svg" height="512pt" viewBox="-14 0 512 512" width="512pt">
                            <path d="m20.605469 438.855469c-11.378907 0-20.605469-9.222657-20.605469-20.601563v-377.046875h329.65625v398.070313zm0 0" fill="#d8d8d8" />
                            <path d="m329.65625 61.8125v377.464844l-30.90625-.039063v-377.425781zm0 0" fill="#afafaf" />
                            <path d="m329.65625 51.507812v-30.902343c0-11.378907-9.222656-20.605469-20.601562-20.605469h-288.449219c-11.378907 0-20.605469 9.226562-20.605469 20.605469v41.207031h329.660156v-10.304688" fill="#8175ba" />
                            <path d="m329.65625 20.605469v41.207031h-30.90625v-41.207031c0-11.386719-9.21875-20.605469-20.605469-20.605469h30.90625c11.382813 0 20.605469 9.21875 20.605469 20.605469zm0 0" fill="#575293" />
                            <path d="m293.601562 407.953125h-257.542968c-2.847656 0-5.152344-2.308594-5.152344-5.152344v-304.933593c0-2.84375 2.304688-5.152344 5.152344-5.152344h257.542968c2.84375 0 5.152344 2.308594 5.152344 5.152344v304.933593c0 2.84375-2.308594 5.152344-5.152344 5.152344zm0 0" fill="#fff" />
                            <path d="m118.472656 205.007812h-46.359375c-5.691406 0-10.300781-4.613281-10.300781-10.304687v-60.78125c0-5.6875 4.609375-10.300781 10.300781-10.300781h46.359375c5.6875 0 10.300782 4.613281 10.300782 10.300781v60.78125c0 5.691406-4.613282 10.304687-10.300782 10.304687zm0 0" fill="#f7e1aa" />
                            <path d="m128.257812 243.636719h-66.960937c-4.269531 0-7.726563-3.457031-7.726563-7.726563 0-4.265625 3.457032-7.722656 7.726563-7.722656h66.960937c4.265626 0 7.726563 3.457031 7.726563 7.722656 0 4.269532-3.460937 7.726563-7.726563 7.726563zm0 0" fill="#afafaf" />
                            <path d="m128.257812 274.542969h-66.960937c-4.269531 0-7.726563-3.457031-7.726563-7.726563 0-4.265625 3.457032-7.726562 7.726563-7.726562h66.960937c4.265626 0 7.726563 3.460937 7.726563 7.726562 0 4.269532-3.460937 7.726563-7.726563 7.726563zm0 0" fill="#afafaf" />
                            <path d="m107.65625 305.449219h-46.359375c-4.269531 0-7.726563-3.460938-7.726563-7.726563 0-4.269531 3.457032-7.726562 7.726563-7.726562h46.355469c4.269531 0 7.726562 3.460937 7.726562 7.726562.003906 4.265625-3.457031 7.726563-7.722656 7.726563zm0 0" fill="#afafaf" />
                            <path d="m87.050781 336.355469h-25.753906c-4.269531 0-7.726563-3.460938-7.726563-7.726563 0-4.269531 3.457032-7.726562 7.726563-7.726562h25.753906c4.265625 0 7.726563 3.457031 7.726563 7.726562 0 4.265625-3.460938 7.726563-7.726563 7.726563zm0 0" fill="#afafaf" />
                            <path d="m422.527344 388.378906c33.789062 26.648438 56.355468 66.570313 59.472656 112.621094.402344 5.949219-4.320312 11-10.285156 11h-293.386719c-5.960937 0-10.6875-5.050781-10.285156-10.996094 3.105469-46.035156 25.589843-85.8125 59.273437-112.46875zm0 0" fill="#f2d67c" />
                            <path d="m471.71875 512h-30.300781c5.699219-.300781 10.136719-5.222656 9.746093-10.992188-1.863281-27.527343-10.683593-52.867187-24.683593-74.492187l20.316406-13.269531.585937-.390625c19.75 24.28125 32.347657 54.589843 34.613282 88.140625.402344 5.957031-4.3125 11.003906-10.277344 11.003906zm0 0" fill="#e2b061" />
                            <path d="m447.382812 412.855469-.585937.390625-85.328125 55.722656c-5.585938 3.644531-13.035156 2.296875-16.96875-3.070312l-19.46875-26.527344-.074219-.09375.050781-.0625 37.808594-50.785156 59.710938-.054688c9.167968 7.234375 17.5 15.445312 24.855468 24.480469zm0 0" fill="#e2b061" />
                            <path d="m447.382812 412.855469-.585937.390625-20.316406 13.269531c-3.070313-4.738281-6.386719-9.292969-9.929688-13.652344-.917969-1.132812-1.855469-2.246093-2.800781-3.347656-.867188-1.019531-1.753906-2.019531-2.660156-3.007813-.679688-.75-1.367188-1.503906-2.070313-2.246093 4.851563-4.890625 9.28125-10.207031 13.21875-15.882813h.285157c3.699218 2.914063 7.253906 5.984375 10.675781 9.210938.492187.460937.976562.925781 1.453125 1.390625 4.511718 4.367187 8.765625 9.003906 12.730468 13.875zm0 0" fill="#d18b3f" />
                            <path d="m325.09375 439.277344-.0625.09375-19.480469 26.527344c-3.949219 5.367187-11.394531 6.71875-16.96875 3.070312l-85.359375-55.742188-.054687-1c7.171875-8.726562 15.269531-16.667968 24.148437-23.695312l29.96875-.019531 67.722656 50.707031zm0 0" fill="#e2b061" />
                            <path d="m206.742188 320.996094c0 65.324218 52.957031 118.28125 118.28125 118.28125 65.324218 0 118.28125-52.957032 118.28125-118.28125v-58.816406l-100.214844-72.457032-136.347656 72.457032zm0 0" fill="#fcd09f" />
                            <path d="m443.304688 262.179688v58.8125c0 32.667968-13.238282 62.234374-34.644532 83.640624s-50.984375 34.644532-83.640625 34.644532c-5.234375 0-10.394531-.339844-15.453125-.996094 26.488282-3.460938 50.210938-15.671875 68.1875-33.648438 21.40625-21.40625 34.644532-50.972656 34.644532-83.640624v-58.8125zm0 0" fill="#f4b06c" />
                            <path d="m439.128906 390.164062h-54.960937c-4.265625 0-7.726563-3.460937-7.726563-7.726562s3.460938-7.726562 7.726563-7.726562h54.960937c9.613282 0 17.140625-7.535157 17.140625-17.152344v-47.425782c0-4.269531 3.460938-7.726562 7.726563-7.726562s7.726562 3.457031 7.726562 7.726562v47.425782c0 17.976562-14.621094 32.605468-32.59375 32.605468zm0 0" fill="#d8d8d8" />
                            <path d="m462.449219 301.980469c-4.265625 0-7.722657-3.460938-7.722657-7.726563v-50.730468c0-21.59375-4.796874-42.253907-14.257812-61.402344-.035156-.070313-.070312-.140625-.105469-.210938 0 0-1.316406-2.800781-5.71875-10.28125-2.164062-3.675781-.9375-8.410156 2.742188-10.574218 3.675781-2.167969 8.414062-.9375 10.574219 2.738281 4.453124 7.570312 6.046874 10.820312 6.394531 11.558593 10.5 21.277344 15.820312 44.210938 15.820312 68.171876v50.730468c.003907 4.265625-3.457031 7.726563-7.726562 7.726563zm0 0" fill="#d8d8d8" />
                            <path d="m187.59375 301.976562c-4.265625 0-7.726562-3.460937-7.726562-7.726562v-50.726562c0-24.164063 5.300781-47.144532 15.753906-68.300782.183594-.371094 1.660156-3.246094 6.308594-11.132812 2.167968-3.675782 6.90625-4.898438 10.582031-2.730469 3.675781 2.164063 4.898437 6.902344 2.730469 10.578125-4.394532 7.457031-5.796876 10.179688-5.808594 10.207031-9.351563 18.929688-14.113282 39.609375-14.113282 61.375v50.726563c0 4.269531-3.460937 7.730468-7.726562 7.730468zm0 0" fill="#d8d8d8" />
                            <path d="m443.519531 185.089844c-2.101562 1.019531-4.335937 1.503906-6.53125 1.503906-3.808593 0-7.539062-1.453125-10.371093-4.121094 0 0-1.800782-2.449218-3.824219-5.632812-4.171875-6.121094-8.910157-11.828125-14.132813-17.050782-21.40625-21.40625-50.984375-34.644531-83.640625-34.644531-43.050781 0-80.734375 23.003907-101.410156 57.382813h-.277344c-4.265625 4.261718-10.847656 5.53125-16.484375 2.800781-5.183594-2.515625-8.136718-7.675781-8.136718-13 0-2.636719.71875-5.304687 2.265624-7.71875 26.125-40.886719 71.917969-68.050781 123.929688-68.050781 52.230469 0 98.1875 27.378906 124.261719 68.558594 4.4375 7.015624 1.820312 16.335937-5.648438 19.972656zm0 0" fill="#8175ba" />
                            <path d="m443.304688 243.421875v38.238281s-46.449219-5.230468-96.488282-45.492187c.074219-.039063.15625-.082031.230469-.125 25.949219-14.636719 52.25-33.902344 75.746094-59.203125 12.949219 18.96875 20.511719 41.886718 20.511719 66.582031zm0 0" fill="#a8704a" />
                            <path d="m443.304688 243.421875v38.238281s-12.195313-1.371094-30.832032-8.136718v-30.09375c0-1.203126-.023437-2.398438-.0625-3.582032-.453125-15.394531-3.84375-30.042968-9.640625-43.402344 1.820313-1.640624 3.644531-3.296874 5.449219-4.988281.679688-.628906 1.347656-1.265625 2.027344-1.914062.640625-.597657 1.269531-1.207031 1.898437-1.8125.515625-.507813 1.03125-1.011719 1.535157-1.503907 3.078124-3.039062 6.117187-6.160156 9.117187-9.386718 12.945313 18.96875 20.507813 41.886718 20.507813 66.582031zm0 0" fill="#845036" />
                            <path d="m422.792969 176.839844c-23.496094 25.300781-49.796875 44.566406-75.746094 59.207031-.074219.039063-.15625.082031-.230469.125-71.421875 40.226563-140.074218 45.492187-140.074218 45.492187v-38.242187c0-65.324219 52.953124-118.273437 118.277343-118.273437 32.65625 0 62.234375 13.238281 83.640625 34.644531 5.222656 5.222656 9.960938 10.929687 14.132813 17.046875zm0 0" fill="#c4946c" />
                            <path d="m422.792969 176.839844c-2.996094 3.226562-6.035157 6.347656-9.117188 9.386718-.503906.496094-1.019531 1-1.535156 1.503907-.625.609375-1.253906 1.214843-1.894531 1.8125-.679688.648437-1.351563 1.289062-2.03125 1.917969-1.800782 1.6875-3.625 3.347656-5.449219 4.984374-2.988281-6.890624-6.613281-13.453124-10.804687-19.59375-4.175782-6.121093-8.914063-11.828124-14.136719-17.050781-17.984375-17.984375-41.753907-30.214843-68.257813-33.65625 5.054688-.65625 10.21875-.996093 15.453125-.996093 32.65625 0 62.230469 13.238281 83.636719 34.644531 5.226562 5.222656 9.964844 10.929687 14.136719 17.046875zm0 0" fill="#a8704a" />
                            <path d="m238.496094 254.308594c-3.644532 0-6.890625-2.589844-7.585938-6.304688-.789062-4.191406 1.972656-8.230468 6.167969-9.015625 55.179687-10.355469 101.78125-41.636719 131.160156-66.054687 3.28125-2.726563 8.152344-2.28125 10.878907 1.003906 2.730468 3.28125 2.28125 8.152344-1.003907 10.878906-30.785156 25.589844-79.75 58.390625-138.183593 69.359375-.484376.089844-.960938.132813-1.433594.132813zm0 0" fill="#a8704a" />
                            <g fill="#747a89">
                                <path d="m443.300781 285.472656c0-7.847656 6.363281-14.210937 14.210938-14.210937 7.847656 0 14.210937 6.363281 14.210937 14.210937v34.269532c0 7.851562-6.363281 14.210937-14.210937 14.210937-7.847657 0-14.210938-6.359375-14.210938-14.210937zm0 0" />
                                <path d="m479.109375 314.730469c2.847656 0 5.152344-2.308594 5.152344-5.152344v-13.9375c0-2.847656-2.304688-5.152344-5.152344-5.152344h-13.429687v24.242188zm0 0" />
                                <path d="m206.742188 285.472656c0-7.847656-6.359376-14.210937-14.210938-14.210937-7.847656 0-14.207031 6.363281-14.207031 14.210937v34.269532c0 7.851562 6.359375 14.210937 14.207031 14.210937 7.851562 0 14.210938-6.359375 14.210938-14.210937zm0 0" />
                                <path d="m184.441406 290.488281v24.242188h-13.507812c-2.832032 0-5.152344-2.320313-5.152344-5.152344v-13.9375c0-2.847656 2.308594-5.152344 5.152344-5.152344zm0 0" />
                                <path d="m381.804688 398.164062c-8.519532 0-15.453126-6.929687-15.453126-15.453124 0-8.519532 6.933594-15.453126 15.453126-15.453126 8.519531 0 15.453124 6.933594 15.453124 15.453126 0 8.523437-6.933593 15.453124-15.453124 15.453124zm0-15.460937v.007813c0-.007813 0-.007813 0-.007813zm0 0" />
                            </g>
                            <path d="m279.246094 325.410156c-3.511719 0-6.355469-2.84375-6.355469-6.355468v-12.46875c0-3.511719 2.84375-6.359376 6.355469-6.359376 3.511718 0 6.359375 2.847657 6.359375 6.359376v12.46875c0 3.511718-2.847657 6.355468-6.359375 6.355468zm0 0" fill="#755d4a" />
                            <path d="m370.929688 325.410156c-3.511719 0-6.359376-2.84375-6.359376-6.355468v-12.46875c0-3.511719 2.847657-6.359376 6.359376-6.359376 3.507812 0 6.355468 2.847657 6.355468 6.359376v12.46875c0 3.511718-2.847656 6.355468-6.355468 6.355468zm0 0" fill="#755d4a" />
                            <path d="m325.089844 388.753906c-16.121094 0-30.433594-9.660156-36.457032-24.613281-1.3125-3.257813.261719-6.960937 3.519532-8.273437 3.257812-1.3125 6.960937.261718 8.273437 3.519531 4.074219 10.113281 13.757813 16.648437 24.664063 16.648437 10.902344 0 20.585937-6.535156 24.660156-16.648437 1.3125-3.257813 5.019531-4.832031 8.273438-3.523438 3.257812 1.316407 4.832031 5.019531 3.523437 8.277344-6.027344 14.949219-20.335937 24.613281-36.457031 24.613281zm0 0" fill="#755d4a" />
                        </svg>
                        <input style="display: none;" type="submit" value="">
                        </label>
                        </form>
                    </div>
                    <div class="c" style="font-size: 20px;">
                        <label>NUMBER OF STUDENTS<br>
                            COUNT:<?php
                            $stu_count=count(iterator_to_array($studentAccounts->find(["clgId"=>$clg_id])));
                        echo $stu_count;
                        ?><br><br>
                            NUMBER OF TEACHERS<br>
                            COUNT:<?php
                            $teacher_count=count(iterator_to_array($teacherAccounts->find(["clgId"=>$clg_id])));
                        echo $teacher_count;
                        ?>
                        </label>
                    </div>
                </div>
                <?php
                include "announcement/Dashannouncement.php"
                ?>
                <div class="recentUsers" id="recentUsers">
                    <?php

                    $cursor = $studentAccounts->find(['clgId' => $clg_id], [
                        'sort' => ['lastSeen' => -1],
                        'limit' => 5
                    ]);
                    foreach ($cursor as $person) {
                        if (isset($person['lastSeen'])) {
                            // get all the information of particular person
                            $utcdatetime = $person['lastSeen'];
                            $datetime = $utcdatetime->toDateTime();
                            $time = $datetime->format(DATE_RSS);
                            /********************Convert time local timezone*******************/
                            $dateInUTC = $time;
                            $time = strtotime($dateInUTC . ' UTC');
                            $dateInLocal = date("Y-m-d H:i:s", $time);
                    ?>
                            <div class="particularUser">
                                <span><?php echo $person['name'] ?></span>
                                <span><?php echo $person['email'] ?></span>
                                <span><?php echo $dateInLocal ?></span>
                            </div>
                        <?php
                        }
                    }

                    $cursor = $teacherAccounts->find(['clgId' => $clg_id], [
                        'sort' => ['lastSeen' => -1],
                        'limit' => 5
                    ]);

                    foreach ($cursor as $person) {
                        if (isset($person['lastSeen'])) {
                            // get all the information of particular person
                            $utcdatetime = $person['lastSeen'];
                            $datetime = $utcdatetime->toDateTime();
                            $time = $datetime->format(DATE_RSS);
                            /********************Convert time local timezone*******************/
                            $dateInUTC = $time;
                            $time = strtotime($dateInUTC . ' UTC');
                            $dateInLocal = date("Y-m-d H:i:s", $time);
                        ?>
                            <div class="particularUser">
                                <span><?php echo $person['name'] ?></span>
                                <span><?php echo $person['email'] ?></span>
                                <span><?php echo $dateInLocal ?></span>
                            </div>
                            <br>
                    <?php
                        }
                    }
                    ?>
                </div>

            </div>
        </div>

    </body>
    <script>
        /* Open when someone clicks on the span element */
        function openNav() {
            console.log('open')
            document.getElementById("myNav").style.width = "100%";
        }

        /* Close when someone clicks on the "x" symbol inside the overlay */
        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>

    </html>
<?php

} else {
    header("Location: ../home/signin-signup.php");
    exit();
}
?>