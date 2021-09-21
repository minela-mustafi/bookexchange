<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class ProfileDao extends BaseDao{

    public function __construct(){
        parent::__construct("profiles");
    }

    public function get_profiles($search, $offset, $limit, $order){
        list($order_column, $order_direction) = self::parse_order($order);
        return $this->query("SELECT * FROM profiles
                            WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                            ORDER_BY ${order_column} ${order_direction}
                            LIMIT ${limit} OFFSET ${offset}",
                            ["name" => strtolower($search)]);
    }

    public function get_profiles_by_user($user_id, $search, $offset, $limit, $order){
        list($order_column, $order_direction) = self::parse_order($order);

        $params = [];
        $query = "SELECT * FROM profiles WHERE 1 = 1 ";

        if($user_id){
            $params["user_id"] = $user_id;
            $query .= "AND user_id = :user_id";
        }

        if(isset($search)){
            $query .= "AND (LOWER(name) LIKE CONCAT('%', :search, '%') OR LOWER(surname) LIKE CONCAT('%', :search, '%')) ";
            $params['search'] = strtolower($search);
        }

        $query .= "ORDER BY ${order_column} ${order_direction} ";
        $query .= "LIMIT ${limit} OFFSET ${offset}";

        return $this->query($query, $params);
    }
}

?>