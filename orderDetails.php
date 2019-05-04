<?php session_start();
/*
Template Name: تفاصيل الطلب
 * Template Post Type: page

*/

get_header('applications');
$studentPageId=33;
$employeePageId=46;
$employee=false;
$user = wp_get_current_user();
$roles = ( array ) $user->roles;
array_multisort($roles);

$order_id=(int)$_GET['order_id'];
$post_type = get_post_type( $order_id );
    
if($roles[0]=='student'){
    $orderStudent = get_post_meta($order_id,'student',true);
    if(get_current_user_id()!=$orderStudent){
        wp_redirect(get_permalink($studentPageId));
    }
}elseif(strpos(' '.$roles[0],'_employee')){
    $user_post_type=str_replace('_employee', '', $roles[0]);
    // var_dump($user_post_type);exit;
    if($user_post_type!=$post_type){
        wp_redirect(get_permalink($employeePageId));
    }
    $employee=true;
}

if(isset($_POST['save'])&&$employee){
    // var_dump($order_id);exit;
    if($_POST['requestStatus']){
        update_post_meta( $order_id, 'requestStatus',$_POST['requestStatus']);
        if ($_POST['requestStatus']!=2) {
            $_POST['requestStatusNotes']='';
        }
        update_post_meta( $order_id, 'requestStatusNotes',$_POST['requestStatusNotes']);
    }else{
        update_post_meta( $order_id, 'requestStatus',-1);
        update_post_meta( $order_id, 'requestStatusNotes','');
    }
    $successMsg='تم الحفظ بنجاح';
    echo "<meta http-equiv='refresh' content='1;".get_permalink($employeePageId)."'/>";
}
$actions=[
    '1'=>'تم قبول الحالة الرجاء القبول والتسجيللا لاضافتها',
    '2'=>'تم رفض الحالة بسبب....',
    '3'=>'يلزم مراجعة قسم التجاوز بمكتب الارشاد الأكاديمي'
];

$requestStatus = get_post_meta($order_id,'requestStatus',true);
$requestStatusNotes = get_post_meta($order_id,'requestStatusNotes',true);
$actionTaken=in_array($requestStatus,array_keys($actions))?$actions[$requestStatus]:'';
$actionTaken.=$requestStatus==2?$requestStatusNotes:'';
?>
<section class="pages-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4> تفاصيل الطلب</h4>
            </div>
        </div>
    </div>
</section>
<section class="forms login-form">
    <div class="container">
        <div class="row">
            <?php if ($successMsg): ?>
                <div class="alert alert-success col-md-12"> <?php echo $successMsg ?> </div>
            <?php endif ?>
            <div class="clearfix"></div>
            <div class="col-12 form-container">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">الرقم الجامعي : <?php echo get_the_title($order_id) ?></label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">الرقم الجوال : <?php echo get_post_meta($order_id,'phoneNumber',true); ?></label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> البريد الالكتروني : <?php echo get_post_meta($order_id,'email',true); ?></label>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> المعدل التراكمي : <?php echo get_post_meta($order_id,'gpa',true); ?></label>
                    </div>
                    <div class="form-group">
                        <h5> هل لديك انذار أكاديمي : </h5>
                        <?php if (get_post_meta($order_id,'isWarned',true)): ?>                        
                            <option>نعم</option>
                            <label for="exampleInputEmail1">عدد الانذارات(<?php echo get_post_meta($order_id,'warnNumbers',true); ?>)</label>
                        <?php else: ?>
                            <option>لا</option>
                        <?php endif ?>
                    </div>

                    <?php if ($post_type=='tagawoz'): ?>
                        <div class="form-group">
                            <h5> هل سبق لك الرسوب في المادة التي ترغبين في التجاوز عنها : </h5>
                            <?php if (get_post_meta($order_id,'isFailed',true)): ?>                        
                                <option>نعم</option>
                                <label for="exampleInputEmail1">المادة المطلوب التجاوز عنها كمتطلب: <?php echo get_post_meta($order_id,'passSubject',true); ?></label>
                                <div class="clearfix"></div>
                                <label for="exampleInputEmail1">المواد التي ترغبين باضافاتها بعد التجاوز: </label>
                                <h6>*يسمح فقط باضافة مادتين</h6>
                                <div class="form-group">
                                    <h5><?php echo get_post_meta($order_id,'addSubject1',true); ?></h5>
                                    <h5><?php echo get_post_meta($order_id,'addSubject2',true); ?></h5>
                                </div>
                            <?php else: ?>
                                <option>لا</option>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <?php if ($post_type=='tawseaa'): ?>
                        <div class="form-group">
                            <h5> الشعبة المراد توسعتها:</h5>
                            <label>المادة: <?php echo get_post_meta($order_id,'subject',true); ?> ورمزها: <?php echo get_post_meta($order_id,'subjectCode',true); ?> </label>
                            <br/>
                            <?php if (get_post_meta($order_id,'sho3ba1',true)): ?>
                            <label>الشعبة: <?php echo get_post_meta($order_id,'sho3ba1',true); ?> و الرقم المرجعي: <?php echo get_post_meta($order_id,'referal1',true); ?> </label>
                            <br/>
                            <?php endif ?>
                            <?php if (get_post_meta($order_id,'sho3ba2',true)): ?>
                            <label>الشعبة: <?php echo get_post_meta($order_id,'sho3ba2',true); ?> و الرقم المرجعي: <?php echo get_post_meta($order_id,'referal2',true); ?> </label>
                            <br/>
                            <?php endif ?>
                            <?php if (get_post_meta($order_id,'sho3ba3',true)): ?>
                            <label>الشعبة: <?php echo get_post_meta($order_id,'sho3ba3',true); ?> و الرقم المرجعي: <?php echo get_post_meta($order_id,'referal3',true); ?> </label>
                            <br/>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <?php if (in_array($post_type,['tarbiah','targma'])): ?>
                    <div class="form-group">
                        <label for="academicNotes"> ملاحظات على وضعك الاكاديمي ترغبين من
                            المسجله بأن تكون على علم بها: </label>
                        <?php echo get_post_meta($order_id,'academicNotes',true) ?>
                    </div>
                    <?php endif ?>

                    <div class="form-group">
                        <h5>المرفقات</h5>
                        <ul>
                            <?php if(get_post_meta($order_id,'schoolSchedule',true)): ?>
                                <li><a href="<?php echo get_post_meta($order_id,'schoolSchedule',true) ?>" target="_new"> * الجدول الدراسي </a></li>
                            <?php endif; ?>
                            <?php if(get_post_meta($order_id,'academicRecord',true)): ?>
                                <li><a href="<?php echo get_post_meta($order_id,'academicRecord',true) ?>" target="_new"> * السجل الأكاديمي </a></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <?php if (in_array($post_type,['tawseaa'])): ?>
                    <div class="form-group">
                        <label for="academicNotes"> ملاحظات على وضعك الاكاديمي ترغبين من
                            المسجله بأن تكون على علم بها: </label>
                        <?php echo get_post_meta($order_id,'academicNotes',true) ?>
                    </div>
                    <?php endif ?>
                    <?php if (in_array($post_type,['tawseaa','tarbiah','targma'])): ?>
                    <div class="form-group row">
                        <h6>تنبيهات</h6>
                        <ul>
                            <?php if (in_array($post_type,['tawseaa'])): ?>
                            <li> في حال توفر مقعد شاغر للمادة في شعب أخرى سيتم تسجيلك في الشعب الشاغرة من قبل
                                المرشدة الأكاديمية.</li>
                            <li>* في حال اغلاق جميع الشعب في المادة و عدم توفر شاغر في الشعبة المطلوبة سيتم
                                تسجيل المادة في الشعبة الأقل تكدسا.</li>
                            <?php endif ?>
                            <li>* يتوجب على الطالبة الحضور للجامعة لطباعة جدولها النهائي و التأكد من نزول جميع
                                المواد في الجدول في موعد أقصاه <?php echo get_post_meta($order_id,'scheduleTime',true) ?></li>
                        </ul>

                    </div>
                    <?php endif ?>

                    <?php if($employee&&!$_GET['print']):?>
                    <div class="form-group">
                        <h5>
                            الاجراء المتخذ للحالة من قبل الموظفة :
                        </h5>
                        <div class="custom-control custom-checkbox">
                            <input type="radio" name="requestStatus" value="1" <?php echo $requestStatus==1?'checked':'' ?> class="custom-control-input requestStatus" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1"><?php echo $actions[1] ?></label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="radio" name="requestStatus" value="2" <?php echo $requestStatus==2?'checked':'' ?> class="custom-control-input requestStatus" id="customCheck2">
                            <label class="custom-control-label" for="customCheck1"><?php echo $actions[2] ?></label>
                        </div>
                        <div style="width:100%"></div>
                        <div class="requestStatusInput" style="display:none">
                            <input type="text" style="width:100%" name="requestStatusNotes" value="<?php echo $requestStatusNotes; ?>" />
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="radio" name="requestStatus" value="3" <?php echo $requestStatus==3?'checked':'' ?> class="custom-control-input requestStatus" id="customCheck3">
                            <label class="custom-control-label" for="customCheck1"><?php echo $actions[3] ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="save" class="line-btn no-line" required="">ارسال</button>
                    </div>
                    <?php elseif($actionTaken): ?>
                    <div class="form-group">
                        <h5>
                            الاجراء المتخذ للحالة من قبل الموظفة :
                        </h5>
                        <label><?php echo $actionTaken ?></label>
                    </div>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
$('.requestStatus').bind('change',function(){
    if($(this).val()==2){
        $('.requestStatusInput').show()
        $('.requestStatusInput input').prop('required',true)
    }else{
        $('.requestStatusInput').hide()
        $('.requestStatusInput input').prop('required',false)
    }
})
$('.requestStatus:checked').trigger('change')
</script>


<?php if ($_GET['print']): ?>
<script type="text/javascript">
    window.print()
</script>
<?php endif ?>

<?php get_footer('applications');?>