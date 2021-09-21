<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/ProfileDao.class.php';

class ProfileService extends BaseService{

    public function __construct()
    {
        $this->dao = new ProfileDao();
    }

    public function get_profiles($search, $offset, $limit, $order){
        if($search){
            return $this->dao->get_profiles($search, $offset, $limit, $order);
        }
        else{
            return $this->dao->get_all($offset, $limit, $order);
        }
    }

    public function add_profile($user, $profile){
        $profile['created'] = date(Config::DATE_FORMAT);
        $profile['user_id'] = $user['id'];
        return parent::add($profile);
    }

    
    public function update_profile($user, $id, $profile){
        $db_profile = $this->dao->get_by_id($id);
        if($db_profile['user_id'] != $user['id']){
            throw new Exception("Invalid user profile", 403);
        }
        return $this->update($id, $profile);
    }


    public function get_profiles_by_user($user_id, $search, $offset, $limit, $order){
        return $this->dao->get_profiles_by_user($user_id, $search, $offset, $limit, $order);
    }
}

?>
