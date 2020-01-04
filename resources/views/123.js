var Domain = "http://localhost/messageBoard/public/api/";
$(document).ready(function () {
    $(document).delegate('#sendMessage', 'click', sendMessage);
    $(document).delegate('#register', 'click', register);
    $(document).delegate('#login', 'click', login);
    $(document).delegate('.deleteMessage', 'click', deleteMessage);
    getMessage();
});

function register() {
    $.ajax({
        type: "POST",
        url: Domain + "register",
        data: $('#userData').find('.data').serialize(),
        statusCode: {
            200: function (res) {
                Cookies.set('token', res, {expires: 7, path: ''});
                alert('註冊成功');
            },
            400: function (res) {
                console.log(res.responseJSON[0])
                alert(res.responseJSON[0]);
            }
        }
    });
}

function login() {
    $.ajax({
        type: "POST",
        url: Domain + "login",
        data: $('#userData').find('.data').serialize(),
        statusCode: {
            200: function (res) {
                Cookies.set('token', res, {expires: 7, path: ''});
                alert('登入成功');
                getMessage();
            },
            400: function (res) {
                console.log(res.responseJSON[0])
                alert(res.responseJSON[0]);
            }
        }
    });
}


function sendMessage() {
    $.ajax({
        type: "POST",
        url: Domain + "sendMessage",
        data: $('#content').serialize(),
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", 'Bearer ' + Cookies.get('token'));
        },
        statusCode: {
            200: function (res) {
                console.log(res);
                $("#MessageList").append(
                    '<div class="sList">' +
                    '<span> ' + res.account + ' ' + res.content + ' </span>' +
                    '</div><br>'
                );
            },
            400: function (resStr) {

            }
        }
    });
}

function getMessage() {
    var url = Domain + "getMessage";
    $.ajax({
        type: "GET",
        url: url,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", 'Bearer ' + Cookies.get('token'));
        },
        statusCode: {
            200: function (res) {
                console.log(res);
                $("#MessageList").empty();
                var KeywordBody = '';
                for (i = 0; i < res.length; i++) {
                    KeywordBody +=
                        '<div class="sList">' +
                        '<span> ' + res[i].account + ' ' + res[i].content + ' </span>' +
                        '<span class="deleteMessage" data-mid="' + res[i].m_id + '"> 刪除 </span>' +
                        '<br/>'+
                        '</div>'
                }
                $("#MessageList").append(KeywordBody);
            },
            400: function (resStr) {
            }
        }
    });
}

function deleteMessage() {
    var m_id = $(this).data('mid');
    var now=$(this)
    console.log(m_id);
    var url = Domain + "deleteMessage";
    $.ajax({
        type: "post",
        url: url,
        data: {m_id: m_id},
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", 'Bearer ' + Cookies.get('token'));
        },
        statusCode: {
            200: function (res) {
                now.closest('.sList').remove();
            },
            400: function (resStr) {
            }
        }
    });
}

