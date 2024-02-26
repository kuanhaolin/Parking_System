<?php
    include_once './config/config.inc.php';
    include_once './config/mongo.inc.php';
    include_once './config/mysql.inc.php';
    $mongoManager = connectMongoDB();
    $link = connectMySQL();
?>

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
                            <div class="navbar-brand mr-2"><h2>停車場管理系統 - 停車位管理</h2></div>
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
                                            <th>停車位編號</th>
                                            <th>所屬區域</th>
                                            <th>停車位類型</th>
                                            <th>使用狀態</th>
                                            <th>每小時的費用</th>
                                            <th>電動車充電設施</th>
                                            <th>創建時間</th>
                                            <th>最後修改時間</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "select * from parking_space where deleted=0";
                                            $result = execute($link, $query);
                                            while($data = mysqli_fetch_assoc($result)){
                                                $ref1 = $data['type'];
                                                switch ($ref1) {
                                                    case '1':
                                                        $ref1 = '普通';
                                                        break;
                                                    case '2':
                                                        $ref1 = '殘疾人專用';
                                                        break;
                                                    case '3':
                                                        $ref1 = '電動車充電位';
                                                        break;
                                                    default:
                                                        $ref1 = 'ERROR';
                                                        break;
                                                }
                                                $ref2 = $data['state'];
                                                switch ($ref2) {
                                                    case '1':
                                                        $ref2 = '空閒';
                                                        break;
                                                    case '2':
                                                        $ref2 = '預訂';
                                                        break;
                                                    case '3':
                                                        $ref2 = '使用中';
                                                        break;
                                                    default:
                                                        $ref2 = 'ERROR';
                                                        break;
                                                }
                                                $ref3 = $data['electric_charger'];
                                                switch ($ref3) {
                                                    case '0':
                                                        $ref3 = '否';
                                                        break;
                                                    case '1':
                                                        $ref3 = '是';
                                                        break;
                                                    default:
                                                        $ref3 = 'ERROR';
                                                        break;
                                                }
                                                echo <<<HTML
                                                    <tr>
                                                        <td class='id' rowindex='{$data["id"]}'>{$data['id']}</td>
                                                        <td class='zone' rowindex='{$data["id"]}'>{$data['zone']}</td>
                                                        <td class='type' rowindex='{$data["id"]}'>{$ref1}</td>
                                                        <td class='state' rowindex='{$data["id"]}'>{$ref2}</td>
                                                        <td class='cost-hour' rowindex='{$data["id"]}'>{$data['cost_hour']}</td>
                                                        <td class='electric-charger' rowindex='{$data["id"]}'>{$ref3}</td>
                                                        <td class='create-time' rowindex='{$data["id"]}'>{$data['create_time']}</td>
                                                        <td class='update-time' rowindex='{$data["id"]}'>{$data['update_time']}</td>
                                                        <td>
                                                            <button class='btn btn-success' name='edit_this_info' rowindex='{$data["id"]}'>編輯</button>
                                                            <button class='btn btn-error' name='delete_this_info' rowindex='{$data["id"]}'>刪除</button>
                                                        </td>
                                                    </tr>
                                            HTML;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12" style="margin-top: 15px">
                                <button class="btn btn-success centered" id="open_add_modal">添加</button>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="modal" id="modal_edit_info">
                        <a href="#close" class="modal-overlay" aria-label="Close"></a>
                        <div class="modal-container">
                            <div class="modal-header">
                                <div id="close_edit_modal" class="btn btn-clear float-right" aria-label="Close"></div>
                                <div class="modal-title h5">編輯資訊</div>
                            </div>
                            <div class="form-horizontal">
                                <div class="modal-body">
                                    <div class="content">
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-id">車牌號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-id">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-user-id">用戶編號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-user-id" placeholder="用戶編號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-spot-id">停車位編號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-spot-id" placeholder="停車位編號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-vehicle-brand">車輛品牌</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-vehicle-brand" placeholder="車輛品牌">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-vehicle-type">車輛型號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-vehicle-type" placeholder="車輛型號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-vehicle-color">車輛顏色</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-vehicle-color" placeholder="車輛顏色">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-vehicle-state">當前狀態</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-vehicle-state" placeholder="當前狀態">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-special-requirements">特殊需求</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-special-requirements"
                                                    placeholder="特殊需求">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-notes">備註</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-notes" placeholder="備註">
                                            </div>
                                        </div>
                                        <fieldset disabled>
                                            <div class="form-group">
                                                <div class="col-3 col-sm-12">
                                                    <label class="form-label" for="edit-register-time">註冊時間</label>
                                                </div>
                                                <div class="col-9 col-sm-12">
                                                    <input class="form-input" type="text" id="edit-register-time">
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset disabled>
                                            <div class="form-group">
                                                <div class="col-3 col-sm-12">
                                                    <label class="form-label" for="edit-update-time">最後修改時間</label>
                                                </div>
                                                <div class="col-9 col-sm-12">
                                                    <input class="form-input" type="text" id="edit-update-time">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success centered" id="update_info">更新</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="modal_add_info">
                        <a href="#close" class="modal-overlay" aria-label="Close"></a>
                        <div class="modal-container">
                            <div class="modal-header">
                                <div id="close_add_modal" class="btn btn-clear float-right" aria-label="Close"></div>
                                <div class="modal-title h5">添加信息</div>
                            </div>
                            <div class="form-horizontal">
                                <div class="modal-body">
                                    <div class="content">
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-id">車牌號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="id" class="form-input" type="text" id="input-id"
                                                    placeholder="車牌號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-user-id">用戶編號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="user-id" class="form-input" type="text" id="input-user-id"
                                                    placeholder="用戶編號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-spot-id">停車位編號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="spot-id" class="form-input" type="text" id="input-spot-id"
                                                    placeholder="停車位編號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-vehicle-brand">車輛品牌</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="vehicle-brand" class="form-input" type="text" id="input-vehicle-brand"
                                                    placeholder="車輛品牌">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-vehicle-type">車輛型號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="vehicle-type" class="form-input" type="text" id="input-vehicle-type"
                                                    placeholder="車輛型號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-vehicle-color">車輛顏色</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="vehicle-color" class="form-input" type="text" id="input-vehicle-color"
                                                    placeholder="車輛顏色">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-vehicle-state">當前狀態</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="vehicle-state" class="form-input" type="text" id="input-vehicle-state"
                                                    placeholder="當前狀態">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-special-requirements">特殊需求</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="special-requirements" class="form-input" type="text" id="input-special-requirements"
                                                    placeholder="特殊需求">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-notes">備註</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="notes" class="form-input" type="text" id="input-notes"
                                                    placeholder="備註">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success centered" id="add_info">添加</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <script src="./static/js/operation_vehicle.js"></script>
    </body>
</html>