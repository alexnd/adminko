<?php

class Model_Adminko_Role extends ORM {

    const LOGIN = 1;
    const ADMIN = 2;
    const BAN = 3;

    var $_table_name = 'roles';
}
