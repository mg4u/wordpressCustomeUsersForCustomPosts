<?php
/*
Template Name: Exam Page
*/
?>
<?php get_header(); 
extract($_GET);
extract($_POST);
global $current_user;

//else{
	if($_SESSION['done']){
		echo '<div id="data" class="page" align="center">';
		echo $_SESSION['done'];
		echo '</div>';
		$_SESSION['done']=false;
	}else{
	//var_dump($current_user);
		if($exam_id || $finishExam){
			//if(!$current_user->ID){
				//echo '<div id="data" class="page"> <div class="chart-title">من فضلك سجل دخول اولا واذا لو تكن عضو في الموقع يمكنك التسجيل من خلال هذا النموزج</div>';
				//echo '<div style="width:600px;margin-right:100px;margin-top:50px;">'.do_shortcode('[Register role="Subscriber"]').'</div>';	
				//echo '</div>';
			//}else{
				takeExam($exam_id);
			//}
		}elseif(intval($type)){
			userExams($type);
		}else{?>
		<div id="data" class="list-page">
			<div><a class="btn single-line btn-medium"><?php the_title();?></a></div>
			<div><a class="btn single-line" href="?type=1">قدرات عامه</a></div>
			<div><a class="btn single-line" href="?type=2">تحصيلي علمي</a>\<a class="btn single-line" href="?type=3">تحصيلي ادبي</a></div>
				<div ONCLICK="history.go(-1)" style="margin-top:30px;cursor:pointer"><a class="btn btn-medium" style="color:#000" ONCLICK="history.go(-1)">العوده للخلف</a></div>
		</div>
	<?php 
		}
	}
//}
?>

<?php get_footer(); ?>
