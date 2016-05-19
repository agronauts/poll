<?php
class Services extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
    }

    public function polls($pollId=NULL)
    {    
        /* Check method */
        if ($this->input->server('REQUEST_METHOD') !== "GET") {
            // Wrong method, unless additional methods are implemented in the future
            $this->output->set_status_header(404, "Can't service this method");
            return;
        }
        
        /* Get and display data */
        $this->output->set_content_type('application/json');
        $this->load->model('poll');
        $this->load->model('choice');
        if ($pollId == NULL) {
            // Asking for all polls
            $data = $this->poll->listAll();
        }
        else {
            // Asking for specific poll
            try {
                $data = $this->poll->read($pollId);
            } catch (Exception $e) {
                $this->output->set_status_header(404, 'Unknown poll ID');
            } 
        }
        $this->output->set_output(json_encode($data));

    }

    
    // Send out a JSON-encoded list of products in a given category.
    // It's a list of objects, each with an id and a name field, ordered
    // by name. [We can't just send it out as it comes from the database
    // because the associative array is encoded as a JSON object and key
    // ordering is arbitrary.
    public function productList() {
        $this->output->set_content_type('application/json');
        $this->load->model('product');
        try {
            $data = $this->product->listAll();
        } catch (Exception $e) {
            $this->output->set_status_header(404, 'Unknown category ID');
            return;
        }
        $list = array();
        foreach ($data as $id=>$name) {
            $list[] = array('id'=>$id, 'name'=>$name);
        }
        $this->output->set_output(json_encode($list));
    }

}