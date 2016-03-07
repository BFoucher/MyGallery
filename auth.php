<?php
require_once('functions/global.php');
require_once('functions/form.php');
require_once('functions/configuration.php');

function authRooting(&$content=false){
    if(!empty($_GET['action'])){
        switch($_GET['action']){
            case 'form':
                $content = authForm();
                break;
            case 'check':
                authCheck();
                redirect();
            case 'logout':
                authLogOut();
            default:
                $content = authForm();
        }
    }else{
        $content = authForm();
    }
}

function authForm(){
    $form = '<div class="well well-lg">';
    $form .= form('loggin','POST','?p=auth&action=check','Informations');
    $form .= input('username','text','Identifiant');
    $form .= input('password','password','Mot de passe');
    $form .= '<br /><p class="text-right">'.submit('Se connecter','success').'</p>';
    $form .= finform();
    $form .= '</div>';

    return $form;
}


function authCheck(){
    $user = check($_POST['username']);
    $pass = check($_POST['password']);
    $passVerify = password_verify($pass['value'] , PSW );

    if ($user['value']===USERNAME && $passVerify===true){
        sessionSet('user',false,false,$user['value']);
        errorAdd('Bonjour <strong>'.$user['value'].'</strong>, vous êtes bien connécté.','info');
        return true;
    }else {
        errorAdd('Mauvais identifiant/mot de passe', 'danger');
        redirect('index.php?p=auth&action=form');
        return false;
    }
}


function authLogOut(){
    sessionReset();
    cookieReset();
    redirect();
}

