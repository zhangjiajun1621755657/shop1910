<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户注册</title>
</head>
<body>
<form action="{{url('/user/regDo/')}}" method="post">
    @csrf
       用户名: <input type="text" name="user_name"><br>
       Email: <input type="text" name="email"><br>
       密码: <input type="password" name="password"><br>
       确认密码: <input type="password" name="password2"><br>
    <input type="submit" value="注册">
</form>
</body>
</html>