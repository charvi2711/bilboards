<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class district extends CI_Controller {

    private $table_view          = 'districts_view';
    private $table_original      = 'districts';
    private $column_order        = array('district_name','state_name',null);
    private $column_search       = array('district_name','state_name');
    private $order               = array('id' => 'desc');

    private $queryForStates = "SELECT * FROM states ORDER BY state_name ";
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('data_table_with_view_model','person');
        $this->person->var_setter($this->table_original, $this->column_order, $this->column_search, $this->order, $this->table_view);
    }
 
    public function index()
    {
        $data['state']  = array('states' => $this->person->get_query_result($this->queryForStates),);
        $data['page_to_load'] = 'districts';
        $this->load->view('template', $data);
    }
 
    public function ajax_list()
    {
        $list = $this->person->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = $person->district_name;
            $row[] = $person->state_name;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
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
 
    public function ajax_edit($id)
    {
        $data = $this->person->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $data = array(
                'district_name' => $this->input->post('district_name'),
                'state_id' => $this->input->post('state_id'),
            );
        $insert = $this->person->save($data);
        // echo json_encode(array("status" => TRUE));
        echo json_encode(array($insert));
    }
 
    public function ajax_update()
    {
        $data = array(
                'district_name' => $this->input->post('district_name'),
                'state_id' => $this->input->post('state_id'),
            );
        $this->person->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->person->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
}