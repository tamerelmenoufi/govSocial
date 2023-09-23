<?php
    session_start();
    include("/appinc/connect.php");
    include("fn.php");
    $con = AppConnect('app');
    $conApi = AppConnect('information_schema');
    $md5 = md5(date("YmdHis"));