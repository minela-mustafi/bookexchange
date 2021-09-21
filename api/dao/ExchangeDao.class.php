<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class ExchangeDao extends BaseDao{
    
    public function __construct()
    {
        parent::__construct("exchanges");
    }


    public function get_by_book_id($book_id){
        $params["book_id"] = $book_id;
        return $this->query("SELECT * FROM exchanges WHERE book_id = :book_id", $params);
    }

    
    public function get_by_borrower_id($borrower_id){
        $params["borrower_id"] = $borrower_id;
        return $this->query("SELECT * FROM exchanges WHERE borrower_id = :borrower_id", $params);
    }


    public function get_by_lender_id($lender_id){
        $params["lender_id"] = $lender_id;
        return $this->query("SELECT * FROM exchanges WHERE lender_id = :lender_id", $params);
    }


    public function get_by_returned($lender_id, $returned){
        $params["lender_id"] = $lender_id;
        $params["returned"] = $returned;
        return $this->query("SELECT * FROM exchanges WHERE lender_id = :lender_id AND returned = :returned", $params);
    }

}

?>