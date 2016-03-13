<?php class ServiceOrdersController extends ApplicationController {

   public function index() {
      $this->title = 'Ordens de serviços';
      $this->service_orders = ServiceOrder::allOpen();
   }

   public function situations_index(){
      $situation = $this->params[':situation'];
      $name_db = ['abertas' => 'Em aberto', 
                  'aprovadas' => 'Aprovada',
                  'concluidas' => 'Concluída',
                  'reprovadas' => 'Reprovada',
                  'canceladas' => 'Cancelada' ];
      
      if ($situation == 'todas'){
         $this->title = 'Ordens de serviços: '.$situation;
         $this->service_orders = ServiceOrder::all();
         $this->render('index');
      }

      if(!isset($name_db[$situation])){
         Flash::message('danger','Página não existente.');
         $this->redirectTo('/ordens-servicos');
      }
      $this->title = 'Ordens de serviços: '.$name_db[$situation];
      $this->service_orders = ServiceOrder::allSituation($name_db[$situation]);
      $this->render('index');
   }

   public function generate_pdf() {
   	echo 'implementar';
   	exit;
   }

   public function delete(){
	   $service_order = ServiceOrder::findById($this->params[':id']);
	   $service_order->delete();
	   Flash::message('success', 'Serviço removido com sucesso!');
	   $this->redirectTo("/ordens-servicos");
   }

   public function cancel(){
      $service_order = ServiceOrder::findById($this->params[':id']);
      $service_order->cancel();
      Flash::message('warning', 'Ordem cancelada com sucesso!');
      $this->redirectTo("/ordens-servicos");
   }

   public function _new(){
   	$this->service_order = new ServiceOrder();
      $this->service_order->setEmployeesId($_SESSION['user']['id']);
      $this->submit = 'Criar ordem';
      $this->action = $this->urlFor("/ordens-servicos");
   }

   public function create(){
      $this->service_order = new ServiceOrder($this->params['service_order']);

      $this->submit = 'Salvar';
      $this->action = $this->urlFor("/ordens-servicos");
      
      if($this->service_order->save()){
         Flash::message('success', 'Ordem de serviço criada com sucesso');
         $this->redirectTo('/ordens-servicos/'.ServiceOrder::lastInsert()->getId().'/adicionar-servico');
      }
      else{
         Flash::message('danger', 'Existe dados Invalidos!!');
         $this->submit = 'Salvar';
         $this->action = $this->urlFor("/ordens-servicos");
         $this->render('new');
      }
   }

   public function modify_order(){
      $this->service_order = ServiceOrder::findById($this->params[':id']);
      $this->service_order->update($this->params['service_order']);

      Flash::message('success','Ordem de serviço atualizada com sucesso!');
      $this->redirectTo('/ordens-servicos/'.$this->params[':id']);
   }

   public function manage_item_services(){
      $this->service_order = ServiceOrder::findByID($this->params[':id']);
      $this->items_services = ItemServiceOrder::findByServiceOrderId($this->params[':id']);
      $this->action_add = $this->urlFor("/ordens-servicos/adicionar-servico");
      $this->submit_add = "Adicionar";
   }

   public function update_item_services(){
      $this->new_item_service_order = new ItemServiceOrder($this->params['item_service']);
      if($this->new_item_service_order->save()){
         Flash::message('success','Serviço adicionado com sucesso');
      }
      else{
         Flash::message('danger','Serviço inválido');
      }
      $this->redirectTo('/ordens-servicos/'.$this->params['item_service']['service_orders_id'].'/adicionar-servico');

   }

   public function delete_item_services(){
      $this->item_service = ItemServiceOrder::findById($this->params[':item_service']);
      $this->service_order = ServiceOrder::findById($this->item_service->getServiceOrdersId());
      $this->item_service->delete();
      $this->service_order->updateTotalCost();
      Flash::message('success','Serviço removido da ordem de serviços.');
      $this->redirectTo('/ordens-servicos/'.$this->params[':service_order'].'/adicionar-servico');

   }

   public function show(){
      $this->service_order = ServiceOrder::findById($this->params[':id']);
      $this->service_order->processedOrder();
      if($this->service_order->getSituation()->getId() == '4') $this->redirectTo('/ordens-servicos/'.$this->params[':id'].'/ver');
      $this->items_services = ItemServiceOrder::findByServiceOrderId($this->params[':id']);
   }

   public function only_show(){
      $this->service_order = ServiceOrder::findById($this->params[':id']);
      $this->items_services = ItemServiceOrder::findByServiceOrderId($this->params[':id']);
   }

} ?>
