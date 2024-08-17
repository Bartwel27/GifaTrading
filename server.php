<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost:3306', 'root', 'root', 'Gifa_Trading');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	
  	
  	$query = "SELECT * FROM users WHERE username = ? AND password = ?";
  	$stmt = mysqli_stmt_init($db);
  	if (!mysqli_stmt_prepare($stmt,$query)) {
  	  array_push($errors,"sql syntax errors");
  	} else {
  	  mysqli_stmt_bind_param($stmt,"ss",$username,$password);
  	  mysqli_stmt_execute($stmt);
  	  $sql_R = mysqli_stmt_get_result($stmt);
  	}
  	
  	$fetch = mysqli_fetch_assoc($sql_R);
  	// fetched from db
  	$dbuser = $fetch["username"];
  	$dbpass = $fetch["password"];
  	
  	if ($dbuser == $username && $dbpass == $password) {
  	  $_SESSION['username'] = $dbuser;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  	
  mysqli_stmt_close($stmt);
 
  	/*
  	  $password = md5($password);
  	  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	  $results = mysqli_query($db, $query);
  	  if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	  }else {
  	  array_push($errors, "Wrong username/password combination");
  	  }
  	*/
  	
  }
  
}

?>