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
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password_1 = trim($_POST['password_1']);
  $password_2 = trim($_POST['password_2']);

        
  if (
  !empty($username) &&
  !empty($email) &&
  !empty($password_1) &&
  !empty($password_2)
  ) {
   if ($password_1 == $password_2) { // match passwords
     if (!strpos("@",$email)) { // for email with no @
        $check_user_sql = "select * from users where username = ? or email = ?";
        $check_stmt = mysqli_stmt_init($db);
        if (mysqli_stmt_prepare($check_stmt,$check_user_sql)) { // check if prepared stmt works
          mysqli_stmt_bind_param($check_stmt,"ss",$username,$email);
          mysqli_stmt_execute($check_stmt);
          $check_res = mysqli_stmt_get_result($check_stmt);
          $search = mysqli_fetch_assoc($check_res);
          if ($username !== $search["username"] && $email !== $search["email"]) { // check a user exists
            $password = password_hash($password_1,PASSWORD_DEFAULT);
            $currency="";
            $in_sql = "insert into users (username,email,password,currency) values (?,?,?,?)";
            $in_stmt = mysqli_stmt_init($db);
            if (mysqli_stmt_prepare($in_stmt,$in_sql)) {
               mysqli_stmt_bind_param($in_stmt,"ssss",$username,$email,$password,$currency);
               mysqli_stmt_execute($in_stmt);
               mysqli_stmt_close($in_stmt);
             mysqli_stmt_close($check_stmt);
             
             $_SESSION['username'] = $username;
             $_SESSION['success'] = "You are now logged in";
             header('location: index.php');
             
            } else {array_push($errors,"we are unable to create your account, try again!");}
          } else {array_push($errors,"Please use a different email!");}
        } else {array_push($errors,"Something went wrong whiles checking, please try again!");}
     } else {array_push($errors,"Your email is invalid!");}
   } else {array_push($errors,"Your passwords did not match!");}
  } else {array_push($errors,"Your input fields are empty!");}  
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        /*
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
          $user_check_query = "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1";
          $user_stmt = mysqli_stmt_init($db);
          if (!mysqli_stmt_prepare($user_stmt,$user_check_query)) {
          array_push($errors,"sorry something went wrong");
          } else {
          mysqli_stmt_bind_param($user_stmt,"ss",$username,$email);
          mysqli_stmt_execute($user_stmt);
          $result = mysqli_stmt_get_result($user_stmt);
          }
          $user = mysqli_fetch_assoc($result);
          
          if ($user) { // if user exists
          if ($user['username'] === $username) {
          array_push($errors, "Username already exists");
          }
          
          if ($user['email'] === $email) {
          array_push($errors, "email already exists");
          }
          }
          mysqli_stmt_close($user_stmt); 
          
          // Finally, register user if there are no errors in the form
          if (count($errors) == 0) {
          $password = password_hash($password_1,PASSWORD_DEFAULT);//encrypt the password before saving in the database
          
          $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
          $query_stmt = mysqli_stmt_init($db);
          if (!mysqli_stmt_prepare($query_stmt,$query)) {
          array_push($errors,"there was a problem creating your account");
          } else {
          mysqli_stmt_bind_param($query_stmt,"sss",$username,$email,$password);
          mysqli_stmt_execute($query_stmt);
          $get_R = mysqli_stmt_get_result($query_stmt);
          $fetch_D = mysqli_fetch_assoc($get_R);
          }
          $_SESSION['username'] = $fetch_D["username"];
          $_SESSION['success'] = "You are now logged in";
          header('location: index.php');
          //mysqli_stmt_close($query_stmt);
          }
        */
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
  	
  	
  	$query = "SELECT * FROM users WHERE username = ? or password = ?";
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
  	
  	// now here verift your hashed pass
  	if ($dbuser == $username && password_verify($password,$dbpass)) {
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