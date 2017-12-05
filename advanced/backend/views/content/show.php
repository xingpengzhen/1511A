<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
    <table>
        <tr>
            <td>留言人</td>
            <td>留言内容</td>
        </tr>
        <?php foreach($arr as $val){ ?>
        <tr>
            <td><?php echo $val['username'] ?></td>
            <td><?php echo $val['content'] ?></td>
        </tr>
        <?php } ?>
    </table>
</center>
</body>
</html>