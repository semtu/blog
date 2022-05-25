<?php
session_start();
include('includes/header.php');
?>

<body class="bg-gradient-primary">
<div class="container">

<div class="card o-hidden border-0 shadow-lg my-5">
  <div class="card-body p-0">
    <!-- Nested Row within Card Body -->
    <div class="row">
      <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
      <div class="col-lg-7">
        <div class="p-5">
          <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
          </div>
          <form class="user" action="rcode.php" method="POST">
            <div class="form-group"> 
                <label> Username </label>
                <input type="text" name="username" class="form-control form-control-user" placeholder="Enter Username">
            </div>
            <div class="form-group"> 
                <label> Email </label>
                <input type="email" name="email" class="form-control form-control-user" placeholder="Enter Email">
            </div>
            <div class="form-group"> 
                <label> Password </label>
                <input type="password" name="password" class="form-control form-control-user" placeholder="Enter Password">
            </div>
            <div class="form-group"> 
                <label> Confirm Password </label>
                <input type="password" name="confirmpassword" class="form-control form-control-user" placeholder="Enter Password">
            </div>
            <input type="hidden" name="usertype" value="admin" >
            <button type="submit" name="registerbtn" class="btn btn-primary btn-user btn-block"> Register Account </button>
          </form>
          <hr>
          <div class="text-center">
            <a class="small" href="forgot-password.php">Forgot Password?</a>
          </div>
          <div class="text-center">
            <a class="small" href="login.php">Already have an account? Login!</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
</body>

<?php
include('includes/scripts.php');
?>