<?php
    include './config/config.inc.php';
    include './config/mysql.inc.php';
    $link=connectMySQL();
    header('charset=UTF-8');

    // $numberOfRecords = 50;
    // for ($i = 0; $i < $numberOfRecords; $i++) {
    //     $zone = "Zone" . rand(1, 5); 
    //     $type = rand(1, 3);
    //     $state = 1;
    //     $costHour = 50;
    //     if($type == 3){
    //         $electricCharger = 1;
    //     }else{
    //         $electricCharger = rand(0, 1);
    //     }

    //     $query = "INSERT INTO parking_space (zone, type, state, cost_hour, electric_charger, create_time, update_time, deleted)
    //             VALUES ('$zone', '$type', '$state', '$costHour', '$electricCharger', now(), now(), 0)";

    //     execute($link, $query);

    //     if(mysqli_affected_rows($link) == 1){
    //         $newUserID = $link->insert_id;
    //         echo "插入成功，新記錄的 ID 為: " . $newUserID;
    //     }
    //     else{
    //         echo '新增失敗';
    //     }
    // }
?>