
<?php
include_once('db/connect.php');
include('function.php');
include('views/header.php');
include('views/sidebar-a.php');
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array();
    $fn = $ln = $em = $pw = FALSE;

    if (preg_match('/^[\w\'.-]{2,20}$/i', trim('fname'))) {
        $fn = mysqli_real_escape_string($con, trim($_POST['fname']));
    } else {
        $error[] = 'fname';
    }

    if (preg_match('/^[\w\'.-]{2,20}$/i', trim('lname'))) {
        $ln = mysqli_real_escape_string($con, trim($_POST['lname']));
    } else {
        $error[] = 'lname';
    }

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $fn = mysqli_real_escape_string($con, trim($_POST['email']));
    } else {
        $error[] = 'email';
    }

    if (preg_match('/^[\w\'.-]{4,32}$/', trim($_POST['pass']))) {
        if ($_POST['pass'] === $_POST['cpass']) {
            $pw = md5(mysqli_real_escape_string($con, trim($_POST['pass'])));
        } else {
            $error[] = "Password not match";
        }
    } else {
        $error[] = 'pass';
    }

    if ($fn && $ln && $em && $pw) {
        $que = "SELECT user_id FROM users WhERE email = '{$em}'";
        $res = resultQuery($que);
        if (mysqli_num_rows($res) == 0) {
            // neu khong co email bi trung lap trong csdl thi tao ra 1 key luu lai
            $k = md5(uniqid(rand(), true));
            
            // chen dl
            $que = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `pass`, `active`) "; 
            $que .= " VALUES ('{$fn}', '{$ln}', '{$em}', '{$pw}', '{$k}'); ";
            $res = resultQuery($que);

            if (mysqli_affected_rows($con) == 1){
                //neu thanh cong thi gui email ma kich hoat
                $body = "Kính gửi {$fn} {$ln},\n Cảm ơn bạn đã đăng kí ở trang izcms. Một email đã được gửi tới
                        địa chỉ email bạn cung cấp. Hãy click bào đường link sau để kích hoạt tài khoản \n \n";
                $body .= base . "admin/activate.php?x=".urlencode($e)."&y={$k}";
                if (mail($_POST['email'], 'Kính hoạt tài khoản tại izcms', $body, 'FROM: localhost')) {
                $messages = "<p class='success'>Còn 1 bước nhỏ trước khi đăng kí tài khoản thành công,
                             bạn hãy nhấp vào đường link được gửi đến email của bạn để xác thực tài khoản</p>";
                } else {
                    $messages = "<p class='warning'>We were unable to email you, 
                                please check your email one last time before signing up for an account</p>";
                }
            }
        } else{
            $messages = "<p class='warning'>Email was already. Please use another email address</p>";    
        }
    } else {
        $messages = "<p class='warning'>Please fill all required fields</p>";
    }
}
?>
<div id="content">
    <form id="" method="POST">
        <?php echo (isset($messages)) ? $messages : ''; ?>
        <fieldset>
            <legend>Register</legend>
            <div>
                <label for="fname">First name</label>
                <?php if (isset($error) && in_array('fname', $error)) echo "<p class='warning'>Please enter your fname</p>" ?>
                <input type="text" name="fname" id="" required value="<?php echo isset($clean['fname']) ? htmlentities($clean['fname'], ENT_QUOTES, 'utf-8') : '' ?>">
            </div>
            <div>
                <label for="lname">Last name</label>
                <?php if (isset($error) && in_array('lname', $error)) echo "<p class='warning'>Please enter your lname</p>" ?>
                <input type="text" name="lname" id="" required value="<?php echo isset($clean['lname']) ? htmlentities($clean['lname'], ENT_QUOTES, 'utf-8') : '' ?>">
            </div>
            <div>
                <label for="email">Email</label>
                <?php if (isset($error) && in_array('email', $error)) echo "<p class='warning'>Please enter your email</p>" ?>
                <input type="email" name="email" id="" required value="<?php echo isset($clean['email']) ? htmlentities($clean['email'], ENT_QUOTES, 'utf-8') : '' ?>">
            </div>
            <div>
                <label for="pass">Password</label>
                <?php if (isset($error) && in_array('pass', $error)) echo "<p class='warning'>Please enter your password</p>" ?>
                <input type="password" name="pass" id="" required value="<?php echo isset($clean['pass']) ? htmlentities($clean['pass'], ENT_QUOTES, 'utf-8') : '' ?>">
            </div>
            <div>
                <label for="cpass">Confirm password</label>
                <?php if (isset($error) && in_array('cpass', $error)) echo "<p class='warning'>Please enter your cconfirm password</p>" ?>
                <input type="password" name="cpass" id="" required value="<?php echo isset($clean['cpass']) ? htmlentities($clean['cpass'], ENT_QUOTES, 'utf-8') : '' ?>">
            </div>
        </fieldset>
        <input type="submit" name="submit" value="Register" style="width: 100px; height: 25px;">
    </form>
</div>

<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>
