jQuery(document).ready(function($){
	var frame;

	// $('.upload_logo_button').click(function() {
	$('body').delegate('.upload_logo_button','click',function(){
		var metaBox = $(this).parent(), // Your meta box id here
		addImgLink = metaBox.find('.upload_logo_button'),
		// delImgLink = metaBox.find( '.delete-custom-img'),
		imgIdInput = metaBox.find( '.custom-img-id' );
      	imgContainer = metaBox,
		// alert('asasasas');
		//type = image,audio,video,file. If we write it wrong, nothing will appear. type = file by default
		// Google: 'ImageGroup tb_show thickbox':
		//The optional imageGroup parameter can also be used to pass in an array of images for a single or multiple image slide show gallery.
		// The problem is that inserting a gallery needs an associated post to work
		$('.qus_img').attr('id','');
		$(this).parent().find('.qus_img').attr('id','qus_img');

		/*for old thick box*/
		// tb_show('ادراج صورة ', 'media-upload.php?type=image&amp;TB_iframe=true', false);
		
		//new thick bbox
		frame= wp.media({
	      title: 'اختر صورة',
	      button: {
	        text: 'استخدم تلك الصورة'
	      },
	      multiple: false  // Set to true to allow multiple files to be selected
	    });
	 	// When an image is selected in the media frame...
	    frame.on( 'select', function() {
	      
	      // Get media attachment details from the frame state
	      var attachment = frame.state().get('selection').first().toJSON();
	      console.log(attachment);
	      // Send the attachment URL to our custom image input field.
	      imgContainer.find('img').remove();
	      imgContainer.append( '<img src="'+attachment.url+'" alt="" style="width:100px"/>' );
	      $('#qus_img').val(attachment.url);
	      // Send the attachment id to our hidden input
	      // imgIdInput.val( attachment.id );

	    });

	    // Finally, open the modal on click
	    frame.open();
		return false;
	});
	
	/*for old thick box*/
	window.send_to_editor = function(html) {
		// html returns a link like this:
		// <a href="{server_uploaded_image_url}"><img src="{server_uploaded_image_url}" alt="" title="" width="" height"" class="alignzone size-full wp-image-125" /></a>
		htmlobj=$('<div>'+html+'</div>');
		var image_url = $(htmlobj).find('img').attr('src');
		// alert(htmlobj);
		// alert(image_url);
		$('#qus_img').val(image_url);
		tb_remove();		
	}
	
	// $('body').delegate('click','.addNewBlock',function(){
	$('.addNewBlock').click(function(){
		// alert('ssss');
		var tagName='tr',tagStyle=''
		var lastChild=$(this).parent().find('.blocks '+tagName+':last-child');
		if ($(this).attr('view')=='flex') {
			tagName='div'
			var lastChild=$(this).parent().find('.blocks >'+tagName+':last-child');
		}
		tagStyle='style="'+lastChild.attr('style')+'"'
		// alert(lastChild.html());
		$last=$(this).parent().find('.blocks').append('<'+tagName+' '+tagStyle+'>'+lastChild.html()+'</'+tagName+'>');
		var lastChild=$(this).parent().find('.blocks >'+tagName+':last-child');
		// console.log(lastChild.html())
		lastChild.find('input').val('');
		lastChild.find('textarea').val('');
		lastChild.find('img').remove();
		$(this).parent().find('.blocks '+tagName).find('.deleteImage').show();
	})
	if($('.blocks tr').length==2){
		var lastChild=$('.blocks tr:last-child');
		lastChild.find('.deleteImage').hide();
	}
	$('body').delegate('.deleteImage','click',function(){
		var parentTr=$(this).parent().parent().parent();
		var parentTable=parentTr.parent();
		var tagName='tr'
		if($(this).attr('view')=='flex'){
			parentTr=$(this).parent().parent()
			parentTable=parentTr.parent()
			tagName='div'
		}
		console.log(parentTable.children(tagName).length);
		// console.log(parentTable.children(tagName).html());
		// return;
		if(parentTable.children(tagName).length>1){
			parentTr.remove();
		}
		if(parentTable.children(tagName).length==2){
			var lastChild=parentTable.children(tagName+':last-child');
			lastChild.find('.deleteImage').hide();
		}
	})

	
	$('body').delegate('.addNewPhoto','click',function(){
		// alert('ssss');
		var photoToAdd=$(this).parent().find('.photoToAdd');
		console.log(photoToAdd.html());
		$(this).parent().find('.photos').append(photoToAdd.html());
	})
	$('body').delegate('.deletePhoto','click',function(){
		$(this).parent().remove();
	})
	
});