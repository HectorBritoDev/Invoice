$(document).ready(function () {
    $('#select-department').change(getProvinces);
    $('#select-province').change(getDistricts);
    $('#select-department-edit').change(getProvincesEdit);
    $('#select-province-edit').change(getDistrictsEdit);
})

function getProvinces() {

    var department_id = $(this).val();


    //AJAX
    $.get('/api/provinces/' + department_id, function (data) {
        var html_selected = '<option value="">Provincia</option>';

        for (var i = 0; i < data.length; ++i) {
            html_selected += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#select-province').html(html_selected);
        }

    })
}

function getDistricts() {

    var province_id = $(this).val();

    //AJAX
    $.get('/api/districts/' + province_id, function (data) {
        var html_selected = '<option value="">Distrito</option>';

        for (var i = 0; i < data.length; ++i) {
            html_selected += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#select-district').html(html_selected);
        }

    })
}

function getProvincesEdit() {

    var department_id = $(this).val();


    //AJAX
    $.get('/api/provinces/' + department_id, function (data) {
        var html_selected = '<option value="">Provincia</option>';

        for (var i = 0; i < data.length; ++i) {
            html_selected += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#select-province-edit').html(html_selected);
        }

    })
}

function getDistrictsEdit() {

    var province_id = $(this).val();

    //AJAX
    $.get('/api/districts/' + province_id, function (data) {
        var html_selected = '<option value="">Distrito</option>';

        for (var i = 0; i < data.length; ++i) {
            html_selected += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#select-district-edit').html(html_selected);
        }

    })
}
