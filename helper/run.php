<?php
$code = isset($_POST['code']) ? $_POST['code'] : "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP在线执行工具</title>
    <style>
        body, table,textarea,input{font-size: 20px;}
    </style>
</head>
<body>
<form action="" method="post">
    <table>
        <tr>
            <td colspan="2" style="text-align: center;">代码执行工具</td>
        </tr>
        <tr>
            <td rowspan="2" style="width:80px;">code：</td>
        </tr>
        <tr>
            <td><textarea name="code" cols="50" rows="16"><?php echo $code;?></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="执行"/></td>
        </tr>
        <?php if (!empty($code)) { ?>
            <tr>
                <td>output:</td>
                <td style="border: 1px solid #33C1FF;">
                    <?php echo "<pre>";eval($code);echo "</pre>"; ?>
                </td>
            </tr>
        <?php }?>
    </table>
</form>
</body>
</html>