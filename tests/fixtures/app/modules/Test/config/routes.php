<?php
use Vegas\Http\Method;

return array(
    'forward' => array(
        'route' => '/forward',
        'paths' => array(
            'module'    =>  'Test',
            'controller' => 'Frontend\Test',
            'action'    =>  'forward',

            'auth'  =>  false
        ),
    ),
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
    ),
    'multiauth'    =>  array(
        'route' =>  '/multiauth',
        'paths' =>  array(
            'module'    =>  'Test',
            'controller'    =>  'Backend\Test',
            'action'    =>  'multiauth',

            'auth'  =>  json_encode(['authAdmin', 'authUser'])
        )
    )
);