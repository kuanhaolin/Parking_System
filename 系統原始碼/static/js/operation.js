function open_edit_info_modal() {
    $('#modal_edit_info').attr('class', 'modal active');
    var index = $(this).attr('rowindex').toString();
    $('#edit-id').attr('value', $('td[class="id"][rowindex="' + index + '"]').text());
    $('#edit-name').attr('value', $('td[class="name"][rowindex="' + index + '"]').text());
    $('#edit-age').attr('value', $('td[class="age"][rowindex="' + index + '"]').text());
    $('#edit-birthday').attr('value', $('td[class="birthday"][rowindex="' + index + '"]').text());
    $('#edit-email').attr('value', $('td[class="email"][rowindex="' + index + '"]').text());
    $('#edit-phone-number').attr('value', $('td[class="phone-number"][rowindex="' + index + '"]').text());
    $('#edit-origin-home').attr('value', $('td[class="origin-home"][rowindex="' + index + '"]').text());
    $('#edit-current-home').attr('value', $('td[class="current-home"][rowindex="' + index + '"]').text());
    $('#edit-user-type').attr('value', $('td[class="user-type"][rowindex="' + index + '"]').text());
    $('#edit-user-state').attr('value', $('td[class="user-state"][rowindex="' + index + '"]').text());
    $('#edit-register-time').attr('value', $('td[class="register-time"][rowindex="' + index + '"]').text());
    $('#edit-update-time').attr('value', $('td[class="update-time"][rowindex="' + index + '"]').text());
}

function close_edit_info_modal() {
    $('#modal_edit_info').attr('class', 'modal');
}

function open_add_info_modal() {
    $('#modal_add_info').attr('class', 'modal active');
}

function close_add_info_modal() {
    $('#modal_add_info').attr('class', 'modal');
}

function delete_people() {
    var index = $(this).attr('rowindex').toString();
    var time = new Date();
    var current_time = time.toLocaleString();
    $.ajax({
        type: 'POST',
        url: './deleted_person.php',
        dataType: 'json',
        data: {
            'people_id': index,
            'updated_info': {
                'update_time': current_time,
                'deleted': 1
            }
        },

        success: function (data) {
            if (data.deleted) {
                window.location.reload();
                close_edit_info_modal();
                //alert('更新OK');
                $("#result").html(data.errorMsg);
            } else {
                alert('更新失敗');
                $("#result").html(data.errorMsg);
                if ('reason' in data) {
                    alert(data['reason']);
                } else {
                    alert('更新失敗');
                }
            }
        },
        error: function(jqXHR) {
            if(jqXHR.status === 404) {
                alert(thrownError);
            }
        }
    })
}

function post_info_to_add() {
    var name = $('#input-name').val();
    var age = $('#input-age').val();
    var birthday = $('#input-birthday').val();
    var email = $('#input-email').val();
    var phone_number = $('#input-phone-number').val();
    var origin_home = $('#input-origin-home').val();
    var current_home = $('#input-current-home').val();
    var user_type = $('#input-user-type').val();
    var user_state = $('#input-user-state').val();

    if (name.length <= 0) {
        alert('請輸入姓名123');
        return;
    }
    if (!birthday.match('\\d{4}-\\d{2}-\\d{2}')) {
        alert('生日的格式為：yyyy-mm-dd');
        return;
    }
    age = parseInt(age);
    if (isNaN(age) || age < 0 || age > 120) {
        alert('年齡需為一個在0-120之間的數字');
        return;
    }

    var time = new Date();
    var current_time = time.toLocaleString();

    $.ajax({
        type: 'POST',
        url: './add_person.php',
        dataType: 'json',
        data:{
            'name': name,
            'age': age,
            'birthday': birthday,
            'email': email,
            'phone_number': phone_number,
            'origin_home': origin_home,
            'current_home': current_home,
            'user_type': user_type,
            'user_state': user_state,
            'register_time': current_time,
            'update_time': current_time
        },
        success: function (data) {
            if (data.name) {
                window.location.reload();
                close_edit_info_modal();
                //alert('新增OK');
                // $("#result").html(data.name);
            } else {
                alert('更新失敗');
                $("#result").html(data.errorMsg);
                if ('reason' in data) {
                    alert(data['reason']);
                } else {
                    alert('更新失敗');
                }
            }
        },
        error: function(jqXHR) {
            if(jqXHR.status === 404) {
                alert(thrownError);
            }
        }
    })
}

function update_info() {
    var id = $('#edit-id').val();
    var name = $('#edit-name').val();
    var age = $('#edit-age').val();
    var birthday = $('#edit-birthday').val();
    var email = $('#edit-email').val();
    var phone_number = $('#edit-phone-number').val();
    var origin_home = $('#edit-origin-home').val();
    var current_home = $('#edit-current-home').val();
    var user_type = $('#edit-user-type').val();
    var user_state = $('#edit-user-state').val();

    if (name.length <= 0) {
        alert('請輸入姓名');
        return;
    }
    
    if (!birthday.match('\\d{4}-\\d{2}-\\d{2}')) {
        alert('生日的格式為：yyyy-mm-dd');
        return;
    }
    
    age = parseInt(age);
    if (isNaN(age) || age < 0 || age > 120) {
        alert('年齡需為一個在0-120之間的數字');
        return;
    }
    
    if(email.length <= 0){
        alert('請輸入電子信箱');
        return;
    }else{
        var emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
        if(email.search(emailRule) == -1){
            alert('電子信箱格式錯誤');
            return;
        }
    }
    
    if (phone_number.length <= 0) {
        alert('請輸入手機號碼');
        return;
    }
    
    user_type = parseInt(user_type);
    if (user_type.length <= 0) {
        alert('請輸入用戶類型');
        return;
    }
    
    user_state = parseInt(user_state);
    if (user_state.length <= 0) {
        alert('請輸入帳戶狀態');
        return;
    }

    var time = new Date();
    var current_time = time.toLocaleString();

    $.ajax({
        type: 'POST',
        url: './update_person.php',
        dataType: 'json',
        data: {
            'people_id': id,
            'updated_info': {
                'name': name,
                'age': age,
                'birthday': birthday,
                'email': email,
                'phone_number': phone_number,
                'origin_home': origin_home,
                'current_home': current_home,
                'user_type': user_type,
                'user_state': user_state,
                'update_time': current_time
            }
        },

        success: function (data) {
            if (data.name) {
                window.location.reload();
                close_edit_info_modal();
                // alert('更新OK');
                // $("#result").html(data.name);
            } else {
                alert('更新失敗');
                $("#result").html(data.errorMsg);
                if ('reason' in data) {
                    alert(data['reason']);
                } else {
                    alert('更新失敗');
                }
            }
        },
        error: function(jqXHR) {
            if(jqXHR.status === 404) {
                alert(thrownError);
            }
        }
    })
}

function calc_age() {
    birthYear = parseInt(birthdayStr.split('-')[0]);
    if (birthYear === 2018) {
        return 1;
    }
    thisYear = (new Date()).getFullYear();
    return thisYear - birthYear;
}

function load() {
    $('button[name="edit_this_info"]').each(function () {
        $(this).click(open_edit_info_modal);
    });
    $('button[name="delete_this_info"]').each(function () {
        $(this).click(delete_people);
    });

    $('#close_edit_modal').click(close_edit_info_modal);
    $('#open_add_modal').click(open_add_info_modal);
    $('#close_add_modal').click(close_add_info_modal);
    $('#add_info').click(post_info_to_add);
    $('#update_info').click(update_info);
    $('#input-birthday').change(function () {
        birthdayStr = $(this).val();
        if (birthdayStr.match('\\d{4}-\\d{2}-\\d{2}')) {
            $('#input-age').val(calc_age());
        }
    });
    $('#edit-birthday').change(function () {
        birthdayStr = $(this).val();
        if (birthdayStr.match('\\d{4}-\\d{2}-\\d{2}')) {
            $('#edit-age').val(calc_age());
        }
    })
}

load();

