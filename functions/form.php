<?php
/**
 * Start form
 *
 * @param $name
 * @param string $method
 * @param string $action
 * @param bool $encypt
 * @param string $legend  - not use
 * @return string
 */
function form($name,$method='POST',$action='#',$encypt=false,$legend=''){
  return '<form name="'.$name.'" method="'.$method.'" action="'.$action.'" '.($encypt==true?'enctype="multipart/form-data"':'').'>';
}

/**
 * Add Input Form
 * @param $name
 * @param string $type
 * @param bool $label
 * @param null $value
 * @param null $max_length
 * @param null $size
 * @param bool $active
 * @param bool $aufocus
 * @param bool $multiple
 * @return string
 */
function input($name,$type='text',$label=false,$value=null,$max_length=null,$size=null,$active=false,$aufocus=false,$multiple=false){
  $res = '';
  if ($label!==false){
    $res .= '<label for="'.$name.'">'.$label.' : </label>';
  }
  $res .= '<input class="form-control" type="'.$type.'" name="'.$name.'" ';
  if ($value!==null){
    $res .= ' value="'.$value.'"' ;
  }
  if ($max_length>0){
    $res .= 'maxlength="'.$max_length.'" ';
  }
  if ($size>0){
    $res .= 'size="'.$size.'" ';
  }
  if ($active===true){
    $res .= ' checked ';
  }
  if ($aufocus===true){
    $res .= ' autofocus ';
  }
  if ($multiple===true){
    $res .= ' multiple="multiple" ';
  }
  $res .= ' />';
  return $res;
}

/**
 * Add Submit Button
 *
 * @param $name
 * @param bool $class
 * @return string
 */
function submit($name,$class=false){
  return '<input class="btn btn-default '.($class!==false?$class:'').'" type="submit" value="'.$name.'"> ';
}

/**
 * Add radio button
 *
 * @param $name
 * @param $list
 * @param $label
 * @param bool $active
 * @return string
 */
function radioForm($name,$list,$label,$active=false){
  $res = '';
  if (isset($label)){
    $res .= '<label for="'.$name.'">'.$label.'</label>';
  }
  foreach ($list as $key => $value) {
    $res .= '<label>'.$value;
    $res .= '<input class="form-control" type="radio" name="'.$name.'" value="'.$value.'"  '.($active===true?'checked':'').'>';
    $res .= '</label> ';
  }
  return $res;
}


/**
 * Check Post value, return array [value,[errors]]
 *
 * @param string $val
 * @param bool $empty_var
 * @param bool $html_entities
 * @param bool $bool
 * @return array
 */
function check($val='',$empty_var=true,$html_entities=true,$bool=false){
  $result = ["check"=>true,"value"=>$val,"err"=>array()];
  $result['value'] = trim($val);
  if (!empty($result['value'])){
    if ($html_entities==true){
      $result['value'] = htmlentities($result['value']);
    }
    if ($bool==true){
      if ($result['value']!=0 && $result['value']!=1){
        $result['check'] = false;
        $result['err'][] = ['Not Booleen','danger'];
      }
    }
  }else{
      if ($empty_var==false ){
        $result['check'] = false;
        $result['err'][] = ['Empty','danger'];
      }
  }
  return $result;
}

/**
 * End Form
 *
 * @return string
 */
function finForm(){
  return '</form>';
}