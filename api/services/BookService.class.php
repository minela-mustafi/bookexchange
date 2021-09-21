<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/BookDao.class.php';

class BookService extends BaseService{

    public function __construct()
    {
        $this->dao = new BookDao();
    }

    public function get_books($search, $offset, $limit, $order){
        if($search){
            return $this->dao->get_books($search, $offset, $limit, $order);
        }
        else{
            return $this->dao->get_all($offset, $limit, $order);
        }
    }

    public function add_book($user, $book){
        if(!isset($book['title'])) throw new Exception("Title is missing.");
        if(!isset($book['author'])) throw new Exception("Author is missing.");
        $book['owner_id'] = $user['id'];
        return parent::add($book);
    }

    public function update_book($user, $id, $book){
        $db_book = $this->dao->get_by_id($id);
        if($db_book['owner_id'] != $user['id']){
            throw new Exception("Invalid owner of the book", 403);
        }
        return $this->update($id, $book);
    }

    public function get_by_user_id($user_id){
        return $this->dao->get_by_user_id($user_id);
    }

    public function get_books_by_user($user_id, $search, $offset, $limit, $order){
        return $this->dao->get_books_by_user($user_id, $search, $offset, $limit, $order);
    }

}

?>