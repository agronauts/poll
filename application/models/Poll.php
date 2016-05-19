<?php
/*
 * Declare the Product class, representing a row of the products table.
 * Since the database was imported from elsewhere and has capital letters
 * at the start of each field name, an internal tweak is used to convert
 * column names to php lower-case-first format.
 *
 * Implements only the Read function, since we're just implementing a product
 * browser, plus a listAll function that returns a map from productID to
 * productName for all products in the database.
 */
class Poll extends CI_Model {
    public $id;
    public $title;
    public $question;
    public $choices;

    public function __construct() {
        $this->load->database();
        $this->load->model('choice');
    }

    /*
     * Return a Product object read from the database for the given product.
     * @param int $id  Id of the product to be returned.
     * @return a Product instance
     * @throws a generic exception if no such product exists in the database.
     */
    public function read($id) {
        $poll = new Poll(); 
        $query = $this->db->get_where('Polls', array('id'=>$id));
        
        // Bug here, not sure if this actually verifies it or not but enables app to run
        if ($query->num_rows() !== 1) {
            throw new Exception("Poll ID $id not found in database");
        }
        
        $rows = $query->result();
        $row = $rows[0];
        $poll->load($row); 
        $poll->choices = Choice::getChoices($poll->id);

                
        return $poll;
    }

    /** Return an associative array id=>productName for all products in the
     *  database, or all matching a given categoryId (if given).
     * @param int $catId the ID in the categories table; only products in
     * this category are returned if given. Otherwise all products are returned.
     * @return associative array mapping productId to product
     */
    public function listAll() {
        $this->db->select('*');
        $rows = $this->db->get('Polls')->result();
        $list = array();
        foreach ($rows as $row) {
            $poll = new Poll();
            $poll->load($row);
            $list[] = $poll;
        }
        return $list;
    }

    // Given a row from the database, copy all database column values
    // into 'this', converting column names to fields names by converting
    // first char to lower case.
    private function load($row) {
        foreach ((array) $row as $field => $value) {
            $fieldName = strtolower($field[0]) . substr($field, 1);
            $this->$fieldName = $value;
        }
    }
    
};

