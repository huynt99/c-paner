<div id="footer">
    <div style="float: left;">
        <a href="admin/index.php">Admin page</a>
    </div>
    <ul class="footer-links">

		<?php
		if (isset($_SESSION["level"])) {
			switch ($_SESSION["level"]) {
				case 1 :
					echo '  <li><a href="profile.php">User profile</a></li>
                            <li><a href="change-password.php">Change password</a></li>
                            <li><a href="logout.php">Logout</a></li>';
					break;
				case 0 :
					echo '  <li><a href="profile.php">User profile</a></li>
                            <li><a href="change-password.php">Change password</a></li>
                            <li><a href="admin/index.php">Admin manager</a></li>
                            <li><a href="logout.php">Logout</a></li>';
					break;
				default :
					echo '  <li><a href = "register.php" > Register</a ></li >
                            <li ><a href = "login.php" > Login</a ></li >';
					break;
			}
		} else {
			echo '  <li><a href = "register.php" > Register</a ></li >
                    <li ><a href = "login.php" > Login</a ></li >';
		}
		?>
    </ul>
</div>
<!--end footer-->
</div> <!-- end content-container-->
</div>
<!--end container-->
</body>

</html>