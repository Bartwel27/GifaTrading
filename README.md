# GifaTrading
A repository gifa trading written in php8 and mysqli5, it was a test project for GiFa trading that allowed users to sign in and register only, and have made some improvement to the code.

### features
There are some good features i saw when i first saw this code.
```
	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
```
As you can see the code is clean, well aligned and well designed.


### Issues
> couldn't login to the system

> no prepared statements

### Solved
> allowes to loggin
> added prepared statements
