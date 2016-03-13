<?php
    require 'application.php';
    $router = new Router($_SERVER['REQUEST_URI']);

    $router->get('/', array('controller' => 'HomeController', 'action' => 'index'));

    //rotas para categorias

	$router->get('/categorias', array('controller' => 'CategoriesController', 'action' => 'index'));
	$router->get('/categorias/novo', array('controller' => 'CategoriesController', 'action' => '_new'));
	$router->post('/categorias', array('controller' => 'CategoriesController', 'action' => 'create'));
	$router->get('/categorias/:id', array('controller' => 'CategoriesController', 'action' => 'show'));
	$router->get('/categorias/:id/editar', array('controller' => 'CategoriesController', 'action' => 'edit'));
	$router->post('/categorias/:id', array('controller' => 'CategoriesController', 'action' => 'update'));
	$router->get('/categorias/:id/deletar', array('controller' => 'CategoriesController', 'action' => 'delete'));

    //rotas para serviços
    $router->get('/servicos', array('controller' => 'ServicesController', 'action' => 'index'));
    $router->get('/servicos/novo', array('controller' => 'ServicesController', 'action' => '_new'));
    $router->post('/servicos', array('controller' => 'ServicesController', 'action' => 'create'));
    $router->get('/servicos/:id', array('controller' => 'ServicesController', 'action' => 'show'));
    $router->get('/servicos/:id/editar', array('controller' => 'ServicesController', 'action' => 'edit'));
    $router->post('/servicos/:id', array('controller' => 'ServicesController', 'action' => 'update'));
    $router->get('/servicos/:id/deletar', array('controller' => 'ServicesController', 'action' => 'delete'));
	
    //rotas para clientes
    $router->get('/clientes/autocomplete-search', array('controller' => 'ClientsController', 'action' => 'autoCompleteSearch'));
    $router->get('/clientes/fisico/cadastro', array('controller' => 'ClientsController', 'action' => 'physical_new'));
	$router->get('/clientes/juridico/cadastro', array('controller' => 'ClientsController', 'action' => 'juridical_new'));
    $router->post('/clientes/fisico/cadastro', array('controller' => 'ClientsController', 'action' => 'physical_create'));
    $router->post('/clientes/juridico/cadastro', array('controller' => 'ClientsController', 'action' => 'juridical_create'));
    
    $router->get('/clientes/juridico/:id/editar', array('controller' => 'ClientsController', 'action' => 'juridical_edit'));
    $router->post('/clientes/juridico/:id', array('controller' => 'ClientsController', 'action' => 'juridical_update'));
    
    $router->get('/clientes/fisico/:id/editar', array('controller' => 'ClientsController', 'action' => 'physical_edit'));
    $router->post('/clientes/fisico/:id', array('controller' => 'ClientsController', 'action' => 'physical_update'));
     
    
    $router->get('/clientes', array('controller' => 'ClientsController', 'action' => 'index'));
    $router->get('/clientes/:id', array('controller' => 'ClientsController', 'action' => 'show'));
    
    $router->get('/clientes/jsoncities/:uf', array('controller' => 'ClientsController', 'action' => 'load_cities'));
      
    $router->get('/clientes/:id/deletar', array('controller' => 'ClientsController', 'action' => 'delete'));
    
    //rotas para ordem de serviços
    $router->get('/ordens-servicos', array('controller' => 'ServiceOrdersController', 'action' => 'index'));
    $router->get('/ordens-servicos/visualizar/:situation', array('controller' => 'ServiceOrdersController', 'action' => 'situations_index'));
    $router->get('/ordens-servicos/novo', array('controller' => 'ServiceOrdersController', 'action' => '_new'));
    $router->post('/ordens-servicos', array('controller' => 'ServiceOrdersController', 'action' => 'create'));
    $router->get('/ordens-servicos/fechados', array('controller' => 'ServiceOrdersController', 'action' => 'closed_orders'));
    $router->get('/ordens-servicos/:id', array('controller' => 'ServiceOrdersController', 'action' => 'show'));
    $router->get('/ordens-servicos/:id/editar', array('controller' => 'ServiceOrdersController', 'action' => 'edit')); 
    $router->get('/ordens-servicos/:id/deletar', array('controller' => 'ServiceOrdersController', 'action' => 'delete'));
    $router->get('/ordens-servicos/:id/cancelar', array('controller' => 'ServiceOrdersController', 'action' => 'cancel'));
    $router->get('/ordens-servicos/:id/gerar-pdf', array('controller' => 'ServiceOrdersController', 'action' => 'generate_pdf'));
    $router->get('/ordens-servicos/:id/adicionar-servico', array('controller' => 'ServiceOrdersController', 'action' => 'manage_item_services'));
    $router->post('/ordens-servicos/adicionar-servico', array('controller' => 'ServiceOrdersController', 'action' => 'update_item_services'));
    $router->get('/ordens-servicos/items-servicos/:item_service/:service_order/deletar', array('controller' => 'ServiceOrdersController', 'action' => 'delete_item_services'));
    $router->post('/ordens-servicos/:id', array('controller' => 'ServiceOrdersController', 'action' => 'modify_order'));
    
    $router->get('/ordens-servicos/:id/ver', array('controller' => 'ServiceOrdersController', 'action' => 'only_show'));



    $router->get('/relatorios', array('controller' => 'ReportsController', 'action' => 'index'));
    $router->get('/relatorios/:id', array('controller' => 'ReportsController', 'action' => 'show'));
    
    $router->post('/logout', array('controller' => 'SessionsController', 'action' => 'logout'));
    $router->get('/login', array('controller' => 'SessionsController', 'action' => 'login'));
    $router->post('/login', array('controller' => 'SessionsController', 'action' => 'autenticate'));

    $router->load();
?>
