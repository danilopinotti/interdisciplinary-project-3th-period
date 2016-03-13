<?php class ClientsController extends ApplicationController {

   public function index(){
      $this->title = 'Listagem de clientes';
      $this->clients = Client::all();
   }

   public function show(){
      $this->client = Client::findById($this->params[':id']);
      $this->title = 'Informações sobre '.$this->client->getName();
   }

   public function physical_new() {
      $this->clientp = new ClientP();
      $this->title = 'Cadastro de cliente Físico';

      $this->submit = 'Cadastrar';
      $this->action = $this->urlFor("/clientes/fisico/cadastro");
   }

   public function physical_create() {
      $this->clientp = new ClientP($this->params['clientp']);
      $this->title = 'Cadastro de cliente Físico';

      $this->submit = 'Salvar';
      $this->action = $this->urlFor("/clientes");
      
      if($this->clientp->save()){
         Flash::message('success', 'Cliente cadastrado com Sucesso!!');
         $this->redirectTo('/clientes');
      }
      else{
         Flash::message('danger', 'Existe dados Invalidos!!');
         $this->submit = 'Cadastrar';
         $this->action = $this->urlFor("/clientes/fisico/cadastro");
         $this->render('physical_new');
      }
   }

   public function juridical_new() {
      $this->clientj = new ClientJ();
      $this->title = 'Cadastro de cliente jurídico';

      $this->submit = 'Cadastrar';
      $this->action = $this->urlFor("/clientes/juridico/cadastro");
   }

   public function juridical_create() {
      $this->clientj = new ClientJ($this->params['clientj']);

      $this->submit = 'Salvar';
      $this->action = $this->urlFor("/clientes");
      $this->title = 'Cadastro de cliente jurídico';

      if($this->clientj->save()){
         Flash::message('success', 'Cliente cadastrado com Sucesso!!');
         $this->redirectTo('/clientes');
      }
      else{
         Flash::message('danger', 'Existe dados Invalidos!!');
         $this->submit = 'Cadastrar';
         $this->action = $this->urlFor("/clientes/juridico/cadastro");
         $this->render('juridical_new');
      }
   }

   public function load_cities(){
      $this->cities = City::citiesLikeAsJson($this->params[':uf']);
      echo $this->cities;
      exit;
   }

   public function delete(){
        $client = Client::findById($this->params[':id']);
        if ($client->delete()){
            Flash::message('success', 'Cliente removido com sucesso!');
            $this->redirectTo("/clientes");
            return;
        }
        else {
            Flash::message('danger', 'Impossível remover cliente pois existem ordens de serviços para ele.');
            $this->redirectTo("/clientes");
            return;
        }
   }


   public function juridical_edit(){
         $this->title = 'Editar Cliente';
         $this->clientj = ClientJ::findByClientId($this->params[':id']);
         $this->submit = 'Atualizar';
         $this->action = $this->urlFor("/clientes/juridico/{$this->clientj->getId()}");
   }

   public function juridical_update(){
         $this->clientj = ClientJ::findByClientId($this->params[':id']);

         if ($this->clientj->update($this->params['clientj'])) {
           Flash::message('success', 'Registro atualizado com sucesso!');
           $this->redirectTo('/clientes');
        } else {
           Flash::message('danger', 'Existe dados incorretos no seu formulário!');
           $this->submit = 'Atualizar';
           $this->action = $this->urlFor("/clientes/juridico/{$this->clientj->getId()}");
           $this->render('juridical_edit');
        }   
   }

   public function physical_edit(){
         $this->title = 'Editar Cliente Físico';
         $this->clientp = ClientP::findByClientId($this->params[':id']);
         $this->submit = 'Atualizar';
         $this->action = $this->urlFor("/clientes/fisico/{$this->clientp->getId()}");
   }

   public function physical_update(){
         $this->clientp = ClientP::findByClientId($this->params[':id']);

         if ($this->clientp->update($this->params['clientp'])) {
           Flash::message('success', 'Registro atualizado com sucesso!');
           $this->redirectTo('/clientes');
        } else {
           Flash::message('danger', 'Existe dados incorretos no seu formulário!');
           $this->submit = 'Atualizar';
           $this->action = $this->urlFor("/clientes/fisico/{$this->clientp->getId()}");
           $this->render('physical_edit');
        }   
   }

  public function autoCompleteSearch(){
    $this->users = Client::whereNameLikeAsJson($this->params['query']);
    echo $this->users;
    exit;
 }
}?>
