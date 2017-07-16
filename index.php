<?php

session_start();

if (array_key_exists('email', $_POST) OR array_key_exists('password', $_POST)) {

    $link = mysqli_connect('shareddb1a.hosting.stackcp.net', '6phpusers-342e5d', '6phppassword', '6phpusers-342e5d');

    if (mysqli_connect_error()) {
	   die ('There was an error in connecting to the database');
    }
    
    if ($_POST['email'] == "") {
		echo "An email address is required";
	} else if ($_POST['password'] == "") {
        echo "A password is required";
      } else {
         $query = 'SELECT `id` FROM `users` WHERE email = "'.mysqli_real_escape_string($link, $_POST['email']).'"';
         $result = mysqli_query($link, $query);
        
         if (mysqli_num_rows($result) > 0) {
             echo "<p>That email address has already been taken</p>";
         } else {
             $query = "INSERT INTO users (email, password) VALUES 
             ('".mysqli_real_escape_string($link, $_POST['email'])."',
             '".mysqli_real_escape_string($link, $_POST['password'])."')";
             
             if (mysqli_query($link, $query)) {
                 $_SESSION['email'] = $_POST['email'];
                 header("Location: session.php");
             } else {
                 echo "<p>There was a problem, please try again later</p>";
             }
         }
    }
}

?>

<form method="post">
  <input name="email" placeholder="email address" type="text">
  <input name="password" type="password" placeholder="password">
  <input type="submit" value="Sign up">
</form>