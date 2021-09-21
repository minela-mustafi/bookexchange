<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/RequestDao.class.php';

class RequestService extends BaseService{

    public function __construct()
    {
        $this->dao = new RequestDao();
    }


    public function add_request($user, $request){
        $request['borrower_id'] = $user['id'];
        $request['accepted'] = 0;
        $request['closed'] = 0;
        return parent::add($request);
    }


    public function update_request($user, $id, $request){
        $db_request = $this->dao->get_by_id($id);
        if($db_request['borrower_id'] != $user['id']){
            throw new Exception("Invalid user request", 403);
        }
        return $this->update($id, $request);
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


    public function get_open_requests($lender_id){
        return $this->dao->get_open_requests($lender_id);
    }


    public function accept_request($lender, $id){
        $request = $this->dao->get_by_id($id);
        if($request['lender_id'] != $lender['id']){
            throw new Exception("Invalid user request", 403);
        }
        if($request['accepted'] == 1){
            throw new Exception("Request already accepted", 403);
        }
        $request['accepted'] = 1;
        return $this->update($id, $request);
    }


    public function deny_request($lender, $id){
        $request = $this->dao->get_by_id($id);
        if($request['lender_id'] != $lender['id']){
            throw new Exception("Invalid user request", 403);
        }
        if($request['closed'] == 1 && $request['accepted'] == 0){
            throw new Exception("Request already denied", 403);
        }
        $request['accepted'] = 0;
        $request['closed'] = 1;
        return $this->update($id, $request);
    }


    public function close_request($borrower, $id){
        $request = $this->dao->get_by_id($id);
        if($request['borrower_id'] != $borrower['id']){
            throw new Exception("Invalid user request", 403);
        }
        if($request['closed'] == 1){
            throw new Exception("Request already closed", 403);
        }
        $request['closed'] = 1;
        return $this->update($id, $request);
    }
}

?>