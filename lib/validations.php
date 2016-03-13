<?php class Validations {

  public static function notEmpty($value, $key = null, &$errors = null){
    if (empty($value)){
      if ($key !== null && $errors !== null) {
        $msg = 'Não deve ser vazio';
        $errors[$key] = $msg;
      }
      return false;
    }
    return true;
  }

  public static function validEmail($email, $key = null, &$errors = null){
    $pattern = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+/';

    if (preg_match($pattern, $email))
      return true;

    if ($key !== null && $errors !== null)
      $errors[$key] = 'Email inválido';

    return false;
  }

  public static function isNumeric($value, $key = null, &$errors = null){
    if (is_numeric($value))
      return true;

    if ($key !== null && $errors !== null)
      $errors[$key] = 'Deve ser um número';

    return false;
  }

  public static function isSelected($value, $key = null, &$errors = null){
    if (empty($value)){
      if ($key !== null && $errors !== null) {
        $msg = 'Deve ser selecionado';
        $errors[$key] = $msg;
      }
      return false;
    }
    return true;
  }


  public static function uniqueField($value, $field, $table, &$errors = null) {
    $sql = "SELECT {$field} FROM {$table} WHERE LOWER({$field}) = :{$field}";
    $params = array("$field" => strtolower($value));

    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $statement->execute($params);


    if ($row = $statement->fetch()) {
      $errors[$field] = 'Já existe um cadastro com esse dado';
      return false;
    }
    return true;
  }

  public static function uniqueFile($value, $key = null, &$errors = null) {
    if (file_exists($value)) {
      if ($key !== null && $errors !== null)
        $errors[$key] = 'Já existe um arquivo com esse nome';
      return false;
    }
    return true;
  }

  public static function lessThen($value, $maxSize, $key = null, &$errors = null) {
    if (strlen($value) > $maxSize) {
      if ($key !== null && $errors !== null)
         $errors[$key] = 'Tamanho máximo exedido';
      return false;
    }
    return true;
  }

  public static function greaterThen($value, $minSize, $key = null, &$errors = null) {
    if (strlen($value) < $minSize) {
      if ($key !== null && $errors !== null)
         $errors[$key] = 'Não deve ser menor que ' . $minSize;
      return false;
    }
    return true;
  }

  public static function inclusionIn($value, $array, $key = null, &$errors = null) {
    if (in_array($value, $array)) {
      return true;
    }

    if ($key !== null && $errors !== null)
      $errors[$key] = 'Tipo não permitido';

    return false;
  }

  public static function isCpf($cpf, $key = null, &$errors = null){
    $valid = 0;
    if(empty($cpf)) {
      if ($key !== null && $errors !== null)
        $errors[$key] = 'CPF inválido';
      return false;    
    }
    $cpf = ereg_replace('[^0-9]', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
    if (strlen($cpf) != 11) {
      if ($key !== null && $errors !== null)
        $errors[$key] = 'CPF inválido';
      return false;
    }
    else if ($cpf == '00000000000' || 
        $cpf == '11111111111' || 
        $cpf == '22222222222' || 
        $cpf == '33333333333' || 
        $cpf == '44444444444' || 
        $cpf == '55555555555' || 
        $cpf == '66666666666' || 
        $cpf == '77777777777' || 
        $cpf == '88888888888' || 
        $cpf == '99999999999') {
        if ($key !== null && $errors !== null)
          $errors[$key] = 'CPF inválido';
        return false;
     } else {   
         
        for ($t = 9; $t < 11; $t++) {
             
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                if ($key !== null && $errors !== null)
                  $errors[$key] = 'CPF inválido';
                return false;
            }
        }
        return true;
    }
    if ($key !== null && $errors !== null)
      $errors[$key] = 'CPF inválido';
    return false;
  }

  public static function isCnpj($cnpj, $key = null, &$errors = null){
    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

  // Valida tamanho
    if (strlen($cnpj) != 14){
      if ($key !== null && $errors !== null)
        $errors[$key] = 'CNPJ inválido';
      return false;
    }

    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
    {
      $soma += $cnpj{$i} * $j;
      $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto)){
      if ($key !== null && $errors !== null)
        $errors[$key] = 'CNPJ inválido';
      return false;
    }

    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
    {
      $soma += $cnpj{$i} * $j;
      $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    if ($cnpj{13} == ($resto < 2 ? 0 : 11 - $resto))
      return true;
    else{
      if ($key !== null && $errors !== null)
        $errors[$key] = 'CNPJ inválido';
      return false;
    }
  }

} ?>
