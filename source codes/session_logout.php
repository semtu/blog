Part 9-Admin Panel(Logout): Logout System with Session Destroy in php

As per the video, we have already downloaded the files and linked the CSS and JS.

Step 1: Create a page and paste the below code where you want to set the Logout Button :

<form action="logout.php" method="POST"> 
      <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>
</form>

Step 2: Create a page with the name logout.php and paste the below code.
<?php
session_start();

if(isset($_POST['logout_btn']))
{
    session_destroy();
    unset($_SESSION['username']);
    header('Location: login.php');
}

?>