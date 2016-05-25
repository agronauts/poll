<?php
class Services extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('poll');
        $this->load->model('choice');
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
                return;
            } 
        }
        $this->output->set_output(json_encode($data));

    }
    
    
    /**
     * Submits a vote to the poll under that ip address
     */
    public function postVote($pollId=NULL, $choice=NULL) {    
        /* Check poll id */
        if ($pollId === NULL) {
            $this->output->set_status_header(400, "Poll Id required");
            return;
        }
        
        /* Check method */
        if ($this->input->server('REQUEST_METHOD') !== "POST") {
            // Wrong method
            $this->output->set_status_header(404, "Can't service this method");
            return;
        }
        
        /* Submit vote */
        $ipAddress = $this->input->ip_address();
        if ($this->poll->postVote($pollId, $choice, $ipAddress)) {
            $this->output->set_status_header(200, "Vote successful");
        }
        else {
            $this->output->set_status_header(400, "Vote unsuccessful");
        }
        
    }
    
    public function votes($pollId=NULL)
    {    
        /* Check poll id */
        if ($pollId === NULL) {
            $this->output->set_status_header(400, "Poll Id required");
            return;
        }
        
        /* Check method */
        if ($this->input->server('REQUEST_METHOD') === "GET") {
            //Output votes of the poll
            $data = $this->choice->getVotes($pollId);
            $this->output->set_output(json_encode($data));
        }
        
        else if ($this->input->server('REQUEST_METHOD') === "DELETE") {
            //Delete all votes for the poll
            if ($this->poll->deleteVotes($pollId)) {
                $this->output->set_status_header(200, "Delete successful");
            }
            else {
                $this->output->set_status_header(400, "Delete unsuccessful");
            }
        }
        
        else {
            // Wrong method, unless additional methods are implemented in the future
            $this->output->set_status_header(404, "Can't service this method");
            return;
        }
    }    
}