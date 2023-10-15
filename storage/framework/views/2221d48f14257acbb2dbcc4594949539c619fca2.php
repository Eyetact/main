<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Forgot Password</title>
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/ico/apple-icon-120.png')); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('images/ico/favicon.ico')); ?>">
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/vendors.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/forms/icheck/icheck.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/forms/icheck/custom.css')); ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap-extended.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/colors.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/components.css')); ?>">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/core/menu/menu-types/vertical-menu.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/core/colors/palette-gradient.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/login-register.css')); ?>">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/style.css')); ?>">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 1-column   blank-page blank-page" data-open="click" data-menu="vertical-menu"
    data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1"><img class="guest_logo" src="<?php echo e(asset('images/logo/logo.png')); ?>" alt="branding logo"></div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>Forgot Password</span></h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <?php if(session('status')): ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo e(session('status')); ?>

                                            </div>
                                        <?php endif; ?>

                                        <form method="POST" action="<?php echo e(route('password.email')); ?>" class="form-horizontal form-simple" id="fogot_password">
                                            <?php echo csrf_field(); ?>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" placeholder="<?php echo e(__('Email Address')); ?>" value="<?php echo e(old('email')); ?>" autocomplete="email" autofocus>
                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </fieldset>

                                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                                    class="feather icon-unlock"></i> <?php echo e(__('Send Password Reset Link')); ?></button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo e(asset('vendors/js/vendors.min.js')); ?>"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo e(asset('vendors/js/forms/icheck/icheck.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/forms/validation/jqBootstrapValidation.js')); ?>"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo e(asset('js/core/app-menu.js')); ?>"></script>
    <script src="<?php echo e(asset('js/core/app.js')); ?>"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?php echo e(asset('js/scripts/forms/form-login-register.js')); ?>"></script>
    <!-- END: Page JS-->
    <script src="<?php echo e(asset('js/core/libraries/jquery.validate.min.js')); ?>"></script>

</body>
<!-- END: Body-->
<script>
    $(document).ready(function() {
        $("#fogot_password").validate({
            ignore: ":hidden",
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 250,
                }
            },
            messages: {
                email: {
                    required: "The Email field is required",
                    email: "Email must be a valid email",
                }
            },
        });
    });
</script>

</html>
<?php /**PATH D:\xampp\htdocs\eyt_master\laravel\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>