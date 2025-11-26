<?php
if(isset($_GET['email'])){
    $email = $_GET['email'];
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('../../../includes/admin_header.php'); ?>

<body>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8 align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.php" class="logo d-flex align-items-center w-auto">
                                    <img src="../../../assets/dashboard_assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">UMCD</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Reset Your Password</h5>
                                    </div>

                                    <form id="resetPasswordForm">
                                        <div class="col-12">
                                            <label for="password" class="form-label">Enter New Password</label>
                                            <input type="password" name="password" class="form-control" id="password" required>
                                            <input type="hidden" name="email" value="<?=$email?>" class="form-control" id="email" required>
                                        </div>

                                        <div class="col-12">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
                                            <span id="passwordMatchMessage" class="text-danger"></span> <!-- Password match message -->
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-success w-100" type="submit" id="submitBtn" disabled>Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="credits text-center">
                                Designed by <a href="#">Emmanuel NSENGIMANA</a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Include Dashboard Scripts -->
    <?php include('../../../includes/admin_scripts.php'); ?>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include SweetAlert for alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // console.log('Email: ',email);
            $("#password, #confirmPassword").on("keyup", function () {
                var password = $("#password").val();
                var confirmPassword = $("#confirmPassword").val();
                var message = $("#passwordMatchMessage");
                var submitBtn = $("#submitBtn");

                if (password === confirmPassword && password !== "") {
                    message.text("Passwords match").removeClass("text-danger").addClass("text-success");
                    submitBtn.prop("disabled", false);
                } else {
                    message.text("Passwords do not match").removeClass("text-success").addClass("text-danger");
                    submitBtn.prop("disabled", true);
                }
            });

            $("#resetPasswordForm").on("submit", function (e) {
                e.preventDefault(); // Prevent form from reloading the page

                var password = $("#password").val();
                var confirmPassword = $("#confirmPassword").val();
                var email = $("#email").val();

                if (password !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Passwords do not match. Please try again.'
                    });
                    return;
                }

                var formData = {
                    password: password,
                    email: email
                };

                $.ajax({
                    type: "POST",
                    url: "../api/authApi.php?action=reset_password", // Adjust your API URL
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Your password has been reset successfully.',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = "login.php"; // Redirect to login page
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: response.message
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again. ' + status + ' ' + error
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
