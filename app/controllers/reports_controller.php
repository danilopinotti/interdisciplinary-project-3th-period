<?php class ReportsController extends ApplicationController {

   public function index() {
      $this->title = 'Relatórios';
      $this->reports = Report::all();
   }

   public function show(){
   	$employee_id = $this->params[':id'];


   }

} ?>
