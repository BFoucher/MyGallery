<?php
require_once('scanList.php');
require_once('scanDisplay.php');


if (!empty($_GET['p'])){
    switch($_GET['p']) {
        case 'auth':
            require_once('auth.php');
            authRooting($content);
            break;
        case 'upload':
            require_once('upload.php');
            uploadRooting($content);
            break;
        case 'gallery':
            $content = display(scanList(),'Figure');
            break;
        case 'list':
            $content = display(scanList(),'List');
            break;
        case 'displayone':
            $content = displayOne($_GET['file']);
                break;

        default:
            $content = display(scanList());
    }
}else{
    require_once('scanList.php');
    require_once('scanDisplay.php');
    $content =  display(scanList());
}