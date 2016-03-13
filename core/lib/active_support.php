<?php class ActiveSupport {
    public static function snakToCamelCase($value) {
      return preg_replace('/_/', '', $value);
    }

    public static function camelToSnake($value) {
      return preg_replace_callback('/[A-Z]/', 
             create_function('$match', 'return "_" . strtolower($match[0]);'),
             $value);
    }

} ?>
