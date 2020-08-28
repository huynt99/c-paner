<?php
include_once('db/connect.php');
include('function.php');
$title = 'Contact Us';
include('views/header.php');
include('views/sidebar-a.php');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array();

    // su dung ham cleanEmail de loai bo các ki tu dac biet trong $_POST
    $clean = array_map('cleanEmail', $_POST);

    if (empty($clean['name'])) {
        $error[] = 'name';
    }

    if (!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/', $clean['email'])) {
        $error[] = 'email';
    }

    if (empty($clean['message'])) {
        $error[] = 'message';
    }

    if (empty($error)) {
        $email = $clean['email'];
        $body = "Name: {$clean['name']} \n\n Message: \n" . trim(strip_tags($clean['message']));
        $body = wordwrap($body);
        if (mail($email, 'Contact form', $body, 'FROM: huyng9x157@gmail.com')) {
            $message =  "<p class='success'>Thank you for contacting me!</p>";
        } else {
            $message =  "<p class='warning'>Your email could not be sent!</p>";
        }
    } else {
        $message =  "<p class='warning'>Please fill all the required fields!</p>";
    }
}
?>
<div id="content">
    <form id="contact" method="POST">
        <?php echo (isset($message)) ? $message : ''; ?>
        <fieldset>
            <legend>Contact</legend>
            <div>
                <label for="name">Full name</label>
                <?php if (isset($error) && in_array('name', $error)) echo "<p class='warning'>Please enter your name</p>" ?>
                <input type="text" name="name" id="" required value="<?php echo isset($clean['name']) ? htmlentities($clean['name'], ENT_QUOTES, 'utf-8') : '' ?>">
            </div>
            <div>
                <label for="email">Email</label>
                <?php if (isset($error) && in_array('email', $error)) echo "<p class='warning'>Please enter your email</p>" ?>
                <input type="email" name="email" id="" required value="<?php echo isset($clean['email']) ? htmlentities($clean['email'], ENT_QUOTES, 'utf-8') : '' ?>">
            </div>
            <div>
                <lable for="message">Message</lable>
                <?php if (isset($error) && in_array('message', $error)) echo "<p class='warning'>Please enter your message</p>" ?>
                <div>
                    <textarea name="message" cols="30" rows="10" style="width: 350px; height: 100px;">
                        <?php echo isset($clean['message']) ? htmlentities($clean['message'], ENT_QUOTES, 'utf-8') : '' ?>
                    </textarea>
                </div>
            </div>
        </fieldset>
        <input type="submit" name="submit" value="submit" style="width: 100px; height: 25px;">
    </form>
</div>
<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>