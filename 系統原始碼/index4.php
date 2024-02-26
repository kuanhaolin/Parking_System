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
                            <div class="navbar-brand mr-2"><h2>停車場管理系統 - 收費管理</h2></div>
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
                                            <th>車牌號</th>
                                            <th>建立時間</th>
                                            <th>最後修改時間</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $result = executeMongoDB('fee');
                                            while ($row = current($result)) {
                                                echo <<<HTML
                                                <tr>
                                                    <td class='license-plate' rowindex='{$row->license_plate}'>{$row->license_plate}</td>
                                                    <td class='create-time' rowindex='{$row->license_plate}'>{$row->create_time}</td>
                                                    <td class='update-time' rowindex='{$row->license_plate}'>{$row->update_time}</td>
                                                    <td>
                                                        <button class='btn btn-primary' name='allData' rowindex='{$row->license_plate}'>詳細資料</button>
                                                        <button class='btn btn-success' name='edit_this_info' rowindex='{$row->license_plate}'>編輯</button>
                                                        <button class='btn btn-error' name='delete_this_info' rowindex='{$row->license_plate}'>刪除</button>
                                                    </td>
                                                </tr>
                                            HTML;
                                                next($result);
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <script>
                                    var allDataButtons = document.querySelectorAll("button[name='allData']");

                                    allDataButtons.forEach(function(button) {
                                    button.addEventListener("click", function() {
                                        var rowindex = button.getAttribute("rowindex");
                                        var form = document.createElement("form");
                                        form.method = "post";
                                        form.action = "index5.php";
                                        var input = document.createElement("input");
                                        input.type = "hidden";
                                        input.name = "rowindex";
                                        input.value = rowindex;
                                        form.appendChild(input);
                                        document.body.appendChild(form);
                                        form.submit();
                                    });
                                    });
                                </script>
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
                                <!-- <form action="" method="post"> -->
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
                                <!-- </form> type="submit" name="submit" -->
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