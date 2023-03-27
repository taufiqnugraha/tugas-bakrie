<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login - id</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() . 'assets/images/favicon.ico'; ?>">
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url() . 'assets/css/bootstrap.min.css'; ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url() . 'assets/css/icons.min.css'; ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url() . 'assets/css/app.min.css'; ?>" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Loader -->
    <link href="<?php echo base_url() ?>assets/css/overlay-loading.css" rel="stylesheet">
</head>

<body>
    <!-- Loader -->
    <div class="loading d-none"></div>

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h3 class="text-primary">Welcome Back !</h3>
                                        <p>Sign in to continue.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="index.html" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?php echo base_url() . 'assets/images/logo-light.svg'; ?>" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>

                                <a href="index.html" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?php echo base_url() . 'assets/images/logo.png'; ?>" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form id="form-login" class="form-horizontal" method="post">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" value="taufiq">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" value="12345">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        <small id="err-password" class="error"></small>
                                    </div>
                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <a href="#" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url() . 'assets/libs/jquery/jquery.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/libs/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>
    <!-- Sweet Alerts js -->
    <script src="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- App js -->
    <script src="<?php echo base_url() . 'assets/js/app.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/js/pages/js-validate.min.js'; ?>"></script>
    <script>
        var hostname = '<?php echo base_url(); ?>';

        $("#form-login").validate({
            rules: {
                username: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
                username: "Username must be filled.",
                password: "Password must be filled.",
            },
            errorElement: 'small',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    if (element.attr("name") == "password") {
                        error.insertAfter("#err-password");
                    } else {
                        error.insertAfter(element);
                    }
                }
            },
            highlight: function(element) {
                $(element).parent().addClass("text-danger");
            },
            submitHandler: function(form, event) {
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    url: hostname + 'login/submit',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function(data) {
                        $('.loading').removeClass('d-none');
                    },
                    success: function(data) {
                        var result = JSON.parse(data);
                        if (result.reason == 'blocked') {
                            Swal.fire(
                                '',
                                'Your account is blocked <br> Please contact Administrator.',
                                'error'
                            );
                        } else if (result.reason == false) {
                            Swal.fire(
                                '',
                                'Login failed. <br> Please check username and password',
                                'info'
                            );
                        } else {
                            window.location.href = hostname + 'dashboard';
                        }
                    },
                    complete: function(date) {
                        $('.loading').addClass('d-none');
                    }
                });
            },
        });
    </script>
</body>

</html>
