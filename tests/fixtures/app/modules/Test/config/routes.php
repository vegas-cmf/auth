<?php
use Vegas\Http\Method;

return array(
    'products' => array(
        'route' => '/products',
        'paths' => array(
            'module'    =>  'Test',
            'controller' => 'Frontend\Test',
            'action'    =>  'index',

            'auth'  =>  'authUser'
        ),
        'params' => array(
        )
    ),
    'categories'    =>  array(
        'route' =>  '/categories',
        'paths' =>  array(
            'module'    =>  'Test',
            'controller'    =>  'Backend\Test',
            'action'    =>  'index',

            'auth'  =>  'authAdmin'
        )
    )
);