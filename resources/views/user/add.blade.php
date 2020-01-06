<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="/user/store" method="post">
        <table>
            <tr>
                <td>用戶名</td>
                <td><input type="text" name="user_name"></td>
            </tr>
            <tr>
                <td>密碼</td>
                <td><input type="password" name="user_pass"></td>
            </tr>
            <tr>
                <td></td>
                {{ csrf_field() }}
                <td><input type="submit" value="提交"></td>
            </tr>
        </table>
    </form>
</body>

</html>