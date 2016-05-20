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
    
    
    /**
     * Submits a vote to the poll under that ip address
     */
    public function postVote($pollId=NULL) {    
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
        if ($this->poll->postVote($pollId, $ipAddress)) {
            echo 'hi';
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
            $data = $this->getVotes($pollId);
            $this->output->set_output(json_encode($data));
        }
        else if ($this->input->server('REQUEST_METHOD') === "DELETE") {
            //Delete all votes for the poll
            if ($this->deleteVotes($pollId)) {
                $this->output->set_status_header(200, "Vote successful");
            }
            else {
                $this->output->set_status_header(400, "Vote unsuccessful");
            }
        }
        else {
            // Wrong method, unless additional methods are implemented in the future
            $this->output->set_status_header(404, "Can't service this method");
            return;
        }
    }
    
    /**
     * Gets the votes for a particular poll
     */
    private function getVotes($pollId) {
        return 1;
    }
    
    /**
     * Deletes all votes for a poll
     */
    private function deleteVotes($pollId) {
        return 1;
    }


}