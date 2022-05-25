<?php
session_start();
include('includes/header.php');
?>

<body class="bg-gradient-primary">
<div class="container">
<!-- Outer Row -->
<div class="row justify-content-center">
  <div class="col-xl-6 col-lg-6 col-md-6">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Login Here!</h1>
              </div>
                <form class="user" action="code.php" method="POST">

                    <div class="form-group">
                    <input type="email" name="emaill" class="form-control form-control-user" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                    <input type="password" name="passwordd" class="form-control form-control-user" placeholder="Password">
                    </div>
            
                    <button type="submit" name="login_btn" class="btn btn-primary btn-user btn-block"> Login </button>
                    <hr>
                </form>

                <div class="text-center">
                  <a class="small" href="forgot-password.php">Forgot Password?</a>
                </div>
                <div class="text-center">
                  <a class="small" href="register2.php">Register</a>
                </div>

            </div>
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