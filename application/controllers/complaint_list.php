<?php

class complaint_list extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('complaint_model');
        }

        public function ajax_list()
        {
                $list = $this->person->get_datatables();
                $data = array();
                $no = $_POST['start'];
                foreach ($list as $person) {
                    $no++;
                    $row = array();
                    $row[] = $person->images;

                    //add html for action
                    $row[] = $person->processed;
                 
                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => $this->person->count_all(),
                                "recordsFiltered" => $this->person->count_filtered(),
                                "data" => $data,
                        );
                //output to json format
                echo json_encode($output);
        }

}
?>