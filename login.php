<?php
/*
Template Name: تسجيل دخول
 * Template Post Type: page

*/

get_header('applications');

if ( isset($_POST["user_email"]) && isset($_POST["user_password"]) ) {

    $user_login     = esc_attr($_POST["user_email"]);
    $user_password  = esc_attr($_POST["user_password"]);
    $user_email = esc_attr($_POST["user_email"]);

    $user_data = array(
        'user_login'    =>      $user_login,
        'user_pass'     =>      $user_password,
        'user_email'    =>      $user_email,
        // 'role' => 'student'
    );

    // Inserting new user to the db
    //wp_insert_user( $user_data );

    $creds = array();
    $creds['user_login'] = $user_login;
    $creds['user_password'] = $user_password;
    $creds['remember'] = true;

    $user = wp_signon( $creds, false );
    if($user->errors){
        $errorMsg='البيانات غير صحيحة';
        // var_dump($user);exit;
    }else{
        $userID = $user->ID;
        wp_set_current_user( $userID, $user_login );
        wp_set_auth_cookie( $userID, true, false );
        do_action( 'wp_login', $user_login );
        $user = wp_get_current_user();
        $roles = ( array ) $user->roles;
        array_multisort($roles);
        // var_dump($roles);exit;
        if($roles[0]=='student'){
            // var_dump('redirect to student profile');
            wp_redirect(get_permalink($studentPageId));
        }elseif(strpos(' '.$roles[0],'_employee')){
            wp_redirect(get_permalink($employeePageId));
        }else{
            wp_redirect(admin_url());
        }
    }
}
?>
<section class="pages-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>تسجيل الدخول</h4>
            </div>
        </div>
    </div>
</section>
<section class="forms login-form">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 form-container">
                <div class="logo-form">
                    <img src="<?php echo get_template_directory_uri() ?>/applications/images/logo.png" class="img-fluid">
                </div>
                <?php if ($errorMsg): ?>
                    <div class="alert alert-danger col-md-12"> <?php echo $errorMsg ?> </div>
                <?php endif ?>
                <form method="POST" action="<?php the_permalink(); ?>">
                    <div class="form-group">
                        <input type="text" name="user_email" class="form-control" placeholder="اسم المستخدم" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" name="user_password" class="form-control" placeholder="رقم المرور" required="">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="line-btn no-line" required="">دخول</button>
                    </div>
                    <div class="form-group text-center">
                        <!-- <ul class="list-unstyled list-login">
                            <li><a href=""></a></li>
                            <li><a href="">انشاء حساب</a></li>
                            </ul> -->
                    </div>
                    <!-- <div class="form-group text-center">
                        <h6>
                          All Rights Reserved 2019 © Rana Ismail
                        </h6>
                        </div> -->
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer('applications');?>