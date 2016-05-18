<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @file polls.php
 * @author Patrick Nicholls, Adapted from Matthew Ruffell
 * @date 18/05/2016
 * @brief This file simply serves up the original angular frontpage
 */
class Polls extends CI_Controller 
{
    /**
     * Loads the front angular page
     */
    public function index()
    {
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->view('polls');
    }
}
