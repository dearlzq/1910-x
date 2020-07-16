<form action="{{url('/user/reg/')}}" method="post">
    @csrf
    用户名: <input type="text" name="user_name" placeholder="请输入用户名"><br>
    Email：<input type="text" name="user_email" placeholder="请写入正确的邮箱"><br>
    公司名称：<input type="text" name="user_workname" placeholder="请写入正确的邮箱"><br>
    公司地址：<input type="text" name="user_work" placeholder="请写入正确的邮箱"><br>
    密码：<input type="password" name="password" placeholder="请写入密码"><br>
    确认密码：<input type="password" name="repassword" placeholder="重复密码"><br>
    <a href="{{url('user/login')}}">已注册，点我登录</a>
    <input type="submit" value="注册">
</form>
