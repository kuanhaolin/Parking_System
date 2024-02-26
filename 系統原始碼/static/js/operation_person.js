function open_edit_info_modal() {
    $('#modal_edit_info').attr('class', 'modal active');
    var index = $(this).attr('rowindex').toString();
    $('#edit-id').attr('value', $('td[class="id"][rowindex="' + index + '"]').text());
    $('#edit-vehicle-id').attr('value', $('td[class="vehicle-id"][rowindex="' + index + '"]').text());
    $('#edit-name').attr('value', $('td[class="name"][rowindex="' + index + '"]').text());
    $('#edit-age').attr('value', $('td[class="age"][rowindex="' + index + '"]').text());
    $('#edit-birthday').attr('value', $('td[class="birthday"][rowindex="' + index + '"]').text());
    $('#edit-email').attr('value', $('td[class="email"][rowindex="' + index + '"]').text());
    $('#edit-phone-number').attr('value', $('td[class="phone-number"][rowindex="' + index + '"]').text());
    $('#edit-origin-home').attr('value', $('td[class="origin-home"][rowindex="' + index + '"]').text());
    $('#edit-current-home').attr('value', $('td[class="current-home"][rowindex="' + index + '"]').text());
    $('#edit-user-type').attr('value', $('td[class="user-type"][rowindex="' + index + '"]').text());
    $('#edit-user-state').attr('value', $('td[class="user-state"][rowindex="' + index + '"]').text());
    $('#edit-create-time').attr('value', $('td[class="create-time"][rowindex="' + index + '"]').text());
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
    $.ajax({
        type: 'POST',
        url: './functions/deleted_person.php',
        dataType: 'json',
        data: {
            'id': index,
            'updated_info': {
                'deleted': true
            }
        },
        success: function (data) {
            if (data.successMsg) {
                window.location.reload();
                close_edit_info_modal();
                alert(data.successMsg);
            } else {
                alert(data.errorMsg);
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
    var vehicle_id = $('#input-vehicle-id').val();
    var name = $('#input-name').val();
    var age = $('#input-age').val();
    var birthday = $('#input-birthday').val();
    var email = $('#input-email').val();
    var phone_number = $('#input-phone-number').val();
    var origin_home = $('#input-origin-home').val();
    var current_home = $('#input-current-home').val();
    var user_type = $('#input-user-type').val();
    var user_state = $('#input-user-state').val();

    if(vehicle_id.length == 0){
        alert('請輸入車牌號');
        return;
    }

    if(name.length == 0){
        name = '';
    }

    if (birthday.length > 0 && !birthday.match('\\d{4}-\\d{2}-\\d{2}')) {
        alert('生日的格式為：yyyy-mm-dd');
        return;
    }else if(birthday.length == 0){
        birthday = '';
    }

    if (age.length == 0){
        age = 0;
    }
    
    if(email.length > 0){
        var emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
        if(email.search(emailRule) == -1){
            alert('電子信箱格式錯誤');
            return;
        }
    }else{
        email = '';
    }
    
    if(phone_number.length == 0){
        phone_number = '';
    }

    if(origin_home.length == 0){
        origin_home = '';
    }

    if(current_home.length == 0){
        current_home = '';
    }

    if(user_type == '管理員'){
        user_type = 1;
    }else if(user_type == '員工'){
        user_type = 2;
    }else if(user_type == '普通用戶'){
        user_type = 3;
    }else if(user_type.length > 0 && user_type < '0' || user_type > '3') {
        alert('請輸入用戶類型(1 = 管理員、2 = 員工、3 = 普通用戶)');
        return;
    }else{
        user_type = 3;
    }
    
    if(user_state == '可用'){
        user_state = 1;
    }else if(user_state == '異常'){
        user_state = 2;
    }else if(user_state == '已凍結'){
        user_state = 3;
    }else if(user_state == '已登出'){
        user_state = 4;
    }else if(user_state.length > 0 && user_state < '0' || user_state > '3') {
        alert('請輸入帳戶狀態(1 = 可用、2 = 異常、3 = 已凍結、4 = 已登出)');
        return;
    }else{
        user_state = 1;
    }

    $.ajax({
        type: 'POST',
        url: './functions/add_person.php',
        dataType: 'json',
        data:{
            'vehicle_id': vehicle_id,
            'name': name,
            'age': age,
            'birthday': birthday,
            'email': email,
            'phone_number': phone_number,
            'origin_home': origin_home,
            'current_home': current_home,
            'user_type': user_type,
            'user_state': user_state
        },
        success: function (data) {
            if (data.successMsg) {
                alert(data.successMsg);
                window.location.reload();
                close_edit_info_modal();
            } else {
                alert(data.errorMsg);
                if ('reason' in data) {
                    alert(data['reason']);
                } else {
                    alert('更新失敗');
                }
            }
        },
        error: function(jqXHR) {
            alert(jqXHR.status);
            if(jqXHR.status === 404) {
            }
        }
    })
}

function update_info() {
    var id = $('#edit-id').val();
    var vehicle_id = $('#edit-vehicle-id').val();
    var name = $('#edit-name').val();
    var age = $('#edit-age').val();
    var birthday = $('#edit-birthday').val();
    var email = $('#edit-email').val();
    var phone_number = $('#edit-phone-number').val();
    var origin_home = $('#edit-origin-home').val();
    var current_home = $('#edit-current-home').val();
    var user_type = $('#edit-user-type').val();
    var user_state = $('#edit-user-state').val();

    if(vehicle_id.length == 0){
        alert('請輸入車輛ID');
        return;
    }

    if(name.length == 0){
        name = '';
    }

    if (birthday.length > 0 && !birthday.match('\\d{4}-\\d{2}-\\d{2}')) {
        alert('生日的格式為：yyyy-mm-dd');
        return;
    }else{
        birthday = '';
    }

    age = parseInt(age);
    if (isNaN(age) || age < 0 || age > 120) {
        alert('年齡需為一個在0-120之間的數字');
        return;
    }else{
        age = 0;
    }
    
    if(email.length > 0){
        var emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
        if(email.search(emailRule) == -1){
            alert('電子信箱格式錯誤');
            return;
        }
    }else{
        email = '';
    }
    
    if(phone_number.length == 0){
        phone_number = '';
    }

    if(origin_home.length == 0){
        origin_home = '';
    }

    if(current_home.length == 0){
        current_home = '';
    }

    if(user_type == '管理員'){
        user_type = 1;
    }else if(user_type == '員工'){
        user_type = 2;
    }else if(user_type == '普通用戶'){
        user_type = 3;
    }else if(user_type < '0' || user_type > '3') {
        alert('請輸入用戶類型(1 = 管理員、2 = 員工、3 = 普通用戶)');
        return;
    }
    
    if(user_state == '可用'){
        user_state = 1;
    }else if(user_state == '異常'){
        user_state = 2;
    }else if(user_state == '已凍結'){
        user_state = 3;
    }else if(user_state == '已登出'){
        user_state = 4;
    }else if(user_state < '0' || user_state > '3') {
        alert('請輸入帳戶狀態(1 = 可用、2 = 異常、3 = 已凍結、4 = 已登出)');
        return;
    }

    $.ajax({
        type: 'POST',
        url: './functions/update_person.php',
        dataType: 'json',
        data: {
            'id': id,
            'updated_info': {
                'vehicle_id': vehicle_id,
                'name': name,
                'age': age,
                'birthday': birthday,
                'email': email,
                'phone_number': phone_number,
                'origin_home': origin_home,
                'current_home': current_home,
                'user_type': user_type,
                'user_state': user_state
            }
        },
        success: function(data) {
            if (data.successMsg) {
                window.location.reload();
                close_edit_info_modal();
                //alert(data.successMsg);
            }else{
                window.location.reload();
                close_edit_info_modal();
                // alert(data.errorMsg);
            }
        },
        error: function(jqXHR) {
            console.log('123');
            if(jqXHR.status === 404) {
                // alert(thrownError);
                alert('更新失敗');
            }
        }
    })
}

function calc_age() {
    birthYear = parseInt(birthdayStr.split('-')[0]);
    if (birthYear === 2023) {
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

