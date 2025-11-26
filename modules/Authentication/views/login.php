<!DOCTYPE html>
<html lang="en">

<?php include('../../../layouts/admin_header.php'); ?>

<body style="background:url('../../../assets/image/luxurious-hotel-login.jpg');background-position: center; background-size: cover;">

   <div class="container">

      <!-- Outer Row -->
      <div class="row justify-content-center">

         <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
               <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->
                  <div class="row">
                     <div class="col-lg-4 d-none d-lg-block bg-login-image" style="background:url('../../../assets/image/cyber1.jpg');background-position: center; background-size: cover;"></div>
                     <div class="col-lg-8">
                        <div class="p-5">
                           <div class="text-center">
                              <h1 class="h4 text-gray-900 mb-4">Login To Dashboard!</h1><br />
                              <?php
                              if (isset($result)) {
                                 echo "<div " . $alert_class . ">$result<a href='publicvoid0' class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>";
                              }
                              ?>
                           </div>
                           <form id="loginForm" class="user" method="post" action="login.php">
                              <div class="form-group">
                                 <input type="text" name="username" class="form-control form-control-user" id="username"
                                    aria-describedby="UsernameHelp" placeholder="Enter Username...">
                              </div>
                              <div class="form-group">
                                 <input type="password" name="password" class="form-control form-control-user"
                                    id="password" placeholder="Password">
                              </div>
                              <div class="form-group">
                                 <div class="custom-control custom-checkbox small">
                                    <input onclick="ShowPassword();" type="checkbox" class="custom-control-input"
                                       id="customCheck">
                                    <label class="custom-control-label" for="customCheck">Show Password</label>
                                 </div>
                              </div>
                              <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                 Login
                              </button>
                           </form>
                           <hr>
                           <div class="text-center">
                              <a class="small" href="../../Authentication/views/forgotPassword.php">Forgot Password?</a>
                           </div>
                           <div class="text-center">
                              <a class="small" href="../../General/views/index.php">Go to Everretreat Home Page!</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>

      </div>

   </div>

   <!-- Include Dashboard Scripts -->
   <?php include('../../../layouts/admin_scripts.php'); ?>



   <script>
      $(document).ready(function () {
         $('#loginForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the form from submitting normally

            let formData = {
               username: $('#username').val(),
               password: $('#password').val()
            };

            $.ajax({
               type: 'POST',
               url: '../api/authApi.php?action=login',
               data: formData,
               dataType: 'json',
               success: function (response) {
                  if (response.success) {
                     if (response.status == 'Waiting') {
                        Swal.fire({
                           icon: 'warning',
                           title: 'NO ACCESS RIGHTS!',
                           text: 'Please Contact Admin for the Account Activation.'
                        });
                     } else if (response.status == 'Deactivated') {
                        Swal.fire({
                           icon: 'warning',
                           title: 'ACCOUNT DEACTIVATED!',
                           text: 'Please Contact Admin for the Account Activation.'
                        });
                     } else if (response.status == 'Pending') {
                        Swal.fire({
                           icon: 'warning',
                           title: 'ACCOUNT PENDING!',
                           text: 'Please Check your Email To confirm Identity or Contact Admin.'
                        });
                     } else {
                        // Success notification with SweetAlert
                        Swal.fire({
                           icon: 'success',
                           title: 'Login Successful!',
                           text: response.message,
                           showConfirmButton: false,
                           timer: 1500
                        }).then(() => {
                           if (response.roleid == 1) {
                              window.location.href =
                                 '../../Authentication/views/dashboard.php'; // Redirect after login success
                           } else if (response.roleid == 2) {
                              window.location.href =
                                 '../../MilkCollection/views/index.php'; // Redirect after login success
                           } else if (response.roleid == 3) {  //FARMER LOGIN

                              window.location.href =
                                 '../../Farmer/views/index.php'; // Redirect after login success

                           } else if (response.roleid == 4) {   //CUSTOMER LOGIN

                              window.location.href =
                                 '../../MilkOrder/views/orders.php'; // Redirect after login success

                           } else {
                              window.location.href =
                                 '../../Authentication/views/profile.php';
                           }
                        });
                     }
                  } else {
                     // Error notification with SweetAlert
                     Swal.fire({
                        icon: 'error',
                        title: 'Login Failed!',
                        text: response.message
                     });
                  }
               },
               error: function (xhr, status, error) {
                  console.log('Response:', xhr.responseText);
                  Swal.fire({
                     icon: 'error',
                     title: 'Error!',
                     text: 'Something went wrong. Please try again.'
                  });
               }
            });
         });
      });
   </script>
   <!-- Show Password -->
   <script>
      let password = document.getElementById('password');
      function ShowPassword(){
        if (password.type === "password"){
          password.type = "text";
          // console.log("changed");
        }else{
          password.type = "password";
        }
      }
      
   </script>

</body>

</html>