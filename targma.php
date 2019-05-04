<?php session_start();
/*
Template Name: اضافة طلب مشروع ترجمة
 * Template Post Type: page

*/

get_header('applications');
$studentPageId=33;
$employeePageId=46;

$user = wp_get_current_user();
$roles = ( array ) $user->roles;
array_multisort($roles);


if($roles[0]!='student'){
    if(strpos(' '.$roles[0],'_employee')){
        wp_redirect(get_permalink($employeePageId));
    }else{
        wp_redirect(home_url());
    }
}

if(isset($_POST['title'])&&isset($_POST['academicNotes'])){
    $error=[];
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error[]=' ادخل الاميل بطريقة صحيحة';
    }
    if (strlen ($_POST['phoneNumber'])<3 ) {
        $error[]=' ادخل رقم الجوال';
    }
    if(!count($error)){

        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        // var_dump($_FILES);exit;

        $uploadedfile = $_FILES['schoolSchedule'];

        $upload_overrides = array( 'test_form' => false );

        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

        if ( $movefile && ! isset( $movefile['error'] ) ) {
            // echo "File is valid, and was successfully uploaded.\n";
            // var_dump( $movefile );
            $_POST['schoolSchedule']=$movefile['url'];
            // echo $movefile['error'];
            $uploadedfile = $_FILES['academicRecord'];

            $upload_overrides = array( 'test_form' => false );

            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

            if ( $movefile && ! isset( $movefile['error'] ) ) {
                // echo "File is valid, and was successfully uploaded.\n";
                // var_dump( $movefile );
                $_POST['academicRecord']=$movefile['url'];

                $title=esc_html( get_the_author_meta( 'universityNumber', $user->ID ) );;

                $new_post = array(
                    'post_title'    =>  $title,
                    'post_status'   =>  'publish',// Choose: publish, preview, future, draft, etc.
                    'post_type' =>  'targma'  //'post',page' or use a custom post type if you want to
                );
                //SAVE THE POST
                $post_ID = wp_insert_post($new_post,true);

                update_post_meta( $post_ID, 'phoneNumber',$_POST['phoneNumber']);
                update_post_meta( $post_ID, 'email',$user->user_email);
                update_post_meta( $post_ID, 'student',get_current_user_id());
                update_post_meta( $post_ID, 'gpa',$_POST['gpa']);

                update_post_meta( $post_ID, 'isWarned',$_POST['isWarned']);
                if (!$_POST['isWarned']) {
                    $_POST['warnNumbers']='';
                }
                update_post_meta( $post_ID, 'warnNumbers',$_POST['warnNumbers']);

                update_post_meta( $post_ID, 'academicNotes',$_POST['academicNotes']);
                update_post_meta( $post_ID, 'scheduleTime',$_POST['academicNotes']);

                update_post_meta( $post_ID, 'schoolSchedule',$_POST['schoolSchedule']);
                update_post_meta( $post_ID, 'academicRecord',$_POST['academicRecord']);

                update_post_meta( $post_ID, 'requestStatus',-1);
                update_post_meta( $post_ID, 'requestStatusNotes','');
                $successMsg='تم الحفظ بنجاح';
                echo "<meta http-equiv='refresh' content='1;".get_permalink($studentPageId)."'/>";
            } else {
                $errorMsg=" يرجى محاولة الرفع مره اخرى ";
            }
        } else {
            $errorMsg=" يرجى محاولة الرفع مره اخرى ";
        }
    }else{
        // var_dump($error);
        $errorMsg=implode(',',$error);
    }
}
extract($_POST);
?>
<section class="pages-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4> مشروع ترجمة </h4>
            </div>
        </div>
    </div>
</section>
<section class="forms login-form">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2 form-container">
                <div class="logo-form">
                    <img src="<?php echo get_template_directory_uri() ?>/applications/images/logo.png" class="img-fluid">
                </div>
                <?php if ($errorMsg): ?>
                    <div class="alert alert-danger col-md-12"> <?php echo $errorMsg ?> </div>
                <?php endif ?>
                <?php if ($successMsg): ?>
                    <div class="alert alert-success col-md-12"> <?php echo $successMsg ?> </div>
                <?php endif ?>
                <form method="POST" action="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder=" الرقم الجامعي" required="" readonly value="<?php echo esc_html( get_the_author_meta( 'universityNumber', $user->ID ) ); ?>">
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phoneNumber" value="<?php echo $phoneNumber ?>" class="form-control" placeholder="رقم الجوال" required="">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder=" البريد الالكتروني" value="<?php echo $user->user_email ; ?>" readonly required="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="gpa" value="<?php echo $gpa ?>" class="form-control" placeholder="المعدل التراكمي" required="">
                    </div>
                    <div class="form-group">
                        <h5> هل لديك انذار أكاديمي : </h5>
                        <select class="form-control isWarned" name="isWarned" required="true">
                            <option value="0" <?php echo $_POST['isWarned']==0?"selected":''; ?>>لا</option>
                            <option value="1" <?php echo $_POST['isWarned']==1?"selected":''; ?>>نعم</option>
                        </select>
                        <div class="warnNumbers" style="display:none">
                            <input type="number" class="form-control" placeholder="الرجاء ذكر عدد الانذارات" name="warnNumbers" value="<?php echo $warnNumbers ?>" />
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="academicNotes">اضافة ملاحظات على وضعك الاكاديمي ترغبين من
                            المسجله بأن تكون على علم بها: </label>
                        <textarea class="form-control" required name="academicNotes" rows="3"><?php echo $academicNotes ?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" required name="schoolSchedule"/>
                                <label class="custom-file-label" for="inputGroupFile01">صورة الجدول الدراسي المسجل لك هذا الفصل </label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" required name="academicRecord"/>
                                <label class="custom-file-label" for="inputGroupFile02">صورة من السجل الأكاديمي كاملا </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> * يتوجب على الطالبة الحضور للجامعة لطباعة جدولها
                            النهائي و التأكد من نزول جميع المواد في الجدول في موعد أقصاه ........</label>
                        <input type="text" name="scheduleTime" value="<?php echo $scheduleTime ?>" class="form-control" placeholder=" أقصي موعد" required="">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="line-btn no-line" required="">ارسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
$('.isWarned').bind('change',function(){
    if($(this).val()==1){
        $('.warnNumbers').show()
        $('.warnNumbers input').prop('required',true)
    }else{
        $('.warnNumbers').hide()
        $('.warnNumbers input').prop('required',false)
    }
})
$('.isWarned').trigger('change')
</script>
<?php get_footer('applications');?>