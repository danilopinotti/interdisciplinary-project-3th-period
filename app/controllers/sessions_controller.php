<?php class SessionsController extends ApplicationController {

   public function logout() {
      UserSession::logout();
      Flash::message('success','Você foi deslogado.');
      $this->redirectTo('/');
   }

   public function login(){
   	  $this->user_session = new UserSession();
   	  $this->title = 'Página de login';
   	  if (isset($_SESSION['user'])){
   	  	$this->redirectTo('/');
   	  }
   }

   public function autenticate(){
	   $this->user_session = new UserSession($_POST['user_session']);
	   if ($this->user_session->isAuthenticate()) {
	    //.. mostra mensagem de autenticação realizada
	    //.. redirecionar para área restrita
	    Flash::message("success", "Usuário autenticado com sucesso!");
	    $this->redirectTo('/');
	   } else {
	    //.. mostra mensagem de email/senha incorretos
	    Flash::message("danger", "Usuário ou/e senha inválidos!");
	    $this->redirectTo('login');
	   }
   }

} ?>
