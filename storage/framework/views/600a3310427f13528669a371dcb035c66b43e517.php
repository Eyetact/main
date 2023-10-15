
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page">
            <div class="page-single">
                <div class="container">
                    <div class="row">
                        <div class="col mx-auto">
                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center title-style mb-6">
                                                <h1 class="mb-2">Login</h1>
                                                <hr>
                                                <p class="text-muted">Sign In to your account</p>
                                            </div>
                                            <form method="POST" class="form-horizontal form-simple"
                                            action="<?php echo e(route('login')); ?>" id="login">
                                            <?php echo csrf_field(); ?>
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-user"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Email" name="email" id="user-name">
                                                    <?php $__errorArgs = ['login'];
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
                                                </div>
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-lock"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control" placeholder="Password" name="password" id="user-password" >
                                                    <?php $__errorArgs = ['password'];
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
                                                </div>
                                            
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn  btn-primary btn-block px-4">Login</button>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <a href="<?php echo e(url('/' . $page='forgot-password-1')); ?>" class="btn btn-link box-shadow-0 px-0">Forgot password?</a>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<!-- <script>
    $(document).ready(function() {
        $("#login").validate({
            ignore: ":hidden",
            rules: {
                login: {
                    required: true,
                    //email: true,
                    maxlength: 250,
                },
                password: 'required'
            },
            messages: {
                login: {
                    required: "The Email field is required",
                    //email: "Email must be a valid email",
                },
                password: {
                    required: "The Password field is required"
                }
            },
        });
    });
</script> -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\eyt_master\laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>