var Domain = "http://localhost/messageBoard/public/api/";
    $(document).ready(function () {
    $(document).delegate('#sendMessage', 'click', sendMessage);
    $(document).delegate('#register', 'click', register);
    $(document).delegate('#login', 'click', login);
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
                        '</div><br>'
                }
                $("#MessageList").append(KeywordBody);
            },
            400: function (resStr) {
            }
        }
    });
}
