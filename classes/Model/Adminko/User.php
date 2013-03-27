<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Adminko_User extends Model_Auth_User {

    private $_is_admin = null;

    function __get($k) {
        switch ($k) {
            case 'is_admin':
                    if(is_null($this->_is_admin)) {
                        $query = DB::select()->from('roles_users')->where('user_id', '=', $this->id)
                            ->where('role_id', '=', Model_Adminko_Role::ADMIN)->execute()->as_array();
                        $this->_is_admin = (count($query)) ? true : false;
                    }
                    return $this->_is_admin;
            default:
                return parent::__get($k);
        }
    }

}