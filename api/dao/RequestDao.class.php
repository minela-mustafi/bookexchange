<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class RequestDao extends BaseDao{
    
    public function __construct()
    {
        parent::__construct("requests");
    }


    public function get_by_book_id($book_id){
        $params["book_id"] = $book_id;
        return $this->query("SELECT * FROM requests WHERE book_id = :book_id", $params);
    }


    public function get_by_borrower_id($borrower_id){
        $params["borrower_id"] = $borrower_id;
        return $this->query("SELECT * FROM requests WHERE borrower_id = :borrower_id", $params);
    }


    public function get_by_lender_id($lender_id){
        $params["lender_id"] = $lender_id;
        return $this->query("SELECT * FROM requests WHERE lender_id = :lender_id", $params);
    }


    public function get_open_requests($lender_id){
        $params["lender_id"] = $lender_id;
        return $this->query("SELECT * FROM requests WHERE lender_id = :lender_id AND accepted = 0 AND closed = 0", $params);
    }
}

?>