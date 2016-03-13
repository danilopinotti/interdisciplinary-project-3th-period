<?php
abstract class Base {
    protected $id;
    protected $createdAt;
    protected $errors = array();

    public function __construct($data = array()){
      $this->createdAt = date('Y-m-d H:i:s');
      $this->setData($data);
    }

    public function validates(){}

    public function getId() {
      return $this->id;
    }

    public function setId($id) {
      $this->id = $id;
    }

    public function getCreatedAt(){
      return $this->createdAt;
    }

    public function setCreatedAt($createdAt){
      $this->createdAt = $createdAt;
    }

    public function errors($index = null) {
      if ($index == null)
        return $this->errors;

      if (isset($this->errors[$index]))
        return $this->errors[$index];

      return false;
    }

    public function isValid() {
      $this->errors = array();
      $this->validates();
      return empty($this->errors);
    }

    public function newRecord(){
      return empty($this->id);
    }

    public function changedFieldValue($field, $table) {
      $db = Database::getConnection();
      $sql = "select {$field} from {$table} where id = :id";

      $statement = $db->prepare($sql);
      $params = array('id' => $this->id);
      $statement->execute($params);
      $result = $statement->fetch();

      $method = "get".$field;
      $field_from_db = $result[$field];

      Logger::getInstance()->log("Mudou: {$this->$method()}", Logger::NOTICE);

      return $field_from_db !== $this->$method();
    }

    public function setData($data = array()) {
      foreach($data as $key => $value){
         $method = "set{$key}";
         $method = ActiveSupport::snakToCamelCase($method);
         $this->$method(strip_tags(trim($value)));
      }
    }

    public function canDelete($tables, $field, $value){
      foreach($tables as $table){
          $sql = "SELECT * FROM {$table} WHERE {$field} = {$value}";
          $params = array($table, $field, $value);

          $db = Database::getConnection();
          $statement = $db->prepare($sql);
          $resp = $statement->execute();

          if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC))
            return false;
      }
      return true;
    }

} ?>
