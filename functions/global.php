<?php
session_start();

/**
 * Create a cookie
 *
 * @param $name
 * @param $value
 * @param int $time_life, default 1 month
 */
function cookieSet($name,$value,$time_life=2592000){
    setcookie($name,$value,time()+$time_life);
}

/**
 * Get cookie value
 *
 * @param $name
 * @return bool
 */
function cookieGet($name){
    if (!empty($_COOKIE[$name])){
        return $_COOKIE[$name];
    }
    return false;
}

/**
 * Delete cookie, all if no params
 *
 * @param string $name
 */
function cookieReset($name='all'){
    if ($name!='all'){
        setcookie($name,'',time()-3600);
    }
    else{
        foreach ($_COOKIE as $key => $value) {
            setcookie($key,'',time()-3600);
        }
    }
}


/**
 * redirect function
 *
 * @param string $url
 */
function redirect($url='index.php'){
    header ("Location:".$url);
    exit();
}

/**
 * Check user session
 *
 * @return bool
 */
function isUser(){
    if(sessionGet('user')!==false){
        return true;
    }
    return false;
}

/**
 * Display error messages
 *
 * @return bool|string
 */
function errorList(){
    if (!empty($_SESSION['err'])){
        $error_list = '';
        foreach ($_SESSION['err'] as $error_mess) {
            $error_list .='<p class="alert alert-'.$error_mess[1].'">'.$error_mess[0].'</p>';
        }
        $_SESSION['err'] = array();
        return $error_list;
    }else{
        return false;
    }
}

/**
 * Add Message
 *
 * @param string $message
 * @param string $lvl (Bootstrap value: info,danger,warning,success)
 */
function errorAdd($message='Une erreur c\'est produite',$lvl='info'){
    $_SESSION['err'][] = [$message,$lvl];
}


/**
 * Create/Edit Session variable
 * It's dirty... i know...
 *
 * @param $name
 * @param bool $nameB
 * @param bool $nameC
 * @param $value
 */
function sessionSet($name,$nameB=false,$nameC=false,$value){
    if(!empty($name) && !empty($value)){
        if ($nameC!==false && $nameB!==false){
            $_SESSION[$name][$nameB][$nameC] = $value;
        }elseif($nameB!==false){
            $_SESSION[$name][$nameB] = $value;
        }
        else{
            $_SESSION[$name] = $value;
        }

    }
}

/**
 * Return Session value, null if not defined or null
 *
 * @param $name
 * @return bool
 */
function sessionGet($name){
    if(!empty($_SESSION[$name])){
        return $_SESSION[$name];
    }
    return false;
}

/**
 * Clear Session
 */
function sessionReset(){
    session_destroy();
    session_start();
    $_SESSION['err'] = array(array('Session néttoyée.','info'));
    redirect();
}
