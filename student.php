<?php session_start();
/*
Template Name: بروفايل الطالبة
 * Template Post Type: page

*/
get_header('applications');
$studentPageId=33;
$employeePageId=46;
$detailsPageId=35;
$tagawozPageId=37;
$tawseaaPageId=39;
$tarbiahPageId=41;
$targmaPageId=44;

$user = wp_get_current_user();
$roles = ( array ) $user->roles;
array_multisort($roles);
if(strpos(' '.$roles[0],'_employee')){
    wp_redirect(get_permalink($employeePageId));
}

if($_GET['action']=='delete'&&(int)$_GET['order_id']){
    $order_id=(int)$_GET['order_id'];
    //check owner 
    $orderStudent = get_post_meta($order_id,'student',true);
    if(get_current_user_id()==$orderStudent){
        // var_dump($orderStudent);exit;
        //delete
        wp_trash_post( $order_id );
        
        $_SESSION['message'] = 'تم الحذف بنجاح';
    }else{
        $_SESSION['error'] = 'ليس لديك صلاحية الحذف';
    }
    wp_redirect(get_permalink($studentPageId));
}

$args = array(
    'post_type'=> ['tagawoz','tawseaa','tarbiah','targma'],
    'posts_per_page'=>-1,
    'meta_query' => array(
        array(
            'key' => 'student',
            'value' => get_current_user_id(),
            'compare' => '=',
        ),
        array(
            'key' => 'requestStatus',
            'value' => -1,
            'compare' => '=',
        )
    )
);
$processingOrders=get_posts($args);
// var_dump($processisngOrders);

$args = array(
    'post_type'=> ['tagawoz','tawseaa','tarbiah','targma'],
    'posts_per_page'=>-1,
    'meta_query' => array(
        array(
            'key' => 'student',
            'value' => get_current_user_id(),
            'compare' => '=',
        ),
        array(
            'key' => 'requestStatus',
            'value' => -1,
            'compare' => '!=',
        )
    )
);
$doneOrders=get_posts($args);
// var_dump($doneOrders);
$postTypesNames=[
    'tagawoz'=>'طلب تجاوز',
    'tawseaa'=>'طلب توسعة',
    'tarbiah'=>'طلب تربية عملية',
    'targma'=>'طلب مشروع ترجمة',
];
$tagawozURL=get_permalink($tagawozPageId);
$tawseaaURL=get_permalink($tawseaaPageId);
$tarbiahURL=get_permalink($tarbiahPageId);
$targmaURL=get_permalink($targmaPageId);
// var_dump($tagawozPageId,$tagawozURL,$tawseaaURL);

$args = array(
    'post_type'=> ['tagawoz','tawseaa','tarbiah','targma'],
    'meta_query' => array(
        array(
            'key' => 'student',
            'value' => get_current_user_id(),
            'compare' => '=',
        ),
    )
);
$checkOrdersTypes=get_posts($args);
foreach ($checkOrdersTypes as $key => $row) {
    $post_type=$row->post_type;
    if('tagawoz'==$post_type){
        $tagawozURL='#';
    }
    if('tawseaa'==$post_type){
        $tawseaaURL='#';
    }
    if('tarbiah'==$post_type){
        $tarbiahURL='#';
    }
    if('targma'==$post_type){
        $targmaURL='#';
    }
}

?>
<section class="pages-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4> الصفحة الشخصية</h4>
            </div>
        </div>
    </div>
</section>
<div class="profile-page">
    <div class="container">
        <div class="profile-tab">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="nav flex-column nav-pills profile-list-menu" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="home-tab" data-toggle="pill" href="#home" role="tab"
                            aria-controls="home" aria-selected="true"> طلبات تحت الاجراء
                        </a>
                        <a class="nav-link" id="profile-tab" data-toggle="pill" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false"> طلبات منجزة
                        </a>
                        <a class="nav-link" href="<?php echo wp_logout_url( get_permalink($loginPageId) ); ?>" role="tab" > تسجيل خروج</a>

                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="tab-content" id="v-pills-tabContent ">
                        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h3>مرحبا : <span><?php echo $user->display_name ?></span></h3>
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="<?php echo $tagawozURL ?>" class="line-btn no-line">التجاوز</a>
                                </li>
                                <li class="list-inline-item"><a href="<?php echo $tawseaaURL ?>" class="line-btn no-line">التوسعة</a></li>
                                <li class="list-inline-item"><a href="<?php echo $tarbiahURL ?>" class="line-btn no-line">التربية العملية</a></li>
                                <li class="list-inline-item"><a href="<?php echo $targmaURL ?>" class="line-btn no-line">مشروع الترجمة</a></li>
                            </ul>
                            <h6>ملاحظة : يتيح النظام للطالبة تقديم طلب لمرة واحدة فقط لكل من الخدمات السابقة</h6>
                            <div class="clearfix"></div>
                            <?php if ($_SESSION['message']): ?>
                                <div class="alert alert-success"><?php echo $_SESSION['message'] ?></div>
                            <?php unset($_SESSION['message']);
                            endif ?>
                            <div class="clearfix"></div>
                            <?php if ($_SESSION['error']): ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['error'] ?></div>
                            <?php unset($_SESSION['error']);
                            endif ?>
                            <div class="clearfix"></div>
                            <div class="table-responsive table-cons">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <!-- <th scope="col">الطلبات بحسب الطلب الجامعي</th> -->
                                            <th scope="col">الطلب</th>
                                            <th scope="col">حالة الطلب</th>
                                            <th scope="col">تاريخ التقديم</th>
                                            <th scope="col">اجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($processingOrders as $key => $row): ?>
                                        <?php //var_dump($row); ?>
                                        <tr>
                                            <th scope="row"><?php echo $postTypesNames[$row->post_type] ?></th>
                                            <td>تحت الاجراء</td>
                                            <td><?php echo get_the_time('Y-m-d', $row->ID); ?></td>
                                            <td><a href="<?php echo esc_url( add_query_arg( 'order_id', $row->ID,get_permalink( $detailsPageId ) ) ) ?>" class="fas fa-eye" title="" data-toggle="tooltip" data-original-title="مشاهدة"></a>
                                                <a href="<?php echo esc_url( add_query_arg( ['order_id'=> $row->ID,'print'=>true],get_permalink( $detailsPageId ) ) ) ?>" target="_new" class="fas fa-print" title="" data-toggle="tooltip"
                                                    data-original-title="طباعة"></a>
                                                <a href="<?php echo esc_url( add_query_arg( ['action'=>'delete','order_id'=> $row->ID] ) ) ?>" onclick="return confirm('هل انت واثق من انك تريد الحذف');" class="fas fa-trash" title="" data-toggle="tooltip"
                                                    data-original-title="حذف"></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <h3>مرحبا : <span><?php echo $user->display_name ?></span></h3>
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="<?php echo $tagawozURL ?>" class="line-btn no-line">التجاوز</a>
                                </li>
                                <li class="list-inline-item"><a href="<?php echo $tawseaaURL ?>" class="line-btn no-line">التوسعة</a></li>
                                <li class="list-inline-item"><a href="<?php echo $tarbiahURL ?>" class="line-btn no-line">التربية العملية</a></li>
                                <li class="list-inline-item"><a href="<?php echo $targmaURL ?>" class="line-btn no-line">مشروع الترجمة</a></li>
                            </ul>
                            <h6>ملاحظة : يتيح النظام للطالبة تقديم طلب لمرة واحدة فقط لكل من الخدمات السابقة
                                </h6>
                            <div class="clearfix"></div>
                            <?php if ($_SESSION['message']): ?>
                                <div class="alert alert-success"><?php echo $_SESSION['message'] ?></div>
                            <?php unset($_SESSION['message']);
                            endif ?>
                            <div class="clearfix"></div>
                            <?php if ($_SESSION['error']): ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['error'] ?></div>
                            <?php unset($_SESSION['error']);
                            endif ?>
                            <div class="clearfix"></div>

                            <div class="table-responsive table-cons">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">الطلبات</th>
                                            <th scope="col">حالة الطلب</th>
                                            <th scope="col">تاريخ التقديم</th>
                                            <th scope="col">اجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($doneOrders as $key => $row): ?>
                                        <?php //var_dump($row); ?>
                                        <tr>
                                            <th scope="row"><?php echo $postTypesNames[$row->post_type] ?></th>
                                            <td>تم الانتهاء منه</td>
                                            <td><?php echo get_the_time('Y-m-d', $row->ID); ?></td>
                                            <td><a href="<?php echo esc_url( add_query_arg( 'order_id', $row->ID,get_permalink( $detailsPageId ) ) ) ?>" class="fas fa-eye" title="" data-toggle="tooltip" data-original-title="مشاهدة"></a>
                                                <a href="<?php echo esc_url( add_query_arg( ['order_id'=> $row->ID,'print'=>true],get_permalink( $detailsPageId ) ) ) ?>" target="_new" class="fas fa-print" title="" data-toggle="tooltip" data-original-title="طباعة"></a>
                                                <a href="<?php echo esc_url( add_query_arg( ['action'=>'delete','order_id'=> $row->ID] ) ) ?>" onclick="return confirm('هل انت واثق من انك تريد الحذف');" class="fas fa-trash" title="" data-toggle="tooltip"
                                                    data-original-title="حذف"></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer('applications');?>