<html lang="zh-Hant-TW">

<head>
    <title>Happy Lucky Smile Yeah</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel=stylesheet type="text/css" href="../resources/views/123.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <script src="../resources/views/123.js"></script>
    <script src="../resources/views/js.cookie.min.js"></script>
</head>

<body>
<header>
    <a href="./index.blade.php"> Happy Lucky Smile Yeah </a>
</header>

<div class="PostBody">

    <div id="userData">
        <input type="text" class="form-control data" id="account" name="account">
        <input type="text" class="form-control data" id="password" name="password">
        <input type="button" id="register" value="register">
        <input type="button" id="login" value="login">
    </div>


    <div>
        <input type="text" class="form-control data" id="content" name="content">
        <input type="button" id="sendMessage" value="sendMessage">
    </div>

    <div class='list'>
        <div id="MessageList"></div>
    </div>

</div>
</body>

</html>