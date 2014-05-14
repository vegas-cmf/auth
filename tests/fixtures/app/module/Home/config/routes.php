<?php
return array(
    'login' =>  array(
        'route' =>  'login',
        'paths' => array(
            'module'    =>  'Home',
            'controller'    =>  'Frontend\Home',
            'action'    =>  'login',
            'auth'  =>  false
        )
    ),
    'admin_login' =>  array(
        'route' =>  'admin/login',
        'paths' => array(
            'module'    =>  'Home',
            'controller'    =>  'Backend\Home',
            'action'    =>  'login',
            'auth'  =>  false
        )
    )
);