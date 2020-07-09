<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
</head>
<body>
<form action="{{url('/cs/centent')}}" method="post">
    用户名: <input type="text" placeholder="账号" name="user_name"><br>
    密码:  <input type="password" placeholder="密码/email" name="user_pwd"><br>

    <input type="submit" value="登录">
</form>
</body>
</html>