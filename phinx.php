<?php

$envirement = ini_get('yaf.environ');
$filename = ".env.".$envirement.".ini";

$configDict = parse_ini_file($filename);

$default = 
[
    'paths' => [
        'migrations' => './migrations'
    ],
    'environments' => [
        'default_migration_table' => 't_migrations',
        'default_database' => $envirement,
        $envirement => [
            'adapter' => $configDict['database.database_type'],
            'host'    => $configDict['database.server'],
            'name'    => $configDict['database.database_name'],
            'user'    => $configDict['database.username'],
            'pass'    => $configDict['database.password'],
            'port'    => $configDict['database.port'],
            'charset' => $configDict['database.charset'],
        ],
    ],
    'version_order' => 'creation'
];

return $default;