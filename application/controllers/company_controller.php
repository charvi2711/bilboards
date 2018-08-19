<?php

class company_controller extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('company_modal');
                $this->load->model('basic_data_table_model','person');
        }

        public function index(){
                
        }

}
?>