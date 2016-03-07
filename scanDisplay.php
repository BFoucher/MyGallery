<?php
require_once('functions/global.php');
require_once('functions/form.php');
require_once('miniature.php');
require_once('nbPage.php');

function paginator(&$tab,$pageActuelle,&$pageJumper){
    $tabLen = count($tab);
    $maxItem = nbItem();
    $nbPage = floor($tabLen/$maxItem);
    if ($tabLen%$maxItem>0){$nbPage++;}

    if ($pageActuelle>$nbPage){
        errorAdd('Ca te dirais pas d\'être un utilisateur sympa pour une fois?');
        $pageActuelle = 1;
    }
    if($nbPage>1){
        $tab = array_splice($tab,(($pageActuelle-1)*$maxItem),$maxItem);
        $next = '#';
        $prev = '#';
        if ($pageActuelle+1<=$nbPage){$next='?page='.($pageActuelle+1);}
        if ($pageActuelle-1>=1){$prev='?page='.($pageActuelle-1);}
        $pageJumper ='<nav>';
        $pageJumper .='<ul class="pagination">';

        $pageJumper .='<li class="'.($pageActuelle==1?'disabled':'').'"">';
        $pageJumper .='  <a href="'.$prev.'" aria-label="Previous">';
        $pageJumper .='    <span aria-hidden="true">&laquo;</span>';
        $pageJumper .='  </a>';
        $pageJumper .=' </li>';


        for ($i=1;$i<=$nbPage;$i++){
            $pageJumper .='  <li class="'.($pageActuelle==$i?'active':'').'"><a href="?page='.$i.'">'.$i.'</a></li>';
        }

        $pageJumper .='<li class="'.($pageActuelle==$nbPage?'disabled':'').'"">';
        $pageJumper .='    <a href="'.$next.'" aria-label="Next">';
        $pageJumper .='      <span aria-hidden="true">&raquo;</span>';
        $pageJumper .='    </a>';
        $pageJumper .='  </li>';

        $pageJumper .=' </ul>';
        $pageJumper .='</nav>';

    }
}

function display($tab,$type=false){
    $display = 'Figure';
    $pageJumper ='';
    if (!empty($_GET['page'])){
        $pageActuelle=$_GET['page'];
    }else{
        $pageActuelle=1;
    }
    paginator($tab,$pageActuelle,$pageJumper);
//Quand on force un affichage
    if ($type==='List' || $type==='Figure'){
        $display = 'display'.$type;
        setcookie('displayMode',$type);
        return $display($tab,$pageJumper);
    }

//Aucune info sur l'affichage on vérifie si une cookie de préf est là
    if(cookieGet('displayMode')==='Figure' || cookieGet('displayMode')==='List'){
        $display = 'display'.cookieGet('displayMode');
        return $display($tab,$pageJumper);
    }else{
        //sinon valeur par default
        cookieSet('displayMode','List');
        return displayList($tab,$pageJumper);
    }
}

function displayList($list,$pageJumper){
    if (count($list)<=0){
        $aff  = '<div class="well"> Aucun fichier téléversé pour le moment.</div>';
        return $aff;
    }
    $aff = '<ul class="list-group files-list">';
    $aff .= (isUser()?form('deletList','POST','?p=upload&action=deletList'):'');
    foreach($list as $key=>$file){
        $aff .= '<a href="?p=displayone&file='.$file.'"><li class="list-group-item"><i class="fa fa-file-image-o"></i> '.$file;
        if (isUser()){
            $aff .= '<a href="?p=upload&action=delet&file='.$file.'">';
            $aff .= '<span class="btn btn-xs btn-danger pull-right text-muted"> <i class="fa fa-close"></i> </span>';
            $aff .= '</a>';
            $aff .= '<a href="?p=upload&action=rename&file='.$file.'">';
            $aff .= '<div class="btn btn-xs btn-info pull-right text-muted"> <i class="fa fa-edit"></i> </div>';
            $aff .= '</a>';
            $aff .= '<input type="checkbox" name="fileList[]" value="'.$file.'" class="pull-right" /> ';
        }
        $aff .='</li></a>';
    }
    $aff .= '</ul>';
    $aff .= (isUser()?'<div class="row"><div class="pull-right">'.submit('Supprimer la selection','danger').'</div></div>'.finform():'');
    $aff .= '<div class="row"><div class="col-xs-12 col-lg-6 col-lg-offset-3 text-center">'.$pageJumper.'</div></div>';
    return $aff;
}

function displayFigure($list,$pageJumper){
    if (count($list)<=0){
        $aff  = '<div class="well"> Aucun fichier téléversé pour le moment.</div>';
        return $aff;
    }
    $aff ='<div class="row">';
    foreach($list as $key=>$file){
        $pict = UPLOAD_DIRECTORY.'.thumb/'.$file;
        $ext =  strtolower(pathinfo($file,PATHINFO_EXTENSION));
        if ($ext === 'gif'){$pict = UPLOAD_DIRECTORY.$file;}
        if (!file_exists($pict) && $ext!=='gif'){
            if (miniature($file)){
                errorAdd('Miniature <strong>'.$file.'</strong> crée');
            };
        }
        $aff .= '<a href="?p=displayone&file='.$file.'">';
        $aff .= '<div class="col-lg-3 col-md-4 col-xs-12 minia">';
        $aff .= '<div class="thumbnail">';
        $aff .='<img src='.$pict.' />';
        $aff .= '<div class="caption text-center text-muted">'.$file.'</div>';
        $aff .='</div>';
        $aff .='</div></a>';
    }
    $aff .= '</div>';
    $aff .= '<div class="row"><div class="col-xs-12 col-lg-6 col-lg-offset-3 text-center">'.$pageJumper.'</div></div>';
    return $aff;
}

function displayOne($file){
    if(!file_exists(UPLOAD_DIRECTORY.$file)){
    redirect();
}
    $aff = '<div class="well col-xs-12 text-center">';
    $aff .= '<h2>'.$file.'</h2>';
    $aff .= '<img src='.UPLOAD_DIRECTORY.$file.' style="max-width:80%" />';
    $aff .= '</div>';
    return $aff;
}