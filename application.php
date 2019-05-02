<?php   
/* 
Plugin Name: Applications 
Plugin URI: http://www.alyomhost.com
Description: Applications Plugin for student and employyes 
Author: Mahmoud Gamal
Version: 1.0 
Author URI: http://www.alyomhost.com
*/

/*************************************************************************************/
/* Registering tagawoz post type. */
/**************************************************************************************/
function addCapToUserRol($userRole='',$type)
{
    $userRole->add_cap( 'edit_'.$type ); 
    $userRole->add_cap( 'edit_'.$type.'s' ); 
    $userRole->add_cap( 'edit_other_'.$type.'s' ); 
    $userRole->add_cap( 'publish_'.$type.'s' ); 
    $userRole->add_cap( 'read_'.$type ); 
    $userRole->add_cap( 'read_private_'.$type.'s' ); 
    $userRole->add_cap( 'delete_'.$type );

}
function addApplicationType($props)
{

    $adminRole = get_role( 'administrator' );
    addCapToUserRol($adminRole,$props['type']);

    $studentRole = get_role( 'student' );
    if(!$studentRole){
    	add_role('student', 'طالبة' );
    	$studentRole = get_role( 'student' );
    }
    addCapToUserRol($studentRole,$props['type']);

    $empRole=get_role($props['type'].'_employee');
    if(!$studentRole){
	    add_role($props['type'].'_employee', 'مسؤول '.$props['name']);
    	$empRole=get_role($props['type'].'_employee');
    }
    addCapToUserRol($empRole,$props['type']);


    $labels = array(
        'name' => __($props['name'], 'post type general name'),
        'singular_name' => __($props['type'], 'post type singular name'),
        'all_items' => __('جميع ').$props['name'],
        'view_item' => __('عرض الكل'),
        'add_new_item' => __('اضافة جديد'),
        'add_new' => __('اضافة جديد'),
        'new_item' => __('اضافة جديد'),
        'edit_item' => __('تعديل'),
        'view_item' => __('عرض الكل'),
        'view_item' => __('عرض الكل'),
        'search_items' => __('بحث'),
        'not_found' => __('لا يوجد جديد'),
        'not_found_in_trash' => __('لا  يوجد جديد  '),
        'parent_item_colon' => '',
        'menu_name' => $props['name']
    );
    $args = array(
        'labels' => $labels,
       	'exclude_from_search' => true,  
	    'publicly_queryable'  => false, 
	    'show_ui'             => true,  
	    'show_in_menu'        => true,  
	    'show_in_nav_menus'   => false,
	    'has_archive'         => false,
	    'rewrite'             => false,
        // 'rewrite' => array('slug' => $props['type'], 'with_front' => false), // مهم جداً !
	    // 'capability_type'     => ['student_app',$props['type'].'_employee_app'],
	    'capabilities' => array(
	        'edit_post' => 'edit_'.$props['type'],
	        'edit_posts' => 'edit_'.$props['type'].'s',
	        'edit_others_posts' => 'edit_other_'.$props['type'].'s',
	        'publish_posts' => 'publish_'.$props['type'].'s',
	        'read_post' => 'read_'.$props['type'],
	        'read_private_posts' => 'read_private_'.$props['type'].'s',
	        'delete_post' => 'delete_'.$props['type']
	    ),
	    // as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
	    'map_meta_cap' => true,
        'supports' 			  => array('title')
    );

    register_post_type($props['type'], $args);

	
    require_once $props['type'].'_post_meta.php';
}

function tagawoz()
{
	$props=[
		'name'=>'طلبات التجاوز',
		'type'=>'tagawoz'
	];
	addApplicationType($props);
}

function tawseaa()
{
	$props=[
		'name'=>'طلبات التوسعة',
		'type'=>'tawseaa'
	];
	addApplicationType($props);
}

function tarbiah()
{
	$props=[
		'name'=>'طلبات التربية العملية',
		'type'=>'tarbiah'
	];
	addApplicationType($props);
}

function targma()
{
	$props=[
		'name'=>'طلبات مشاريع الترجمة',
		'type'=>'targma'
	];
	addApplicationType($props);
}


$studentRole = get_role( 'student' );
if(!$studentRole){
	add_role('student', 'طالبة' );
}

add_action('init', 'tagawoz', 20,1);
add_action('init', 'tawseaa', 20,1);
add_action('init', 'tarbiah', 20,1);
add_action('init', 'targma', 20,1);

function load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_media_files' );

// Title place holder
add_filter('enter_title_here', 'my_title_place_holder' , 20 , 2 );
function my_title_place_holder($title , $post){

    if( in_array($post->post_type,['tagawoz','tawseaa','tarbiah','targma']) ){
        $my_title = "الرقم الجامعي";
        return $my_title;
    }

    return $title;

}
//student number
add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

function crf_show_extra_profile_fields( $user ) {
	// var_dump($user);
	if(in_array('student',$user->roles)){
?>
<h3>بياناته الجامعية</h3>

<table class="form-table">
	<tr>
		<th><label for="year_of_birth">الرقم الجامعي</label></th>
		<td>
			<input type="text" required name="universityNumber" id="universityNumber" value="<?php echo esc_html( get_the_author_meta( 'universityNumber', $user->ID ) ); ?>" class="regular-text code">
		</td>
	</tr>
</table>
<?php
	}
}

add_action( 'user_profile_update_errors', 'crf_user_profile_update_errors', 10, 3 );
function crf_user_profile_update_errors( $errors, $update, $user ) {
	if ( $update ) {
		// return;
	}
	// var_dump($user);
	if('student'==$user->role){
		if ( empty( $_POST['universityNumber'] ) ) {
			$errors->add( 'universityNumber_error', __( '<strong>خطأ</strong>: فضلا ادخل الرقم الجامعي.', 'crf' ) );
		}
	}
	
} 

add_action( 'personal_options_update', 'crf_update_profile_fields' );
add_action( 'edit_user_profile_update', 'crf_update_profile_fields' );

function crf_update_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	if ( ! empty( $_POST['universityNumber'] )) {
		update_user_meta( $user_id, 'universityNumber', intval( $_POST['universityNumber'] ) );
	}
}



function wp_no_admin_access()
{
    $redirect = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url( '/' );
    if ( 
        current_user_can( 'student' )
        OR current_user_can( 'tagawoz_employee' )
        OR current_user_can( 'tarbiah_employee' )
        OR current_user_can( 'targma_employee' )
        OR current_user_can( 'tawseaa_employee' )
    )
        exit( wp_redirect( $redirect ) );
}
add_action( 'admin_init', 'wp_no_admin_access', 100 );