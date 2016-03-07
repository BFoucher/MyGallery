<?php
require_once('functions/configuration.php');



function scanList($dir=UPLOAD_DIRECTORY){
    $list = scandir($dir);
    $trash = array();
    $forbiddenList = ['.','..','.thumb']; //TODO moove to config file
    foreach ($list as $key=>$file){
        if (in_array($file, $forbiddenList,true)===true){
            $trash[] = $key;
        }
}

    foreach($trash as $id){
        unset($list[$id]);
    }
    return $list;
}