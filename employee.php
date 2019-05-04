<?php session_start();
/*
Template Name: لوحة الموظفة
 * Template Post Type: page

*/

get_header('applications');
$studentPageId=33;
$employeePageId=46;
$detailsPageId=35;

$user = wp_get_current_user();
$roles = ( array ) $user->roles;
array_multisort($roles);

if($roles[0]=='student'){
    // var_dump('redirect to student profile');
    wp_redirect(get_permalink($studentPageId));
}

$user_post_type=str_replace('_employee', '', $roles[0]);
// var_dump($user_post_type);exit;

if($_GET['action']=='delete'&&(int)$_GET['order_id']){
    $order_id=(int)$_GET['order_id'];
    //check owner 
    $post_type = get_post_type( $order_id );
    if($user_post_type==$post_type){
        // var_dump($post_type);exit;
        //delete
        wp_trash_post( $order_id );
        
        $_SESSION['message'] = 'تم الحذف بنجاح';
    }else{
        $_SESSION['error'] = 'ليس لديك صلاحية الحذف';
    }
    wp_redirect(get_permalink($employeePageId));
}

$args = array(
    'post_type'=> $user_post_type,
    'posts_per_page'=>-1,
    'meta_query' => array(
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
    'post_type'=> $user_post_type,
    'posts_per_page'=>-1,
    'meta_query' => array(
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
                                            <th scope="col">الطلبات بحسب الطلب الجامعي</th>
                                            <th scope="col">حالة الطلب</th>
                                            <th scope="col">تاريخ التقديم</th>
                                            <th scope="col">اجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($processingOrders as $key => $row): ?>
                                        <?php //var_dump($row); ?>
                                        <tr>
                                            <th scope="row"><a href="<?php echo esc_url( add_query_arg( 'order_id', $row->ID,get_permalink( $detailsPageId ) ) ) ?>"><?php echo get_the_title($row->ID); ?></a></th>
                                            <td>تحت الاجراء</td>
                                            <td><?php echo get_the_date('', $row->ID); ?></td>
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
                                            <th scope="row"><a href="<?php echo esc_url( add_query_arg( 'order_id', $row->ID,get_permalink( $detailsPageId ) ) ) ?>"><?php echo get_the_title($row->ID); ?></a></th>
                                            <td>تم الانتهاء منه</td>
                                            <td><?php echo get_the_date('', $row->ID); ?></td>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer('applications');?>