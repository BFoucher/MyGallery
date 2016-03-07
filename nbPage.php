<?php

function nbItem(){
    if (isset($_GET['nbPage'])){
        setcookie('nbPage',$_GET['nbPage']);
        return $_GET['nbPage'];
    }
    if (cookieGet('nbPage')!==false){
        if (intval(cookieGet('nbPage'))){
            return cookieGet('nbPage');
        }
        return MAX_ITEM_PAGE;
    }
    return MAX_ITEM_PAGE;
}