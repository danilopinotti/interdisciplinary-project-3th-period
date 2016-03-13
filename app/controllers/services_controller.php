<?php class ServicesController extends ApplicationController {

   public function index() {
      $this->title = 'Listagem de serviços';
      $this->services = Service::all();
   }

   public function _new() {
      $this->service = new Service();
      $this->submit = 'Salvar';
      $this->action = $this->urlFor("/servicos");
   }

   public function create() {
      $this->service = new Service($this->params['service']);

      $this->submit = 'Salvar';
      $this->action = $this->urlFor("/servicos");
      
      if($this->service->save()){
      	Flash::message('success', 'Serviço Cadastrada com Sucesso!!');
      	$this->redirectTo('/servicos');
      }
      else{
      	Flash::message('danger', 'Existe dados Invalidos!!');
         $this->submit = 'Salvar';
         $this->action = $this->urlFor("/servicos");
         $this->render('new');
      }
   }

   public function show(){
      $this->title = 'Serviços';
      //fazer verificação para id que não exite
      $this->service = Service::findById($this->params[':id']);
   }

   public function edit(){
      $this->title = 'Editar Serviço';
      $this->service = Service::findById($this->params[':id']);
      $this->submit = 'Atualizar';
      $this->action = $this->urlFor("/servicos/{$this->service->getId()}");
   }

   public function update(){
      $this->service = Service::findById($this->params[':id']);

      if ($this->service->update($this->params['service'])) {
        Flash::message('success', 'Registro atualizado com sucesso!');
        $this->redirectTo('/servicos');
     } else {
        Flash::message('danger', 'Existe dados incorretos no seu formulário!');
        $this->submit = 'Atualizar';
        $this->action = $this->urlFor("/servicos/{$this->service->getId()}");
        $this->render('edit');
     }
  }

  public function delete() {
    $service = Service::findById($this->params[':id']);
    $service->delete();
    Flash::message('success', 'Serviço removido com sucesso!');
    $this->redirectTo("/servicos");
  }

} ?>
