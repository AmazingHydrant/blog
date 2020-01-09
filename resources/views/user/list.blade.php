<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="http://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="/js/layer/layer.js"></script>
</head>

<body>
    <table>
        <tr>
            <td>ID</td>
            <td>用戶名</td>
            <td>密碼</td>
            <td>操作</td>
        </tr>
        @foreach($user as $v)
        <tr>
            <td>{{ $v->user_id }}</td>
            <td>{{ $v->user_name }}</td>
            <td>{{ $v->user_pass }}</td>
            <td><a href="/user/edit/{{$v->user_id}}">修改</a> <a href="javascript:;" onclick="del_user(this, {{$v}} )">刪除</a></td>
        </tr>
        @endforeach
    </table>
    <div><a href="/user/add">到添加用戶頁面</a></div>
    <style>
        table,
        tr,
        td {
            border: 1px solid black;
        }
    </style>
    <script>
        function del_user(obj, user) {
            //询问框
            layer.confirm('是否刪除' + user.user_name + '？', {
                btn: ['確認', '取消'] //按钮
            }, function() {
                $.get('/user/del/' + user.user_id, function(data) {
                    if (data.status == 1) {
                        layer.msg(data.message, {
                            icon: 1
                        });
                        $(obj).parents('tr').remove();
                    } else {
                        layer.msg(data.message, {
                            icon: 0
                        });
                    }

                })
            }, function() {
                // layer.msg('也可以这样', {
                //     time: 20000, //20s后自动关闭
                //     btn: ['明白了', '知道了']
                // });
            });
        }
    </script>
</body>

</html>