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
                            <div class="navbar-brand mr-2"><h2>停車場管理系統 - 員工管理</h2></div>
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
                                            <th>編號</th>
                                            <th>車牌號</th>
                                            <th>姓名</th>
                                            <th>年齡</th>
                                            <th>出生日期</th>
                                            <th>電子郵件</th>
                                            <th>手機號碼</th>
                                            <th>戶籍地址</th>
                                            <th>目前住處</th>
                                            <th>用戶類型</th>
                                            <th>帳戶狀態</th>
                                            <th>註冊時間</th>
                                            <th>最後修改時間</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "select * from user where deleted=0";
                                            $result = execute($link, $query);
                                            while($data = mysqli_fetch_assoc($result)){
                                                $ref1 = $data['user_type'];
                                                switch ($ref1) {
                                                    case '1':
                                                        $ref1 = '管理員';
                                                        break;
                                                    case '2':
                                                        $ref1 = '員工';
                                                        break;
                                                    case '3':
                                                        $ref1 = '普通用戶';
                                                        break;
                                                    default:
                                                        $ref1 = 'ERROR';
                                                        break;
                                                }
                                                $ref2 = $data['user_state'];
                                                switch ($ref2) {
                                                    case '1':
                                                        $ref2 = '可用';
                                                        break;
                                                    case '2':
                                                        $ref2 = '異常';
                                                        break;
                                                    case '3':
                                                        $ref2 = '已凍結';
                                                        break;
                                                    case '4':
                                                        $ref2 = '已登出';
                                                        break;
                                                    default:
                                                        $ref2 = 'ERROR';
                                                        break;
                                                }
                                                echo <<<HTML
                                                    <tr>
                                                        <td class='id' rowindex='{$data["id"]}'>{$data['id']}</td>
                                                        <td class='vehicle-id' rowindex='{$data["id"]}'>{$data['vehicle_id']}</td>
                                                        <td class='name' rowindex='{$data["id"]}'>{$data['name']}</td>
                                                        <td class='age' rowindex='{$data["id"]}'>{$data['age']}</td>
                                                        <td class='birthday' rowindex='{$data["id"]}'>{$data['birthday']}</td>
                                                        <td class='email' rowindex='{$data["id"]}'>{$data['email']}</td>
                                                        <td class='phone-number' rowindex='{$data["id"]}'>{$data['phone_number']}</td>
                                                        <td class='origin-home' rowindex='{$data["id"]}'>{$data['origin_home']}</td>
                                                        <td class='current-home' rowindex='{$data["id"]}'>{$data['current_home']}</td>
                                                        <td class='user-type' rowindex='{$data["id"]}'>{$ref1}</td>
                                                        <td class='user-state' rowindex='{$data["id"]}'>{$ref2}</td>
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
                                <button class="btn btn-success centered" id="open_add_modal">添加人員</button>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="modal_edit_info">
                        <a href="#close" class="modal-overlay" aria-label="Close"></a>
                        <div class="modal-container">
                            <div class="modal-header">
                                <div id="close_edit_modal" class="btn btn-clear float-right" aria-label="Close"></div>
                                <div class="modal-title h5">編輯資訊</div>
                            </div>
                            <div class="form-horizontal">
                                <div class="modal-body">
                                    <div class="content">
                                        <fieldset disabled>
                                            <div class="form-group">
                                                <div class="col-3 col-sm-12">
                                                    <label class="form-label" for="edit-id">編號</label>
                                                </div>
                                                <div class="col-9 col-sm-12">
                                                    <input class="form-input" type="text" id="edit-id">
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-vehicle-id">車牌號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-vehicle-id" placeholder="車牌號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-name">姓名</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-name" placeholder="姓名">
                                            </div>
                                        </div>
                                        <fieldset disabled>
                                            <div class="form-group">
                                                <div class="col-3 col-sm-12">
                                                    <label class="form-label" for="edit-age">年齡</label>
                                                </div>
                                                <div class="col-9 col-sm-12">
                                                    <input class="form-input" type="text" id="edit-age" placeholder="年齡：根據生日自動計算">
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-birthday">出生日期</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-birthday" placeholder="出生日期">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-email">電子郵件</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-email" placeholder="電子郵件">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-phone-number">手機號碼</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-phone-number" placeholder="手機號碼">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-origin-home">戶籍地址</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-origin-home" placeholder="戶籍地址">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-current-home">目前住處</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-current-home"
                                                    placeholder="目前住處">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-user-type">用戶類型</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-user-type" placeholder="用戶類型：1 = 管理員、2 = 員工、3 = 普通用戶">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="edit-user-state">帳戶狀態</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input class="form-input" type="text" id="edit-user-state" placeholder="帳戶狀態：1 = 可用、2 = 異常、3 = 已凍結、4 = 已登出">
                                            </div>
                                        </div>
                                        <fieldset disabled>
                                            <div class="form-group">
                                                <div class="col-3 col-sm-12">
                                                    <label class="form-label" for="edit-create-time">註冊時間</label>
                                                </div>
                                                <div class="col-9 col-sm-12">
                                                    <input class="form-input" type="text" id="edit-create-time">
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
                                                <label class="form-label" for="input-vehicle-id">車牌號</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="vehicle-id" class="form-input" type="text" id="input-vehicle-id"
                                                    placeholder="車牌號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-name">姓名</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="name" class="form-input" type="text" id="input-name"
                                                    placeholder="姓名">
                                            </div>
                                        </div>
                                        <fieldset disabled>
                                            <div class="form-group">
                                                <div class="col-3 col-sm-12">
                                                    <label class="form-label" for="input-age">年齡</label>
                                                </div>
                                                <div class="col-9 col-sm-12">
                                                    <input name="age" class="form-input" type="text" id="input-age" placeholder="年齡：根據生日自動計算">
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-birthday">出生日期</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="birthday" class="form-input" type="text" id="input-birthday"
                                                    placeholder="出生日期">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-email">電子郵件</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="email" class="form-input" type="text" id="input-email"
                                                    placeholder="電子郵件">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-phone-number">手機號碼</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="phone-number" class="form-input" type="text" id="input-phone-number"
                                                    placeholder="手機號碼">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-origin-home">戶籍地址</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="origin_home" class="form-input" type="text" id="input-origin-home"
                                                    placeholder="戶籍地址">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-current-home">目前住處</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="current_home" class="form-input" type="text"
                                                    id="input-current-home"
                                                    placeholder="目前住處">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-user-type">用戶類型</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="user-type" class="form-input" type="text" id="input-user-type"
                                                    placeholder="用戶類型">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-3 col-sm-12">
                                                <label class="form-label" for="input-user-state">帳戶狀態</label>
                                            </div>
                                            <div class="col-9 col-sm-12">
                                                <input name="user-state" class="form-input" type="text" id="input-user-state"
                                                    placeholder="帳戶狀態">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success centered" id="add_info">添加</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="./static/js/operation_person.js"></script>
    </body>
</html>