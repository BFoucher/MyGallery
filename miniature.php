<?php
require_once('functions/global.php');


/**
 * Generate a maniature
 *
 * @param $file
 * @param int $width
 * @param int $height
 * @return bool
 */
function miniature($file,$width=300,$height=300){
    if (empty($file)){
        errorAdd('Erreur à la crétation de la miniature (empty file)','danger');
        return false;
    }
    $ext =  pathinfo($file,PATHINFO_EXTENSION);
    $image = new Imagick(UPLOAD_DIRECTORY.$file);
    if (strtolower($ext)!=='gif'){

        $imgW = $image->getImageWidth();
        $imgH = $image->getImageHeight();
        ($imgH>$imgW?$width=floor($imgW*$height/$imgH):$height=floor($imgH*$width/$imgW));
        $image->thumbnailImage($width,$height,true,true);
        $image->writeImage(UPLOAD_DIRECTORY.'/.thumb/'.$file);
        return true;
    }
    return true;
}