<form action="{{url('/user/login/')}}" method="post">
    @csrf
    用户名: <input type="text" name="user_name" placeholder="用户名/email"><br>
    密码：<input type="password" name="password" placeholder="请写入密码"><br>
    <input type="submit" value="登录">
</form>
