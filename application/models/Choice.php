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
class Choice extends CI_Model {
    public $id;
    public $poll;
    public $choice;
    public $votes;
    
    private static $db;

    public function __construct() {
        $this->load->database();
        self::$db = &get_instance()->db;
    }
    
    public static function getChoices($pollId) {
        self::$db->select('*');
        self::$db->where(array('poll' => $pollId));
        self::$db->order_by("poll", "asc");
        $rows = self::$db->get('Choices')->result();
        $list = array();
        foreach ($rows as $row) {
            $choice = new Choice();
            $choice->load($row);
            $list[] = $choice;
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

