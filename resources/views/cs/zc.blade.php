<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
</head>
<body>
<form action="{{url('/cs/zc2')}}" method="post">
    用户名: <input type="text" name="user_name"><br>
    Email:  <input type="text" name="user_email"><br>
    手机号: <input type="text" name="tel"><br>
    公司名称: <input type="text" name="gs_name"><br>
    公司地址: <input type="text" name="gs_dizhi"><br>
    密码: <input type="password" name="user_pwd"><br>
    确认密码: <input type="password" name="user_pwd2"><br>
    <input type="submit" value="注册">
</form>
</body>
</html>