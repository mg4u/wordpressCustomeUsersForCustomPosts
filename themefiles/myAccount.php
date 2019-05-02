<?php
/*
Template Name: Exam Page
*/
?>
<?php get_header(); ?>
<?php //breadcrumbs(); ?>

<?php

allExams();

$unit=intval($_GET['unit']);
$type=intval($_GET['type']);

if($unit==1 && $type==1 ){
	$check_field='unit1_prev_exam';
}elseif($unit==1 && $type==2 ){
	$check_field='unit1_final_exam';
}elseif($unit==2 && $type==1 ){
	$check_field='unit2_prev_exam';
}elseif($unit==2 && $type==2 ){
	$check_field='unit2_final_exam';
}

global $wpdb;
$members_exam_result=$wpdb->get_results('SELECT users_score.id FROM users_score WHERE user_id="'.$current_user->id.'" AND `'.$check_field.'` !=0 ');

if(count($_POST)){
	$true_array=array(2,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,1,1,2,2,2,2,2,4,4,3,1,4,4,3,3,3,3,4,3,1,4,2,4,4,4,3,4,4,4,4,3,4);
	$score=0;
	$unit=intval($_GET['unit']);
	$type=intval($_GET['type']);
	if($unit==1 && $type==1 ){
		$check_field='unit1_prev_exam';
	}elseif($unit==1 && $type==2 ){
		$check_field='unit1_final_exam';
	}elseif($unit==2 && $type==1 ){
		$check_field='unit2_prev_exam';
	}elseif($unit==2 && $type==2 ){
		$check_field='unit2_final_exam';
	}
	$user_id=$current_user->id;
	for($i=0;$i<count($true_array);$i++){
		$QusName='ex'.($i+1);
		if(intval($_POST[$QusName])==$true_array[$i]){
			$score += 1;
		}
	}
	$wpdb->get_results('UPDATE users_score SET `'.$check_field.'`="'.$score.'" WHERE user_id="'.$current_user->id.'"');
}
?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="post-text">
  <h2 class="post-title">
    <?php the_title(); ?>
  </h2>
</div>
<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
<?php endwhile; ?>
<?php endif; ?>
<form action="" method="post">

  <table align="center" width="100%" border="0" cellpadding="10" cellspacing="0" dir="rtl">
    <tr>
      <td style="font-family:Arial; font-size:18px; background-color:#2453a9; padding-right:20px; height:20px; color:#FFFFFF" width="80%">نص السؤال</td>
      <td style="font-family:Arial; font-size:18px; background-color:#2453a9; color:#FFFFFF; text-align:center">صواب</td>
      <td style="font-family:Arial; font-size:18px; background-color:#2453a9; color:#FFFFFF; text-align:center">خطا</td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">1- تعد قاعدة بيانات مركز مصادر المعلومات التربوية أحد أنواع المصادر الإلكترونية. </td>
      <td style="text-align:center" ><input name="ex1" type="radio" value="2"/></td>
      <td style="text-align:center"><input name="ex1" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%"> 2- يستخدم العامل and لتوسيع دائرة البحث بهدف الحصول على المصادر المطلوبة بسهولة ويسر . </td>
      <td style="text-align:center" ><input type="radio" name="ex2" value="2"/></td>
      <td style="text-align:center"><input name="ex2" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">3-	قواعد البيانات لا تسمح بإجراء أكثر من عملية في وقت واحد. </td>
      <td style="text-align:center" ><input type="radio" name="ex3" value="2"/></td>
      <td style="text-align:center"><input name="ex3" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">4-	تستخدم أدوات الربط not , and, or للحصول على نتائج بحث أفضل. </td>
      <td style="text-align:center" ><input type="radio" name="ex4" value="2"/></td>
      <td style="text-align:center"><input name="ex4" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">5- عامل الربط OR هو المناسب عند تداخل الموضوعات. </td>
      <td style="text-align:center" ><input type="radio" name="ex5" value="2"/></td>
      <td style="text-align:center"><input name="ex5" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">6- من المستحدثات التى تسمح بالتفاعل بين المتعلم والمحتوى المعروض الفيديو التفاعلى: </td>
      <td style="text-align:center" ><input type="radio" name="ex6" value="2"/></td>
      <td style="text-align:center"><input name="ex6" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">7- عنوان الموقع يبدأ بـ httpأو ftp .</td>
      <td style="text-align:center" ><input type="radio" name="ex7" value="2"/></td>
      <td style="text-align:center"><input name="ex7" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">8- تتميز الشبكات الاجتماعية Network Social بإمكانية إنشاء ملفات شخصية</td>
      <td style="text-align:center" ><input type="radio" name="ex8" value="2"/></td>
      <td style="text-align:center"><input name="ex8" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">9- محرك البحث الواحد له أكثر من واجهة تفاعل.</td>
      <td style="text-align:center" ><input type="radio" name="ex9" value="2"/></td>
      <td style="text-align:center"><input name="ex9" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">10- محركات البحث المتخصصة تهدف إلى تغطية أعمق وبشكل أشمل لموضوع محدد. </td>
      <td style="text-align:center" ><input type="radio" name="ex10" value="2"/></td>
      <td style="text-align:center"><input name="ex10" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">11- الفترة الزمنية أحد عوامل تحديد عدد الدراسات المعروضة المتعلقة بموضوع بحثك. </td>
      <td style="text-align:center" ><input type="radio" name="ex11" value="2"/></td>
      <td style="text-align:center"><input name="ex11" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">12- عملية توظيف المستحدثات التكنولوجية فى التعليم تمر بثلاثة مراحل. </td>
      <td style="text-align:center" ><input type="radio" name="ex12" value="2"/></td>
      <td style="text-align:center"><input name="ex12" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">13-موقع فليكرFlickr بالصور الفوتوغرافية ويسمح بوضع تعليقات عليها.</td>
      <td style="text-align:center" ><input type="radio" name="ex13" value="2"/></td>
      <td style="text-align:center"><input name="ex13" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">14- يتميز الفيس بوك Face book كشبكة اجتماعية عن التويترTwitter خاصية Wall </td>
      <td style="text-align:center" ><input type="radio" name="ex14" value="2"/></td>
      <td style="text-align:center"><input name="ex14" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">15- يعد الكتاب الإلكتروني المنشور على الإنترنت من مصادر المعلومات الإلكترونية .</td>
      <td style="text-align:center" ><input type="radio" name="ex15" value="2"/></td>
      <td style="text-align:center"><input name="ex15" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">16 يمكن استخدام المكتبة الإلكترونية لأكثر من مستخدم للإطلاع علي وعاء معرفي في نفس الوقت. </td>
      <td style="text-align:center" ><input type="radio" name="ex16" value="2"/></td>
      <td style="text-align:center"><input name="ex16" type="radio" value="1" /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">17- يعطي البحث البسيط Basic Search. نتائج أكثر دقة من البحث المتقدم Advanced Search. </td>
      <td style="text-align:center" ><input type="radio" name="ex17" value="2"/></td>
      <td style="text-align:center"><input name="ex17" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">18- يتم استخدام الفترة والمدى الزمني لتوسيع دائرة البحث.</td>
      <td style="text-align:center" ><input type="radio" name="ex18" value="2"/></td>
      <td style="text-align:center"><input name="ex18" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">19- يقتصر البحث فى المكتبات الإلكترونية على اللغة العربية والإنجليزية.</td>
      <td style="text-align:center" ><input type="radio" name="ex19" value="2"/></td>
      <td style="text-align:center"><input name="ex19" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">20- للحصول على نتائج فى مجال الهندسة نستخدم قاعدة بيانات Eric.</td>
      <td style="text-align:center" ><input type="radio" name="ex20" value="2"/></td>
      <td style="text-align:center"><input name="ex20" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">21- ثورة الاتصالات قد أدت إلى ظهور الجانب المادي من المستحدثات التكنولوجية والمتمثل فى الأجهزة الحديثة والأدوات </td>
      <td style="text-align:center" ><input type="radio" name="ex21" value="2" /></td>
      <td style="text-align:center"><input name="ex21" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">22- من الخدمات الرئيسية للإنترنت خدمة البحث عن المعلومات من مصادرها الإلكترونية.</td>
      <td style="text-align:center" ><input type="radio" name="ex22" value="2" /></td>
      <td style="text-align:center"><input name="ex22" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">23- تتميز المستحدثات التكنولوجية بالمرونة والكونية .</td>
      <td style="text-align:center" ><input type="radio" name="ex23" value="2" /></td>
      <td style="text-align:center"><input name="ex23" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">24 - تعد شبكة الفيس بوك Facebookمن أبرز الشبكات الاجتماعية.</td>
      <td style="text-align:center" ><input type="radio" name="ex24" value="2" /></td>
      <td style="text-align:center"><input name="ex24" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">25- تتميز تطبيقات الويب 2.0 بأنها جعلت لمستخدم الإنترنت دور كبير في إثراء المحتوى وإنتاجه.</td>
      <td style="text-align:center" ><input type="radio" name="ex25" value="2" /></td>
      <td style="text-align:center"><input name="ex25" type="radio" value="1"/></td>
    </tr>
    <tr>
      <td colspan="3" style="font-family:Arial; font-size:18px; background-color:#2453a9; padding-right:20px; height:20px; color:#FFFFFF">الاختيار من متعدد</td>
    </tr>
    <tr>
      <td class="tablerawb1" style="font-size:17px">26- يمكن إضافة بعض البرمجيات التي تساعد الطالب من خلال نظام الفيس بوك مثل.</td>
    </tr>
    
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex26" value="1"/>
        &nbsp;&nbsp;إضافة بطاقة ذاكرة مدمجة ( Flash Card ) <br />
        <input type="radio" name="ex26" value="2"/>
        &nbsp;&nbsp;إضافة مقررات (Courses) <br />
        <input name="ex26" type="radio" value="3" />
        &nbsp;&nbsp;إضافة خاصية البحث ( Do Research for me) <br />
        <input type="radio" name="ex26" value="4" />
        &nbsp;&nbsp;إضافة تطبيق Engrade <br /></td>
    </tr>
    <tr>
      <td class="tablerawb1" style="font-size:17px">27- توفر قواعد البيانات الببليوجرافية.</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex27" value="1"/>
        &nbsp;&nbsp;نص الموضوع كاملا <br />
        <input type="radio" name="ex27" value="2"/>
        &nbsp;&nbsp;خلاصة الموضوع <br />
        <input name="ex27" type="radio" value="3"/>
        &nbsp;&nbsp;حقائق أو إحصائيات وأرقام <br />
        <input type="radio" name="ex27" value="4" />
        &nbsp;&nbsp;البيانات الأساسية لمصادر المعلومات <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">28- يتميز الويب2.0 عن الويب 1.0 بــ.</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex28" value="1"/>
        &nbsp;&nbsp;مواقع شخصية <br />
        <input type="radio" name="ex28" value="2"/>
        &nbsp;&nbsp;مواقع محتويات <br />
        <input type="radio" name="ex28" value="3"/>
        &nbsp;&nbsp;شبكات اجتماعية <br />
        <input name="ex28" type="radio" value="4" />
        &nbsp;&nbsp;برمجيات بسيطة <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">29 - من مميزات المدونة الإلكترونية. </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex29" value="1"/>
        &nbsp;&nbsp;أداة تقييم مستمر لتعلم الطالب <br />
        <input type="radio" name="ex29" value="2"/>
        &nbsp;&nbsp;تبسيط عملية تحرير المحتوى<br />
        <input type="radio" name="ex29" value="3"/>
        &nbsp;&nbsp;تستخدم أوامر بسيطة لتنسيق محتوياتها <br />
        <input name="ex29" type="radio" value="4"/>
        &nbsp;&nbsp;سهولة إنشاء الصفحات والروابط <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">30- يعتمد أسلوب البحث بمحلل الروابط على: </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex30" value="1"/>
        &nbsp;&nbsp; Open URL<br />
        <input type="radio" name="ex30" value="2"/>
        &nbsp;&nbsp;Browse<br />
        <input type="radio" name="ex30" value="3"/>
        &nbsp;&nbsp; (---------*) <br />
        <input name="ex30" type="radio" value="4"/>
        &nbsp;&nbsp; and- or- not <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">31- من الشبكات الاجتماعية Network Social التي أفرزتها تطبيقات الويب 2.0 عدا :</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex31" value="1"/>
        &nbsp;&nbsp;الفيس بوك Facebook <br />
        <input type="radio" name="ex31" value="2"/>
        &nbsp;&nbsp;تويتر Twitter<br />
        <input type="radio" name="ex31" value="3"/>
        &nbsp;&nbsp; يوتيوب You Tube <br />
        <input name="ex31" type="radio" value="4"/>
        &nbsp;&nbsp;البريد الإلكتروني E- maile <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">32- من تطبيقات الويب 2.0 :</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex32" value="1"/>
        &nbsp;&nbsp;البريد الإلكتروني <br />
        <input type="radio" name="ex32" value="2"/>
        &nbsp;&nbsp;المنتدى <br />
        <input type="radio" name="ex32" value="3"/>
        &nbsp;&nbsp;الويكي <br />
        <input name="ex32" type="radio" value="4" />
        &nbsp;&nbsp;الشات <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">33- يتم استخدام البحث المتقدم للحصول على نتائج:</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex33" value="1"/>
        &nbsp;&nbsp;أكثر<br />
        <input type="radio" name="ex33" value="2"/>
        &nbsp;&nbsp;أقل<br />
        <input type="radio" name="ex33" value="3"/>
        &nbsp;&nbsp;محددة<br />
        <input name="ex33" type="radio" value="4"/>
        &nbsp;&nbsp;متشابهة<br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">34-	 يساعد على الدراسة الشخصية والتعلم باستخدام البطاقات التعليمية الفلاشية المتوفرة في المصادر الإلكترونية تطبيق:</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex34" value="1"/>
        &nbsp;&nbsp;تطبيق Feedly.<br />
        <input type="radio" name="ex34" value="2"/>
        &nbsp;&nbsp;تطبيق Edmodo<br />
        <input type="radio" name="ex34" value="3" />
        &nbsp;&nbsp;تطبيق Cramberry<br />
        <input name="ex34" type="radio" value="4"/>
        &nbsp;&nbsp; تطبيق Nota <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">35-	يتم تضييق نطاق البحث من خلال استخدام معامل</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex35" value="1"/>
        &nbsp;&nbsp;OR<br />
        <input type="radio" name="ex35" value="2"/>
        &nbsp;&nbsp;Not <br />
        <input type="radio" name="ex35" value="3"/>
        &nbsp;&nbsp;AND <br />
        <input name="ex35" type="radio" value="4"/>
        &nbsp;&nbsp;البحث البسيط.<br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">36-	تتكون واجهات البحث فى المكتبات الإلكترونية من </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex36" value="1"/>
        &nbsp;&nbsp;البحث البسيط.<br />
        <input type="radio" name="ex36" value="2"/>
        &nbsp;&nbsp;الدوريات<br />
        <input type="radio" name="ex36" value="3"/>
        &nbsp;&nbsp;الكتب الإلكترونية <br />
        <input name="ex36" type="radio" value="4"/>
        &nbsp;&nbsp;جميع ما سبق <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">37-	يتم البحث بالمؤلف لاسترجاع.</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex37" value="1"/>
        &nbsp;&nbsp;مؤلف محدد. <br />
        <input type="radio" name="ex37" value="2"/>
        &nbsp;&nbsp;كل أعماله.<br />
        <input type="radio" name="ex37" value="3"/>
        &nbsp;&nbsp;معلومات عنه. <br />
        <input name="ex37" type="radio" value="4" />
        &nbsp;&nbsp;لاشيء مما سبق.<br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">38-	يتم اللجوء لاستخدام الويكي بدلا من المدونة عندما نحتاج إلى: </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex38" value="1" />
        &nbsp;&nbsp;إنشاء صفحة جديدة. <br />
        <input type="radio" name="ex38" value="2"/>
        &nbsp;&nbsp;ملفات إنجاز الطلاب<br />
        <input type="radio" name="ex38" value="3"/>
        &nbsp;&nbsp;الإدارة الصفيّة. <br />
        <input name="ex38" type="radio" value="4" />
        &nbsp;&nbsp;ثبات الترتيب الزمني. <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">39-	يمكن البحث فى المكتبات الإلكترونية من خلال </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex39" value="1"/>
        &nbsp;&nbsp;الكلمة <br />
        <input type="radio" name="ex39" value="2"/>
        &nbsp;&nbsp;الجملة والمؤلف<br />
        <input type="radio" name="ex39" value="3"/>
        &nbsp;&nbsp;المؤلف والكلمة <br />
        <input name="ex39" type="radio" value="4"/>
        &nbsp;&nbsp;الكلمة والجملة والمؤلف.<br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">40-	يتم استخدام البحث بالمترادفات عند الحصول على نتائج</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex40" value="1"/>
        &nbsp;&nbsp;كثيرة <br />
        <input type="radio" name="ex40" value="2" />
        &nbsp;&nbsp;قليلة<br />
        <input type="radio" name="ex40" value="3"/>
        &nbsp;&nbsp;متشابهة<br />
        <input name="ex40" type="radio" value="4" />
        &nbsp;&nbsp;لاشيء مما سبق.<br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">41- يتم ترجمة كلمة أو جملة من خلال موقع. </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex41" value="1"/>
        &nbsp;&nbsp;Google.com <br />
        <input type="radio" name="ex41" value="2"/>
        &nbsp;&nbsp;AltaVist.com<br />
        <input type="radio" name="ex41" value="3"/>
        &nbsp;&nbsp;Trejem.com . <br />
        <input name="ex41" type="radio" value="4"/>
        &nbsp;&nbsp;Tarjim.com<br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">42- تتميز قواعد البيانات بما يلي ماعدا : </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex42" value="1"/>
        &nbsp;&nbsp;تزامن عمليات البحث <br />
        <input type="radio" name="ex42" value="2"/>
        &nbsp;&nbsp;توفير مصادر للبحث من مداخل كثيرة <br />
        <input type="radio" name="ex42" value="3"/>
        &nbsp;&nbsp;البحث بالعنوان <br />
        <input name="ex42" type="radio" value="4"/>
        &nbsp;&nbsp;إجراء عملية البحث البسيطة فقط .<br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">43- يفضل استخدام البحث المتقدمadvanced Searchلإمكانية . </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex43" value="1"/>
        &nbsp;&nbsp;البحث بكلمة واحدة <br />
        <input type="radio" name="ex43" value="2"/>
        &nbsp;&nbsp;البحث بجملة . <br />
        <input type="radio" name="ex43" value="3"/>
        &nbsp;&nbsp;البحث بالمؤلف <br />
        <input name="ex43" type="radio" value="4"/>
        &nbsp;&nbsp;البحث الأكثر تحديدا <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">44- للحصول على نصوص كاملة فى البحث المتقدم بمحرك البحث لابد من ضبط . </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex44" value="1"/>
        &nbsp;&nbsp;اللغة <br />
        <input type="radio" name="ex44" value="2"/>
        &nbsp;&nbsp;عدد النتائج المعروضة فى الشاشة الواحدة . <br />
        <input type="radio" name="ex44" value="3" />
        &nbsp;&nbsp;نوع الملف . <br />
        <input name="ex44" type="radio" value="4"/>
        &nbsp;&nbsp;نوع الملف . <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">45- من أنواع البحث فى الإنترنت البحث. </td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex45" value="1"/>
        &nbsp;&nbsp;بصورة <br />
        <input type="radio" name="ex45" value="2"/>
        &nbsp;&nbsp;بكلمة <br />
        <input type="radio" name="ex45" value="3"/>
        &nbsp;&nbsp;برمز <br />
        <input name="ex45" type="radio" value="4"/>
        &nbsp;&nbsp;برقم 2 , 3<br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">46- من خصائص الفيس بوك Facebook :</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex46" value="1"/>
        &nbsp;&nbsp;خاصية Wall . <br />
        <input type="radio" name="ex46" value="2"/>
        &nbsp;&nbsp; خاصية Pokes. <br />
        <input type="radio" name="ex46" value="3"/>
        &nbsp;&nbsp;خاصية Status <br />
        <input name="ex46" type="radio" value="4"/>
        &nbsp;&nbsp;جميع ما سبق <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">47- من التطبيقات الجديدة للويب2.0 ( (web 2.0التي تركز على المتعلم:</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex47" value="1"/>
        &nbsp;&nbsp;تطبيق podio <br />
        <input type="radio" name="ex47" value="2"/>
        &nbsp;&nbsp;تطبيق Syllabontes. <br />
        <input type="radio" name="ex47" value="3"/>
        &nbsp;&nbsp;تطبيق الشات. <br />
        <input name="ex47" type="radio" value="4"/>
        &nbsp;&nbsp;تطبيق 1 , 2 فقط. <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">48- من مميزات الويكي wiki :</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex48" value="1"/>
        &nbsp;&nbsp;تبسيط عملية تحرير المحتوى <br />
        <input type="radio" name="ex48" value="2"/>
        &nbsp;&nbsp;سهولة إنشاء الصفحات. <br />
        <input type="radio" name="ex48" value="3"/>
        &nbsp;&nbsp;حفظ سجل لتاريخ الصفحات. <br />
        <input name="ex48" type="radio" value="4"/>
        &nbsp;&nbsp;جميع ما سبق <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">49- تتميز تطبيقات الويب 2.0 بالمميزات التالية ماعدا:</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex49" value="1"/>
        &nbsp;&nbsp;وجود شبكات اجتماعية <br />
        <input type="radio" name="ex49" value="2"/>
        &nbsp;&nbsp;مواقع استضافة و مشاركة ملفات<br />
        <input type="radio" name="ex49" value="3"/>
        &nbsp;&nbsp;تحتوي على مواقع محتويات <br />
        <input name="ex49" type="radio" value="4" />
        &nbsp;&nbsp;وجود مدونات. <br /></td>
    </tr>
    <tr>
      <td style="font-size:15px" width="80%">50- من الموارد الرئيسية للإنترنت :(Resources )</td>
    </tr>
    <tr>
      <td class="tablerawg1" style="font-size:17px; direction:rtl; padding-right:10px"><input type="radio" name="ex50" value="1"/>
        &nbsp;&nbsp; الويب (Web ) <br />
        <input type="radio" name="ex50" value="2"/>
        &nbsp;&nbsp;القوائم البريدية Mailing Lists.<br />
        <input type="radio" name="ex50" value="3" />
        &nbsp;&nbsp;المجلات الإلكترونية <br />
        <input name="ex50" type="radio" value="4"/>
        &nbsp;&nbsp;لوحة النشر الإلكترونية ( E- Bord)<br /></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" name="submit" class="formsearch" value=" انهاء" style="float:left"/></td>
    </tr>
  </table>
</form>
<?php get_footer(); ?>
