<?php
function school_db_connect(&$link1) {
    $link1 = mysqli_connect('10.64.144.5', '23jya02', '23jya02', '23jya02');
    if (!mysqli_set_charset($link1, "utf8")) {
        printf("Error loading character set utf8: %s\n", mysqli_error($link1));
        exit();
    }
    if (mysqli_connect_errno()) {
        die("データベースに接続できません:" . mysqli_connect_error() . "\n");
    }
}
?>
