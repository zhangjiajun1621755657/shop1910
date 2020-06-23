<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
</head>
<body>
<h2>用户登录</h2>
<form action="{{url('/user/login/')}}" method="post">
     @csrf
      账号: <input type="text" placeholder="用户名" name="name"><br>
      密码: <input type="password" placeholder="密码" name="password"><br>
      <input type="submit" value="登录">
</form>
</body>
</html>