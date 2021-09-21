<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class BookDao extends BaseDao{

    public function __construct()
    {
        parent::__construct("books");
    }

    
    public function get_books($search, $offset, $limit, $order){
        list($order_column, $order_direction)=self::parse_order($order);
        $params['search'] = strtolower($search);
        return $this->query("SELECT * FROM books
                            WHERE LOWER(title) LIKE CONCAT('%', :search, '%')
                            OR LOWER(author) LIKE CONCAT('%', :search, '%')
                            ORDER_BY ${order_column} ${order_direction}
                            LIMIT ${limit} OFFSET ${offset}",
                            $params);
    }


    public function get_by_user_id($user_id){
        $params["user_id"] = $user_id;
        return $this->query("SELECT * FROM books WHERE owner_id = :user_id", $params);
    }


    public function get_books_by_user($user_id, $search, $offset, $limit, $order){
        list($order_column, $order_direction) = self::parse_order($order);

        $params = [];
        $query = "SELECT * FROM books WHERE 1 = 1 ";

        if($user_id){
            $params["user_id"] = $user_id;
            $query .= "AND owner_id = :user_id";
        }

        if(isset($search)){
            $query .= "AND (LOWER(title) LIKE CONCAT('%', :search, '%') OR LOWER(author) LIKE CONCAT('%', :search, '%')) ";
            $params['search'] = strtolower($search);
        }

        $query .= "ORDER BY ${order_column} ${order_direction} ";
        $query .= "LIMIT ${limit} OFFSET ${offset}";

        return $this->query($query, $params);
    }

}

?>