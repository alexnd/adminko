<?php

//TODO: make route id and uri configurable
Route::set('adminko', 'admincp(/<action>(/<id>))', array('id' => '[a-zA-Z0-9_-]+', ))
    ->defaults(array('controller' => 'adminko', 'action' => 'index', ));