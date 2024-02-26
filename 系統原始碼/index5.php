<?php
    include_once './config/config.inc.php';
    include_once './config/mongo.inc.php';
    include_once './config/mysql.inc.php';
    $mongoManager = connectMongoDB();
    $link = connectMySQL();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["rowindex"])) {
            $rowindex = $_POST["rowindex"];
            echo <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>停車場管理系統</title>
                        <link rel="stylesheet" href="./static/css/spectre.min.css">
                        <script src="./static/js/jquery-3.3.1.min.js"></script>
                    </head>
                    <body>

                        <div class="container">
                            <div class="columns">
                                <div class="column col-8 col-mx-auto">
                                    <header class="navbar">
                                        <section class="centered">
                                            <div class="navbar-brand mr-2"><h2>停車場管理系統 - {$rowindex}</h2></div>
                                        </section>
                                    </header>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="col-10 col-mx-auto">
                                    <p>
                                        <button class='btn btn-primary' name='' rowindex='' onclick="window.location.href='index.php';">員工管理</button>
                                        <button class='btn btn-success' name='' rowindex='' onclick="window.location.href='index2.php';">車輛管理</button>
                                        <button class='btn btn-success' name='' rowindex='' onclick="window.location.href='index3.php';">停車位管理</button>
                                        <button class='btn btn-error' name='' rowindex='' onclick="window.location.href='index4.php';">收費管理</button>
                                    </p>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-12">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>車牌</th>
                                                            <th>進場時間</th>
                                                            <th>出場時間</th>
                                                            <th>繳費金額</th>
                                                            <th>建立時間</th>
                                                            <th>最後修改時間</th>
                                                            <th>操作</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
        HTML;
            $result = executeMongoDB('fee');
            while ($row = current($result)) {
                if ($row->license_plate === $rowindex) {
                    for ($i = 0; $i < count($row->in_time); $i++) {
                        if(!empty($row->out_time[$i])){
                            $out_time = $row->out_time[$i];
                            $fee = $row->fee[$i];
                        }else{
                            $out_time = '尚未出場';
                            $fee = '尚未收費';
                        }
                        echo <<<HTML
                        <tr>
                            <td class='license-plate' rowindex='{$row->license_plate}'>{$row->license_plate}</td>
                            <td class='in-time' rowindex='{$row->license_plate}'>{$row->in_time[$i]}</td>
                            <td class='out-time' rowindex='{$row->license_plate}'>{$out_time}</td>
                            <td class='fee' rowindex='{$row->license_plate}'>{$fee}</td>
                            <td class='create-time' rowindex='{$row->license_plate}'>{$row->create_time}</td>
                            <td class='update-time' rowindex='{$row->license_plate}'>{$row->update_time}</td>
                            <td>
                                <button class='btn btn-success' name='edit_this_info' rowindex='{$row->license_plate}'>編輯</button>
                                <button class='btn btn-error' name='delete_this_info' rowindex='{$row->license_plate}'>刪除</button>
                            </td>
                        </tr>
                    HTML;
                    }
                    echo <<<HTML
                            </tbody>
                        </table>
                    HTML;
                }
                next($result);
            }
        } else {
            echo "未接收到rowindex";
        }
    } else {
        echo "這不是一個有效的POST請求";
    }
?>
