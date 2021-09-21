<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';

class UserService extends BaseService{

    public function __construct()
    {
        $this->dao = new UserDao();
    }

    public function register($user){
        // Validation of user data
        $db_user = $this->dao->get_user_by_email($user['email']);
        if(isset($db_user['id'])) throw new Exception("User with the same email already exist", 400);
        $user['role'] = "user";
        $user['password'] = md5($user['password']);
        $user['token'] = md5(random_bytes(16));
        return parent::add($user);
    }

    public function update_user($id, $user)
    {
        $user['password'] = md5($user['password']);
        return parent::update($id, $user);
    }

    public function login($user){
        $db_user = $this->dao->get_user_by_email($user['email']);
        if(!isset($db_user['id'])) throw new Exception("User doesn't exist", 400);
        if($db_user['password'] != md5($user['password'])) throw new Exception("Invalid password", 400);
        return $db_user;
    }

    public function confirm($token){
        $user = $this->dao->get_user_by_token($token);
        if(!isset($user['id'])) throw new Exception("Invalid token", 400);
        $this->dao->update($user['id'], ["token" => NULL]);
        return $user;
    }

}

?>
