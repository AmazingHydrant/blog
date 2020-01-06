<!doctype html>
<html class="x-admin-sm">

<head>
  <meta charset="UTF-8">
  <title>後臺管理登錄</title>
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />

  @include('admin.public.styles')
  @include('admin.public.script')

</head>

<body class="login-bg">

  <div class="login layui-anim layui-anim-up">
    <div class="message">後臺管理登錄</div>
    <div id="darkbannerwrap"></div>
    @if(!is_object($errors))
    {{$errors}}
    @else
    @foreach ($errors->all() as $message)
    <li>{{$message}}</li>
    @endforeach
    @endif
    <form method="post" action="/admin/dologin" class="layui-form">
      <input name="username" placeholder="用戶名" type="text" lay-verify="" class="layui-input">
      <hr class="hr15">
      <input name="password" lay-verify="" placeholder="密碼" type="password" class="layui-input">
      <hr class="hr15">
      <input name="captcha" style="width:150px;float: left" lay-verify="" placeholder="驗證碼" type="test" class="layui-input">
      <span>點擊圖片刷新>></span>
      <img src="{{captcha_src('flat')}}" alt="" style="float: right" onclick="captcha(this)">
      <hr class="hr15">
      {{ csrf_field() }}
      <input value="登錄" lay-submit lay-filter="login" style="width:100%;" type="submit">
      <hr class="hr20">
    </form>
  </div>

  <script>
    function captcha(obj) {
      console.log(obj);
      obj.src = "{{captcha_src('flat')}}" + Math.random();
    }
    // $(function() {
    //   layui.use('form', function() {
    //     var form = layui.form;
    //     // layer.msg('玩命卖萌中', function(){
    //     //   //关闭后的操作
    //     //   });
    //     //监听提交
    //     form.on('submit(login)', function(data) {
    //       // alert(888)

    //       // layer.msg(JSON.stringify(data.field), function() {
    //       //   location.href = 'index.html'
    //       // });
    //       return false;
    //     });
    //   });
    // })
  </script>
  <!-- 底部结束 -->
</body>

</html>