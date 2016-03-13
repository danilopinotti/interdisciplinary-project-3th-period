<?php abstract class BaseController {

  protected $params;
  protected $beforeAction;
  protected $view;
  protected $layout;
  protected $controllerName;

  public function __construct() {
    $this->layout = 'layout/application.phtml';
  }

  public function setParams($params) {
    $this->params = $params;
  }

  public function setView($view) {
    $this->view = $view;
  }

  public function setControllerName($controllerName) {
    $this->controllerName = $controllerName;
  }

  public function render($view = null, $data = array()) {
    require 'core/views/views_helpers_functions.php';

    if ($view !== null)
      $this->view = $view;

    $view = $this->getViewPath();

    extract($data);
    require 'views/'.$this->layout;
    exit();
  }

  /*
   * Método destinada ao redirecionamento de páginas
   * Lembre-se que quando um endereço inicia-se com '/' diz respeito
   * a um caminho absoluto, caso contrário é um caminho relativo.
   */
  protected function redirectTo($address) {
    if (substr($address, 0, 1) == '/')
      header('location: ' . SITE_ROOT . $address);
    else
      header('location: ' . $address);
    exit();
  }

  /*
   * Retorna o endereço da última página carregada,
   * caso não exista retorna o endereço da página principal da aplicação
   */
  protected function back(){
    if (isset($_SERVER['HTTP_REFERER'])){
      return $_SERVER['HTTP_REFERER'];
    }else{
      return '/';
    }
  }

  /*
   * Função para criação de urls
   * Importante, pois com elas não é necessário fazer diversas
   * alterações quando mudar a url principal do site
   */
  public function urlFor($path){
    return SITE_ROOT . $path;
  }

  /*
   * Função a ser executada antes de cada ação
   */
  public function beforeAction($action) {
    if (is_array($this->beforeAction)) {
      foreach ($this->beforeAction as $method => $actions) {
        if ($actions === 'all' || in_array($action, $actions)) {
          $this->$method();
        }
      }
    }
  }

  private function getViewPath() {
    $controller = lcfirst(str_replace('Controller', '', $this->controllerName));
    $controller = strtolower(ActiveSupport::camelToSnake($controller));
    $controller = str_replace('\\_', '/', $controller); # for namespace

    if (substr($this->view, 0, 1) == '_') {
      $view = substr($this->view, 1, strlen($this->view));
    } else {
      $view = $this->view;
    }

    if (substr($view, 0, 1) == '/') {
      return 'views' . $this->view . '.phtml';
    }

    return 'views/' . $controller . '/' . $view . '.phtml';
  }

} ?>
