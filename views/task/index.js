$(function () {
    $(document).on('click', '#addTask', function (e) {
        e.preventDefault()
        let author = $('#author').val()
        let email = $('#email').val()
        let task = $('#task').val()
        $.ajax({
            url: "/add",
            type: 'POST',
            data: {
                'author': author,
                'email': email,
                'task': task
            },
            success: function (data) {
                data = JSON.parse(data)
                if (data.status == 0) {
                    alert(data.message)
                } else if (data.status == 1) {
                    alert(data.message)
                    location.reload()
                }
            }
        })
    })

    $(document).on('click', '.edit', function (e) {
        e.preventDefault()
        let id = e.target.id
        let status
        let task = $('#task' + id).val()
        if ($('#status' + id).prop('checked')) {
            status = 1;
        } else {
            status = 0;
        }
        $.ajax({
            url: "/edit",
            type: 'POST',
            data: {
                'id': id,
                'task': task,
                'status': status
            },
            success: function (data) {
                data = JSON.parse(data)
                if (data.status == 0) {
                    alert(data.message)
                } else if (data.status == 1) {
                    alert(data.message)
                    location.reload()
                } else if (data.status == 2) {
                    alert(data.message)
                    location.reload()
                }
            }
        })
    })


    $(document).on('click', '#enter', function (e) {
        e.preventDefault()
        let login = $('#login').val()
        let password = $('#password').val()
        $.ajax({
            url: "/admin",
            type: 'POST',
            data: {
                'login': login,
                'password': password
            },
            success: function (data) {
                data = JSON.parse(data)
                if (data.status == 0) {
                    alert(data.message)
                } else if (data.status == 1) {
                    location.reload()
                }
            }
        })
    })

    $(document).on('click', '#sorting', function (e) {
        e.preventDefault()
        let type = $('#sort_param option:selected').val()
        let sort = $('#sort_param option:selected').attr('sort')
        $.ajax({
            url: "/page-" + $('#page').val(),
            type: 'POST',
            data: {
                'type': type,
                'sort': sort
            },
            success: function () {
                location.reload()
            }
        })
    })

    $('option').each(function (index) {
        if($(this).attr('value') == $('#sort').val() && $(this).attr('sort') == $('#sort').attr('sort') ){
            $(this).prop('selected', true)
        }
    })

})