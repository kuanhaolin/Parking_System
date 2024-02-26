function open_edit_info_modal() {
    $('#modal_edit_info').attr('class', 'modal active');
    var index = $(this).attr('rowindex').toString();
    $('#edit-id').attr('value', $('td[class="id"][rowindex="' + index + '"]').text());
    $('#edit-license-plate').attr('value', $('td[class="license-plate"][rowindex="' + index + '"]').text());
    $('#edit-user-id').attr('value', $('td[class="user-id"][rowindex="' + index + '"]').text());
    $('#edit-spot-id').attr('value', $('td[class="spot-id"][rowindex="' + index + '"]').text());
    $('#edit-vehicle-brand').attr('value', $('td[class="vehicle-brand"][rowindex="' + index + '"]').text());
    $('#edit-vehicle-type').attr('value', $('td[class="vehicle-type"][rowindex="' + index + '"]').text());
    $('#edit-vehicle-color').attr('value', $('td[class="vehicle-color"][rowindex="' + index + '"]').text());
    $('#edit-vehicle-state').attr('value', $('td[class="vehicle-state"][rowindex="' + index + '"]').text());
    $('#edit-special-requirements').attr('value', $('td[class="special-requirements"][rowindex="' + index + '"]').text());
    $('#edit-notes').attr('value', $('td[class="notes"][rowindex="' + index + '"]').text());
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

function vehicle_out() {
    var index = $(this).attr('rowindex').toString();
    $.ajax({
        type: 'POST',
        url: './functions/out_vehicle.php',
        dataType: 'json',
        data: {
            'id': index
        },
        success: function (data) {
            if (data.successMsg) {
                window.location.reload();
                close_edit_info_modal();
                alert(data.successMsg);
            } else {
                window.location.reload();
                close_edit_info_modal();
                alert(data.errorMsg);
            }
        },
        error: function(jqXHR) {
            if(jqXHR.status === 404) {
                alert(thrownError);
            }
        }
    })
}

function delete_vehicle() {
    var index = $(this).attr('rowindex').toString();
    $.ajax({
        type: 'POST',
        url: './functions/deleted_vehicle.php',
        dataType: 'json',
        data: {
            'id': index,
            'updated_info': {
                'deleted': 1
            }
        },
        success: function (data) {
            if (data.successMsg) {
                window.location.reload();
                close_edit_info_modal();
                alert(data.successMsg);
            } else {
                window.location.reload();
                close_edit_info_modal();
                alert(data.errorMsg);
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
    var license_plate = $('#input-license-plate').val();
    var user_id = $('#input-user-id').val();
    var spot_id = $('#input-spot-id').val();
    var vehicle_brand = $('#input-vehicle-brand').val();
    var vehicle_type = $('#input-vehicle-type').val();
    var vehicle_color = $('#input-vehicle-color').val();
    var vehicle_state = $('#input-vehicle-state').val();
    var special_requirements = $('#input-special-requirements').val();
    var notes = $('#input-notes').val();

    if(license_plate.length == 0) {
        alert('車牌號碼不能為空');
        return;
    }

    if(user_id.length == 0) {
        user_id = 0;
    }

    if(spot_id.length == 0) {
        spot_id = 0;
    }

    if(vehicle_brand.length == 0) {
        vehicle_brand = '';
    }

    if(vehicle_type.length == 0) {
        vehicle_type = '';
    }

    if(vehicle_color.length == 0) {
        vehicle_color = '';
    }

    if(vehicle_state.length == 0) {
        vehicle_state = 3
    }

    if(special_requirements.length == 0) {
        special_requirements = '';
    }

    if(notes.length == 0) {
        notes = '';
    }

    $.ajax({
        type: 'POST',
        url: './functions/add_vehicle.php',
        dataType: 'json',
        data:{
            'license_plate': license_plate,
            'user_id': user_id,
            'spot_id': spot_id,
            'vehicle_brand': vehicle_brand,
            'vehicle_type': vehicle_type,
            'vehicle_color': vehicle_color,
            'vehicle_state': vehicle_state,
            'special_requirements': special_requirements,
            'notes': notes
        },
        success: function (data) {
            if (data.successMsg) {
                window.location.reload();
                close_edit_info_modal();
                alert(data.successMsg);
            } else {
                window.location.reload();
                close_edit_info_modal();
                alert(data.errorMsg);
            }
        },
        error: function(jqXHR) {
            alert("error測試中123");
            if(jqXHR.status === 404) {
                alert(thrownError);
            }
        }
    })
}

function update_info() {
    var id = $('#edit-id').val();
    var license_plate = $('#edit-license-plate').val();
    var user_id = $('#edit-user-id').val();
    var spot_id = $('#edit-spot-id').val();
    var vehicle_brand = $('#edit-vehicle-brand').val();
    var vehicle_type = $('#edit-vehicle-type').val();
    var vehicle_color = $('#edit-vehicle-color').val();
    var vehicle_state = $('#edit-vehicle-state').val();
    var special_requirements = $('#edit-special-requirements').val();
    var notes = $('#edit-notes').val();

    if(vehicle_brand.length == 0){
        vehicle_brand = '';
    }
    if(vehicle_type.length == 0){
        vehicle_type = '';
    }
    if(vehicle_color.length == 0){ 
        vehicle_color = '';
    }

    if(vehicle_state == '使用中'){
        vehicle_state = 1;
    }else if(vehicle_state == '維護中'){
        vehicle_state = 2;
    }else if(vehicle_state == '預訂中'){
        vehicle_state = 3;
    }else if(vehicle_state.length > 0 && vehicle_state < '0' || vehicle_state > '3') {
        alert('請輸入帳戶狀態(1 = 使用中、2 = 維護中、3 = 預訂中)');
        return;
    }else{
        vehicle_state = 1;
    }

    if(special_requirements.length == 0){
        special_requirements = '';
    }
    if(notes.length == 0){
        notes = '';
    }

    $.ajax({
        type: 'POST',
        url: './functions/update_vehicle.php',
        dataType: 'json',
        data: {
            'vehicle_id': id,
            'updated_info': {
                'license_plate': license_plate,
                'user_id': user_id,
                'spot_id': spot_id,
                'vehicle_brand': vehicle_brand,
                'vehicle_type': vehicle_type,
                'vehicle_color': vehicle_color,
                'vehicle_state': vehicle_state,
                'special_requirements': special_requirements,
                'notes': notes
            }
        },
        success: function (data) {
            if (data.successMsg) {
                window.location.reload();
                close_edit_info_modal();
                alert(data.successMsg);
            } else {
                alert(data.errorMsg);
            }
        },
        error: function(jqXHR) {
            alert("error測試中");
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
        $(this).click(delete_vehicle);
    });
    $('button[name="vehicle_out"]').each(function () {
        $(this).click(vehicle_out);
    });

    $('#close_edit_modal').click(close_edit_info_modal);
    $('#open_add_modal').click(open_add_info_modal);
    $('#close_add_modal').click(close_add_info_modal);
    $('#add_info').click(post_info_to_add);
    $('#update_info').click(update_info);
}

load();

