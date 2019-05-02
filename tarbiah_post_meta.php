<?php 

add_action( 'add_meta_boxes', 'tarbiah_featured_meta' );
function tarbiah_featured_meta() {
    global $post;
    // var_dump($post);
    add_meta_box( 'phoneNumber', 'رقم الجوال', 'tarbiah_text_form', 'tarbiah', 'normal', 'low' );
    add_meta_box( 'email', 'البريد الالكتروني', 'tarbiah_text_form', 'tarbiah', 'normal', 'low' );
    add_meta_box( 'gpa', 'المعدل التراكمي', 'tarbiah_text_form', 'tarbiah', 'normal', 'low' );

    add_meta_box( 'student', ' الطالبة ', 'tarbiah_student_form', 'tarbiah', 'normal', 'low' );
    add_meta_box( 'warning', ' التحقق من الانذارات ', 'tarbiah_warning_form', 'tarbiah', 'normal', 'low' );
    
    add_meta_box( 'schoolSchedule', ' صورة الجدول الدراسي المسجل لك هذا الفصل ', 'tarbiah_attach_form', 'tarbiah', 'normal', 'low' );
    add_meta_box( 'academicRecord', ' صورة من السجل الأكاديمي كاملا ', 'tarbiah_attach_form', 'tarbiah', 'normal', 'low' );
    
    add_meta_box( 'academicNotes', 'اضافة ملاحظات على الوضع الاكاديمي', 'tarbiah_text_area_form', 'tarbiah', 'normal', 'low' );
    add_meta_box( 'scheduleTime', 'اقصى موعد لاستلام الجدول', 'tarbiah_text_form', 'tarbiah', 'normal', 'low' );

    add_meta_box( 'requestStatus', ' الاجراءات المتخذه للحاله من قبل الموظفة ', 'tarbiah_requestStatus_form', 'tarbiah', 'normal', 'low' );
}

add_action( 'save_post', 'save_tarbiah_featured_meta' );

function save_tarbiah_featured_meta( $post_ID ) {
    global $post;
    if(in_array($post->post_type,['tarbiah','tarbiah','targma'])) {
        if (isset( $_POST ) ) {

            update_post_meta( $post_ID, 'phoneNumber',$_POST['phoneNumber']);
            update_post_meta( $post_ID, 'email',$_POST['email']);
            update_post_meta( $post_ID, 'student',$_POST['student']);
            update_post_meta( $post_ID, 'gpa',$_POST['gpa']);

            update_post_meta( $post_ID, 'isWarned',$_POST['isWarned']);
            if (!$_POST['isWarned']) {
            	$_POST['warnNumbers']='';
            }
            update_post_meta( $post_ID, 'warnNumbers',$_POST['warnNumbers']);

            update_post_meta( $post_ID, 'academicNotes',$_POST['academicNotes']);
            update_post_meta( $post_ID, 'scheduleTime',$_POST['scheduleTime']);

            update_post_meta( $post_ID, 'schoolSchedule',$_POST['schoolSchedule']);
            update_post_meta( $post_ID, 'academicRecord',$_POST['academicRecord']);
    		if($_POST['requestStatus']){
            	update_post_meta( $post_ID, 'requestStatus',$_POST['requestStatus']);
	            if ($_POST['requestStatus']!=2) {
	            	$_POST['requestStatusNotes']='';
	            }
            	update_post_meta( $post_ID, 'requestStatusNotes',$_POST['requestStatusNotes']);
    		}else{
            	update_post_meta( $post_ID, 'requestStatus',-1);
            	update_post_meta( $post_ID, 'requestStatusNotes','');
    		}
        }
    }
}

function tarbiah_text_form( $post,$args ) {
    $fieldName=$args['id'];
    $fieldValue = get_post_meta($post->ID,$fieldName,true);
    ?>
    <input type="text" style="width:100%" name="<?php echo $fieldName ?>" value="<?php echo esc_attr( $fieldValue); ?>" />    
    <?php
}

function tarbiah_text_area_form( $post,$args ) {
	$fieldName=$args['id'];
    $fieldValue = get_post_meta($post->ID,$fieldName,true);
    ?>
    <textarea rows="3" style="width:100%" name="<?php echo $fieldName ?>"><?php echo esc_attr( $fieldValue); ?></textarea>    
    <?php
}

function tarbiah_student_form( $post ) {
	$args = array(
	    'role'    => 'student',
	    'orderby' => 'user_nicename',
	    'order'   => 'ASC'
	);
	$users = get_users( $args );
	// var_dump($users);

    $student = get_post_meta($post->ID,'student',true);
    ?>
    <select style="width:100%" name="student">
    	<option value="0">---</option>
    	<?php foreach ( $users as $user ) { ?>
        	<option value="<?php echo $user->ID ?>" <?php echo $student==$user->ID?"selected":''; ?>
        		email="<?php echo $user->user_email ; ?>" 
        		rel="<?php echo get_the_author_meta( 'universityNumber', $user->ID ); ?>" 
        	><?php echo $user->display_name ?></option>
        <?php } ?>
    </select>
<?php 
}

function tarbiah_warning_form( $post,$args ) {
	$fieldName=$args['id'];
    $isWarned = get_post_meta($post->ID,'isWarned',true);
    $warnNumbers = get_post_meta($post->ID,'warnNumbers',true);
    ?>
    <label>هل يوجد انذار أكاديمي</label>
    <select style="width:100%" name="isWarned" class="isWarned">
        <option value="0" <?php echo $isWarned==0?"selected":''; ?>>لا</option>
    	<option value="1" <?php echo $isWarned==1?"selected":''; ?>>نعم</option>
    </select>
    <div class="warnNumbers" style="display:none">
    	<label>عدد الانذارات</label>
	    <input type="number" style="width:100%" name="warnNumbers" value="<?php echo intval( $warnNumbers); ?>" />
	</div>
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
    <?php
}

function tarbiah_requestStatus_form( $post,$args ) {
    $requestStatus = get_post_meta($post->ID,'requestStatus',true);
    $requestStatusNotes = get_post_meta($post->ID,'requestStatusNotes',true);
    ?>
    <div style="width:100%">
	    <label><input type="radio" value="1" <?php echo $requestStatus==1?'checked':'' ?> class="requestStatus" name="requestStatus" /> تم قبول الحالة الرجاء القبول والتسجيللا لاضافتها </label>
	    <div style="width:100%"></div>
	    <label><input type="radio" value="2" <?php echo $requestStatus==2?'checked':'' ?> class="requestStatus" name="requestStatus" /> تم رفض الحالة بسبب </label>
	    <div style="width:100%"></div>
	    <div class="requestStatusInput" style="display:none">
		    <input type="text" style="width:100%" name="requestStatusNotes" value="<?php echo $requestStatusNotes; ?>" />
		</div>
	    <div style="width:100%"></div>
	    <label><input type="radio" value="3" <?php echo $requestStatus==3?'checked':'' ?> class="requestStatus" name="requestStatus" /> يلزم مراجعة قسم التجاوز بمكتب الارشاد الأكاديمي </label>
	</div>
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
    <?php
}

function tarbiah_attach_form( $post,$args ) {
	error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
	// var_dump($args['id']);
	$fieldName=$args['id'];
    // var_dump($post->post_type);
    $fieldValue = get_post_meta($post->ID,$fieldName,true);
    ?>
    <div class="image_upload">
        <input type="hidden" class="qus_img" name="<?php echo $fieldName ?>"  value="<?php echo $fieldValue?>" />
        <input type="button" class="button upload_logo_button" value="الصوره" />
        <img src="<?php echo $fieldValue?>" width="100">
    </div>
    
    <?php
	wp_register_script( 'image_upload', plugins_url('applications'). '/js/image_upload.js', array('jquery','media-upload','thickbox') );
	// wp_register_script( 'image_upload', get_template_directory_uri(). '/js/image_upload.js', array('jquery','media-upload','thickbox') );
    wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('image_upload');
}

?>