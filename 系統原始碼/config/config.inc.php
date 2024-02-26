<?php 
    date_default_timezone_set('Asia/Shanghai');//設定時區
    session_start();
    header('Content-type:text/html;charset=utf-8');
    
    //MYSQL資料庫設定
    define('MYSQL_HOST', 'localhost');
    define('MYSQL_USER', 'root');
    define('MYSQL_PASSWORD', '');
    define('MYSQL_DATABASE', 'parking_ms');
    define('MYSQL_PORT', 3306);

    //MongoDB資料庫設定
    define('MONGO_HOST', 'localhost');
    define('MONGO_DATABASE', 'mongodb');
    define('MONGO_PORT', 27017);

    //專案，在伺服器上的絕對路徑
    define('SA_PATH', dirname(dirname(__FILE__)));
    //我們的專案在web根目錄下面的位置（哪個目錄裡面）
    define('SUB_URL', str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', SA_PATH)).'/');
?>