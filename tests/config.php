<?php
return array(
    'mongo' => array(
        'dbname'    => getenv('MONGO_DB_NAME'),
        'host'      => getenv('VEGAS_CMF_AUTH_MONGO_PORT_27017_TCP_ADDR'),
        'port'      => getenv('VEGAS_CMF_AUTH_MONGO_PORT_27017_TCP_PORT')
    ),

    'session' => array(
        'cookie_name'   =>  'sid',
        'cookie_lifetime'   =>  36*3600, //day and a half
        'cookie_secure' => 0,
        'cookie_httponly' => 1
    ),

    'plugins' => array(
        'security' => array(
            'class' => 'SecurityPlugin',
            'attach' => 'dispatch'
        )
    )

);