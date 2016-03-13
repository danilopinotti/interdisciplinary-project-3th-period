<?php
  /* Inclui arquivos css
   * Se o caminho começar com / deve ser considerado a partir da pasta ASSETS_FOLDER
   * caso contrário a partir de ASSETS_FORLDER/css/
   */
  function stylesheet_include_tag() {
     $params = func_get_args();

     foreach($params as $param) {
        $path = ASSETS_FOLDER;
        $path .= (substr($param, 0, 1) === '/') ? $param : '/css/' . $param ;
        echo "<link href='{$path}' rel='stylesheet' type='text/css' />";
     }
  }

  /*
   * Inclui arquivos js
   * Se o caminho começar com / deve ser considerado a partir da pasta ASSETS_FOLDER
   * caso contrário a partir de ASSETS_FORLDER/css/
   */
  function javascript_include_tag(){
    $params = func_get_args();
    foreach($params as $param){
      $path = ASSETS_FOLDER;
      $path .= (substr($param, 0, 1) === '/') ? $param : '/js/' . $param ;
      echo "<script src='{$path}' type='text/JavaScript'></script>";
    }
  }

  /*
   * Função para criar links.
   * Importante para definir os caminhos dos arquivos
   * Caso começe com / indica caminho absolute a partir do root da aplicação,
   * caso contrário é camaminho relativo
   */
  function link_to($path, $name, $options = '') {
     if (substr($path, 0, 1) == '/')
        $link = SITE_ROOT . $path;
     else
        $link = $path;
     return "<a href='{$link}' {$options}> $name </a>";
  }

  /*
   * Função para converter boleano em formato amigável
  */
  function pretty_bool($value){
    return $value ? 'Sim' : 'Não';
  }

  function format_date($date){
    return date('d/m/Y h:m:s', strtotime($date));
  }

  function active_class($route) {
    $route = SITE_ROOT . $route;
    if (preg_match('#^' . $route . '$#', $_SERVER['REQUEST_URI']))
      return 'active-menu';

    return '';
  }

  function image_tag($path, $name, $format, $options = "") {
    $path = ASSETS_FOLDER . '/' . $path . '/' . $format . '/' . $name ;
    return "<img src=\"{$path}\" {$options} />";
  }

  function create_input_field($object, $formname ,$name, $description, $placeholder='', $class=''){
    $error_class = $object->errors($name)?'has-error':'';
    $method = "get{$name}";
    $method = ActiveSupport::snakToCamelCase($method);

    return ('<div class="form-group '.$error_class.'">
      <label for="'.$formname.'_'.$name.'">'.$description.'</label>
      <input type="text" class="form-control '.$class.'" id="'.$formname.'_'.$name.'" name="'.$formname.'['.$name.']" 
      placeholder="'.$placeholder.'" value="'.$object->$method().'">
      <span class="help-block">'.$object->errors($name).'</span>
    </div>');
  }



  function create_text_field($object, $formname, $name, $description, $default=''){
    $error_class = $object->errors($name)?'has-error':'';
    $method = "get{$name}";
    $method = ActiveSupport::snakToCamelCase($method);

    return ('<div class="form-group '.$error_class.'">
      <label for="'.$formname.'_'.$name.'">'.$description.'</label>
      <textarea class="form-control" id="'.$formname.'_'.$name.'" name="'.$formname.'['.$name.']" 
     >'.$object->$method().'</textarea>
      <span class="help-block">'.$object->errors($name).'</span>
    </div>');
  }


  function create_radio_field($object, $formname, $name, $description, $values , $mode='radio'){
    if ($mode == 'inline')
      $mode = 'radio-inline';

    $error_class = $object->errors($name)?'has-error':'';
    $method = "get{$name}";
    $method = ActiveSupport::snakToCamelCase($method);

    $code = '<div class="form-group '.$error_class.'"><label>'.$description.'&nbsp;</label>';
    foreach ($values as $key => $value){
      $selected = $key==$object->$method()?'checked="checked"':'';
      $code .= '<label class="'.$mode.'">
                 <input type="radio" name="'.$formname.'['.$name.']" value="'.$key.'" '.$selected.'>'.$value.'</label>';
    }
    $code .= '<span class="help-block">'.$object->errors($name).'</span></div>';
    return $code;
  }

  function create_select_field($object, $formname, $name, $description, $default, $options=array('value'=>'op1'), $selected=0, $fromdb=false, $views = array('value' => '', 'view' => '')){
    $error_class = $object!=''?$object->errors($name)?'has-error':'':'';
    $method = "get{$name}";
    $method = ActiveSupport::snakToCamelCase($method);

    $method_value = "get{$views['value']}";
    $method_value = ActiveSupport::snakToCamelCase($method_value);

    $method_view = "get{$views['view']}";
    $method_view = ActiveSupport::snakToCamelCase($method_view);

    $code = '<div class="form-group '.$error_class.'">';
    $code .= '<label>'.$description.'</label>';
    $code .= '<select class="form-control" name="'.$formname.'['.$name.']" id="field_'.$name.'">';
    if ($fromdb){
      if ($default) $code .= '<option value="">'.$default.'</option>';

      foreach ($options as $option){
        $selected_element = ($option->$method_value() == $selected)?'selected':'';
        $code .= '<option value="'.$option->$method_value().'" '.$selected_element.'>';
        $code .= $option->$method_view();
        $code .= '</option>';
      }
    }
    else{
      foreach ($options as $key => $value){
        $code .= '<option value="'.$key.'">';
        $code .= $value;
        $code .= '</option>';
      }
    }
    
//    $helpblock = '';
//    if ($object->errors() != ''){
//      $helpblock = '<span class="help-block">'.$object->errors($name).'</span>';
//
    
//    }
    $code .= '</select></div>';
    return $code;
  }

  function create_hidden_field($formname, $name, $value){
    return '<input name="'.$formname.'['.$name.']" type="hidden" value="'.$value.'">';
  }

?>
