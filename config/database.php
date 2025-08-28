<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsamiti_prp24' => [
            'driver' => 'mysql',
            'url' => env('DB1_URL'),
            'host' => env('DB1_HOST', '127.0.0.1'),
            'port' => env('DB1_PORT', '3306'),
            'database' => env('DB1_DATABASE', ''),
            'username' => env('DB1_USERNAME', ''),
            'password' => env('DB1_PASSWORD', ''),
            'unix_socket' => env('DB1_SOCKET', ''),
            'charset' => env('DB1_CHARSET', 'latin1'),
            'collation' => env('DB1_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsamiti_prp23' => [
            'driver' => 'mysql',
            'url' => env('DB2_URL'),
            'host' => env('DB2_HOST', '127.0.0.1'),
            'port' => env('DB2_PORT', '3306'),
            'database' => env('DB2_DATABASE', ''),
            'username' => env('DB2_USERNAME', ''),
            'password' => env('DB2_PASSWORD', ''),
            'unix_socket' => env('DB2_SOCKET', ''),
            'charset' => env('DB2_CHARSET', 'latin1'),
            'collation' => env('DB2_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsamiti_prp22' => [
            'driver' => 'mysql',
            'url' => env('DB3_URL'),
            'host' => env('DB3_HOST', '127.0.0.1'),
            'port' => env('DB3_PORT', '3306'),
            'database' => env('DB3_DATABASE', ''),
            'username' => env('DB3_USERNAME', ''),
            'password' => env('DB3_PASSWORD', ''),
            'unix_socket' => env('DB3_SOCKET', ''),
            'charset' => env('DB3_CHARSET', 'latin1'),
            'collation' => env('DB3_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsami_prp21' => [
            'driver' => 'mysql',
            'url' => env('DB4_URL'),
            'host' => env('DB4_HOST', '127.0.0.1'),
            'port' => env('DB4_PORT', '3306'),
            'database' => env('DB4_DATABASE', ''),
            'username' => env('DB4_USERNAME', ''),
            'password' => env('DB4_PASSWORD', ''),
            'unix_socket' => env('DB4_SOCKET', ''),
            'charset' => env('DB4_CHARSET', 'latin1'),
            'collation' => env('DB4_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsami_prp20' => [
            'driver' => 'mysql',
            'url' => env('DB5_URL'),
            'host' => env('DB5_HOST', '127.0.0.1'),
            'port' => env('DB5_PORT', '3306'),
            'database' => env('DB5_DATABASE', ''),
            'username' => env('DB5_USERNAME', ''),
            'password' => env('DB5_PASSWORD', ''),
            'unix_socket' => env('DB5_SOCKET', ''),
            'charset' => env('DB5_CHARSET', 'latin1'),
            'collation' => env('DB5_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsami_prp19' => [
            'driver' => 'mysql',
            'url' => env('DB6_URL'),
            'host' => env('DB6_HOST', '127.0.0.1'),
            'port' => env('DB6_PORT', '3306'),
            'database' => env('DB6_DATABASE', ''),
            'username' => env('DB6_USERNAME', ''),
            'password' => env('DB6_PASSWORD', ''),
            'unix_socket' => env('DB6_SOCKET', ''),
            'charset' => env('DB6_CHARSET', 'latin1'),
            'collation' => env('DB6_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsamiti_esds_prp18' => [
            'driver' => 'mysql',
            'url' => env('DB7_URL'),
            'host' => env('DB7_HOST', '127.0.0.1'),
            'port' => env('DB7_PORT', '3306'),
            'database' => env('DB7_DATABASE', ''),
            'username' => env('DB7_USERNAME', ''),
            'password' => env('DB7_PASSWORD', ''),
            'unix_socket' => env('DB7_SOCKET', ''),
            'charset' => env('DB7_CHARSET', 'latin1'),
            'collation' => env('DB7_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsamiti_prp_17' => [
            'driver' => 'mysql',
            'url' => env('DB8_URL'),
            'host' => env('DB8_HOST', '127.0.0.1'),
            'port' => env('DB8_PORT', '3306'),
            'database' => env('DB8_DATABASE', ''),
            'username' => env('DB8_USERNAME', ''),
            'password' => env('DB8_PASSWORD', ''),
            'unix_socket' => env('DB8_SOCKET', ''),
            'charset' => env('DB8_CHARSET', 'latin1'),
            'collation' => env('DB8_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'sspnsamiti_prp_16' => [
            'driver' => 'mysql',
            'url' => env('DB9_URL'),
            'host' => env('DB9_HOST', '127.0.0.1'),
            'port' => env('DB9_PORT', '3306'),
            'database' => env('DB9_DATABASE', ''),
            'username' => env('DB9_USERNAME', ''),
            'password' => env('DB9_PASSWORD', ''),
            'unix_socket' => env('DB9_SOCKET', ''),
            'charset' => env('DB9_CHARSET', 'latin1'),
            'collation' => env('DB9_COLLATION', 'latin1_swedish_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
