<?php
require_once('functions/global.php');
require_once('functions/configuration.php');
require_once('scanDisplay.php');



function uploadForm(){
    $form = '';
    $form .= form('upload','POST','?p=upload&action=check',true,'Uploader un Fichier');
    $form .= input('MAX_FILE_SIZE','hidden',false,3000000);
    $form .= input('file[]','file','Fichier',false,null,30,false,false,true);
    $form .= submit('Uploader','success');
    $form .= finform();

    return $form;
}
function uploadRenameForm($file){
    $oldFile = $file;
    $file = pathinfo($file,PATHINFO_FILENAME);
    $form = '';
    $form .= form('rename','POST','?p=upload&action=renameCheck&file='.$_GET['file'],false,'Renaome le fichier');
    $form .= input('file','text','Fichier',$file);
    $form .= submit('Renommer','success');
    $form .= finform();
    $form .= displayOne($oldFile);
    return $form;
}

function uploadRooting(&$content=false){
    if(!empty($_GET['action'])){
        switch($_GET['action']){
            case 'form':
                $content = uploadForm();
                break;
            case 'check':
                uploadCheck();
                redirect();
                break;
            case 'delet':
                uploadDelet($_GET['file']);
                redirect();
                break;
            case 'deletList':
                if(isUser()){uploadDeletList();}
                else{redirect();}
                break;
            case 'rename':
                $content = (isUser()?uploadRenameForm($_GET['file']):redirect());
                break;
            case 'renameCheck':
                $content = (isUser()?uploadRenameCheck():redirect());
                break;
            default:
                $content = uploadForm();
        }
    }else{
        $content = uploadForm();
    }
}

function uploadRenameCheck(){
    $newName = check($_POST['file'],false);
    $fileExt = pathinfo($_GET['file'],PATHINFO_EXTENSION);
    $newName = UPLOAD_DIRECTORY.str_replace(array('&',' '),'-',$newName['value']).'.'.$fileExt;
    if(!uploadCheckName($newName)){
        errorAdd('Nom de fichier déjà utilisé','warning');
        redirect('index.php?p=upload&action=rename&file='.$_GET['file']);
        exit;
    }
    if(!rename ( UPLOAD_DIRECTORY.$_GET['file'] , $newName )){
        errorAdd('Erreur pendant le renommage du fichier','danger');
        redirect('index.php?p=upload&action=rename&file='.$_GET['file']);
        exit;
    };
    errorAdd('Fichier correctement renommé','info');
    redirect();
}

function uploadCheckName($name){
    if (file_exists($name)){
        return false;
    }
    return true;
}
function uploadRename($file,$rename=false,$i=1){
    $file = pathinfo($file);
    if($rename===false){
        $rename = $file['dirname'].'/'.$file['filename'].'_'.$i.'.'.$file['extension'];
    }else {
        $rename = $file['dirname'].'/'.$rename.'.'.$file['extension'];
    }
    return $rename;
}
function uploadCheckFormat($file,$fileTmp){
    $extOk = ['jpg','jpeg','gif','png']; // A DEPLACER DANS LE FICHIER DES GLOBAL
    $file = pathinfo($file);

    // on verifie l'extension du fichier
    if (!in_array(strtolower ($file['extension']),$extOk)){
        return false;
    }

    // on vérifie si le fichier répond comme une image
    if (!getimagesize ($fileTmp)){
        return false;
    }
    return true;


}
function uploadCheck(){
    if(!empty($_FILES['file'])){
        $nbFile = count($_FILES['file']['error']);
        $file = $_FILES['file'];
        for($ii=0;$ii<$nbFile;$ii++){
            if ($file['error'][$ii]===0){
                $new_file = UPLOAD_DIRECTORY.htmlentities(str_replace(array('&',' '),'-',basename($file['name'][$ii])));


                // SI LE FICHIER EXISTE DEJA, ON RENAME
                $newFileName = $new_file;
                $i = 1;
                while (!uploadCheckName(substr($newFileName ,2))){
                    $newFileName = uploadRename($new_file,false,$i);
                    $i++;
                }

                // ON VERIFIE LE TYPE DE FICHIER
                if (!uploadCheckFormat($newFileName,$file['tmp_name'][$ii])){
                    errorAdd('Fichier non autorisé !','danger');
                    return false;
                }

                if (move_uploaded_file($_FILES['file']['tmp_name'][$ii], $newFileName)){
                    errorAdd('fichier "Téléversé" :D :D :D','success');
                }else{
                    errorAdd('Erreur lors de l\'enregistrement du fichier','danger');
                }
            }else{
                switch($file['error'][$ii]){
                    case 1:
                        errorAdd('La taille de votre fichier est trop grand [serveur]','danger');
                        break;
                    case 2:
                        errorAdd('La taille de votre fichier est trop grand [appli]','danger');
                        break;
                    case 3:
                        errorAdd('Le fichier n\'a été que partiellement téléchargé.','danger');
                        break;
                    case 4:
                        errorAdd('Aucun fichier envoyé','danger');
                        break;
                    case 6:
                        errorAdd('Dossier temporraire manquant','danger');
                        break;
                    case 7:
                        errorAdd('Erreur d\écriture sur le serveur','danger');
                        break;
                    case 8:
                        errorAdd('Erreur d\'extension interne.','danger');
                        break;
                    default:
                        errorAdd('Erreur lors de l\'envoi du fichier)');


                }
                errorAdd('Erreur lors de l\'envoi du fichier','danger');
            }
        }
    }
    return true;
}
function uploadDelet($file){
    if(!isUser()){
        errorAdd('Serieusement....','danger');
        return false;
    }
    if(!unlink(UPLOAD_DIRECTORY.$file)){
        errorAdd('Erreur lors de la suppresion du fichier'.$file,'danger');
        return false;
    }
    unlink(UPLOAD_DIRECTORY.'.thumb/'.$file);
    errorAdd('Fichier correctement supprimé','info');
    return true;
}
function uploadDeletList(){
    if (empty($_POST['fileList'])){
        errorAdd('Aucun fichier séléctionné.','warning');
        redirect();
        exit;}
    foreach($_POST['fileList'] as $file){
        uploadDelet($file);
    }
    redirect();
}