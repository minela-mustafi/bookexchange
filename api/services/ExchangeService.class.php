<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/ExchangeDao.class.php';

class ExchangeService extends BaseService{

    public function __construct()
    {
        $this->dao = new ExchangeDao();
    }


    public function add_exchange($user, $exchange){
        $exchange['lender_id'] = $user['id'];
        $exchange['returned'] = 0;
        $exchange['returndate'] = null;
        return parent::add($exchange);
    }


    public function update_exchange($user, $id, $exchange){
        $exchange = $this->dao->get_by_id($id);
        if($exchange['lender_id'] != $user['id']){
            throw new Exception("Invalid user request", 403);
        }
        return $this->update($id, $exchange);
    }


    public function get_by_book_id($book_id){
        return $this->dao->get_by_book_id($book_id);
    }


    public function get_borrowed($borrower_id){
        return $this->dao->get_by_borrower_id($borrower_id);
    }


    public function get_lent($lender_id){
        return $this->dao->get_by_lender_id($lender_id);
    }


    public function get_not_returned($lender_id){
        return $this->dao->get_by_returned($lender_id, 0);
    }


    public function get_returned($lender_id){
        return $this->dao->get_by_returned($lender_id, 1);
    }


    public function return_book($lender, $id, $return_date){
        $exchange = $this->dao->get_by_id($id);
        if($exchange['lender_id'] != $lender['id']){
            throw new Exception("Invalid user exchange", 403);
        }
        if($exchange['returned'] == 1){
            throw new Exception("This book is already returned", 403);
        }
        $exchange['returned'] = 1;
        $exchange['returndate'] = $return_date;
        return $this->update($id, $exchange);
    }
}

?>