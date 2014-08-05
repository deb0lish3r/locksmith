<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
    <h2>NIC Photo Editor</h2>
    	<div id="message" class="updated below-h2" style="display:none;"></div>    	
    	<div class="form-wrap">	    	
    	<!-- canvas start -->
    	<h3>Upload Images in Canvas</h3>  
  		<span id="cwh">Note:It's canvas actual pixels.</span>
  		
    	<div class="block">
 <div class="canvas_main">
	 <div class="canvas_container">    	
	  <canvas id="c1" width="500" height="500" class="lower-canvas" style="position: absolute; width: 200px; height: 200px; left: 0px; top: 0px; -webkit-user-select: none;"></canvas> 
	</div>
</div>

<div class="canvas_sidebar">

	<div>
	<label id="upload_image_label" for="upload_image_button"></label>
	<input id="upload_image" type="hidden" name="upload_image" value="" />
	<input id="upload_image_button" class="button button-primary" type="button" value="Choose Image" />
	</div>
	<span id="uniq" style="display:none;"></span> <!-- hidden image element -->
	
<fieldset>
<legend>Canvas Background</legend>
Transparent <input type="checkbox" id="canvas_chk" value=""><br/>
<input type="text" class="color" value="FFFFFF" id="canvas_bg">
</fieldset>


<fieldset>
<legend>Canvas Size</legend>
Width:&nbsp;&nbsp; <input type="text"  name="canvas_w" id="canvas_w" value="500" onKeyUp="jQuery(this).val(jQuery(this).val().replace(/[^\d]/ig, ''))" / maxlength="4">px<br>

Height: <input type="text"  name="canvas_h" id="canvas_h" value="500" onKeyUp="jQuery(this).val(jQuery(this).val().replace(/[^\d]/ig, ''))" / maxlength="4">px<br>

<input type="button" name="set_canvas_wh" id="set_canvas_wh" class="button button-primary" value="Set Size" /><label id="canvas_image_size_label" for="set_canvas_wh"></label>
</fieldset>
<!-- -->
<fieldset>
<legend>Object Size</legend>
Width:&nbsp;&nbsp; <input type="text"  name="image_w" id="image_w" value="500" onKeyUp="jQuery(this).val(jQuery(this).val().replace(/[^\d]/ig, ''))" / maxlength="4">px<br>

Height: <input type="text"  name="image_h" id="image_h" value="500" onKeyUp="jQuery(this).val(jQuery(this).val().replace(/[^\d]/ig, ''))" / maxlength="4">px<br>

<input type="button" name="set_wh" id="set_wh" class="button button-primary" value="Set Size" /><label id="canvas_image_size_label" for="set_wh"></label>
</fieldset>

<input type="button" name="bring_front_image" id="bring_front_image" class="button-primary" value="Bring Front" />
<label id="bring_front_image_label" for="bring_front_image"></label><br><br>

<input type="button" name="send_back_image" id="send_back_image" class="button-primary" value="Send Back" />
<label id="send_back_image_label" for="send_back_image"></label><br><br>

<input type="button" name="delete" class="button-primary" id="delete" value="Delete" />
<label id="picture_delete_label" for="delete"></label>
<br><br>

<input type="button" name="generate_image" class="button-primary" id="generate_image" value="Preview" />
<label id="view_image_label" for="generate_image"></label>
<br><br>

<form name='drag_drop_items' id="drag_drop_items" method="POST">
<input type="hidden" name="type" value="add_frame">
<input type="hidden" id="canvas_final_w" name="canvas_final_w" value="">
<input type="hidden" id="canvas_final_h" name="canvas_final_h" value="">
<input type="hidden" name="type" value="add_frame">
<input type="hidden" name="canvas_json" id="canvas_json" value="" />
<input type="hidden" name="image_data" id="image_data" value="" />

<input type="button" name="save_data" class="button-primary" id="save_data" value="Save" />
<label id="save_accept_label" for="save_data"></label>

</form>
</div>


<script>


jQuery(document).ready(function(){
	
	
	var canvas2d = document.getElementById('c1');
    var context = canvas2d.getContext('2d');
	var canvas = new fabric.Canvas('c1');	
	var canvas_bg = jQuery('#canvas_bg').val();
	//canvas.loadFromJSON();	
	//canvas backgound is white onload
	
	//jQuery('#c1').css('background-color','#'+canvas_bg);
		
	canvas.backgroundColor='#'+canvas_bg;			
	canvas.renderAll();			
		jQuery('#canvas_chk').click(function() {
	
			if(jQuery("#canvas_chk").attr("checked")=="checked"){								
				canvas.backgroundColor='';
				canvas.renderAll();		
			}else{
				var canvas_bg = jQuery('#canvas_bg').val();					
				canvas.backgroundColor='#'+canvas_bg;
				canvas.renderAll();		
			}
	
		});
		
		//to chang canvas background color
		jQuery('#canvas_bg').blur(function() {	
				jQuery("#canvas_chk").attr("checked" , false );
				canvas_bg = jQuery('#canvas_bg').val();
				//jQuery('#c1').css('background-color','#'+canvas_bg);
				canvas.backgroundColor='#'+canvas_bg;			
				canvas.renderAll();			
				
		});
	
	
	
	//upload from media liebrary
      	jQuery('#upload_image_button').click(function() {
		 formfield = jQuery('#upload_image').attr('name');
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 return false;
		});

		
window.send_to_editor = function(html) {	
	if (jQuery(html).find("img").length == 0) {		
		alert('Please upload image only');
      		tb_remove();
      		return false;
      } 

	
 imgurl = jQuery('img',html).attr('src');
 jQuery('#upload_image').val(imgurl);
  jQuery('#a1').remove();
 jQuery('#uniq').html('<img src=\"'+imgurl+'\" id="a1" class="drag-able-imge ">'); 
 		var source_id = 'a1';	
		var imgElement = document.getElementById(source_id);		
		var randomnumber = Math.floor(Math.random()*11111);
		var imgInstance = new fabric.Image(imgElement, {
			left: 100,
			top: 100,
			height:200,			
			width:200,
			angle:0,
			src: imgElement,
			id:randomnumber,
		});

		canvas.add(imgInstance);						
		canvas.renderAll();
		tb_remove();	
		
		var t=setTimeout(function(){canvas.renderAll();},300);		
		
}
	
	
	canvas.on({
	'mouse:down': function(e) {
		
		if (e.target) {
			e.target.opacity = 0.5;
			canvas.renderAll();
		}
	},
	'mouse:up': function(e) {
		if (e.target) {
			save_object_data(e);
			e.target.opacity = 1;
			canvas.renderAll();
		}
	},
	'object:moved': function(e) {
		e.target.opacity = 0.5;
	},
	'object:modified': function(e) {

		save_object_data(e);
		e.target.opacity = 1;

	},
	'object:moving' : function(e){
		preventLeaving(e);
	},
	'object:scaling' : function(e){

		preventLeaving(e);
	}
	});

	jQuery('#send_back_image').click(function(e){

		var currentObject = canvas.getActiveObject()
		if(currentObject){
			canvas.sendBackwards(currentObject)
		}else{
			alert('Please Select Object First');
		}


	});


	jQuery('#bring_front_image').click(function(e){

		var currentObject = canvas.getActiveObject()

		if(currentObject){
			canvas.bringForward(currentObject);
		}else{
			alert('Please Select Object First');
		}
	});
		
	//object width/height
	jQuery('#set_wh').click(function(e){
			var currentObject = canvas.getActiveObject();
			var image_width = jQuery('#image_w').val();
			var image_height = jQuery('#image_h').val();

		if(currentObject){					
			if(image_width!=''){
			canvas.add(currentObject.set('scaleX', image_width / currentObject.get('width')));
			canvas.remove(currentObject);
			}
			
			if(image_height!=''){
			canvas.add(currentObject.set('scaleY', image_height / currentObject.get('height')));
			canvas.remove(currentObject);
			}
			
			//canvas.deactivateAll().renderAll();	
			
		}else{
			alert('Please Select Object First');
		}
		

	});
	
	//
	
	//canvas width/height
		jQuery('#set_canvas_wh').click(function(e){

			var currentObject = canvas.getActiveObject();
			
			var canvas_width = jQuery('#canvas_w').val();
			var canvas_height = jQuery('#canvas_h').val();
			
			
			if(canvas_width == ''){
			canvas_width = 500;
			jQuery('#canvas_w').val(canvas_width);
			}
			
			if(canvas_height ==''){
			canvas_height = 500;
			jQuery('#canvas_h').val(canvas_height);
			}
			
						
			jQuery('#canvas_final_w').val(canvas_width);
			jQuery('#canvas_final_h').val(canvas_height);
			
			if(canvas_width>500 || canvas_height>500){
				jQuery('#cwh').html('Note:It\'s not canvas actual pixels, Its fit in screen, It will save with actual pixels.');
				
				if(canvas_width>500)
				canvas_width = 500;
				
				if(canvas_height>500)
				canvas_height = 500;				
				
				jQuery('#c1').width(canvas_width+'px');
				jQuery('#c1').height(canvas_height+'px');
				var canvasAttr = document.getElementsByTagName('canvas')[0];
				canvasAttr.width  = canvas_width;
				canvasAttr.height  = canvas_height;			
				jQuery('.canvas_container').width(canvas_width+'px');
				jQuery('.canvas_container').height(canvas_height+'px');
				
			}else{
			jQuery('#cwh').html('Note:It\'s canvas actual pixels.');
			jQuery('#c1').width(canvas_width+'px');
			jQuery('#c1').height(canvas_height+'px');
			var canvasAttr = document.getElementsByTagName('canvas')[0];
			canvasAttr.width  = canvas_width;
			canvasAttr.height  = canvas_height;			
			jQuery('.canvas_container').width(canvas_width+'px');
			jQuery('.canvas_container').height(canvas_height+'px');
			}
			canvas.renderAll();

	});
	
	//

	jQuery('#delete').click(function(e){

		var currentObject = canvas.getActiveObject()

		if(currentObject){
			canvas.remove(currentObject)
		}else{
			alert('Please Select Object First');
		}

	});

	jQuery("#save_data").click(function(e){
		canvas.deactivateAll().renderAll();
		var canvas_json = JSON.stringify(canvas);
		var canvas_json_data = jQuery('#canvas_json').val(canvas_json);		
		var image_data = document.getElementById('c1').toDataURL();
		//return false;
		
		
		jQuery('#image_data').val(image_data);				
		var post_data = jQuery('#drag_drop_items').serialize();
		
		
		jQuery.ajax({
			data : post_data,
			type : 'post',
			url : ajaxurl+'?action=my_special_action',
			beforeSend: function() {                	
                    jQuery('.canvas_container').before('<div class="wpuf-loading-default"></div>');
                },
                 complete: function() {
                   jQuery('.wpuf-loading-default').removeClass('wpuf-loading-default');                   
                    //context.clearRect(0, 0, canvas2d.width, canvas2d.height);
					canvas.backgroundColor='#FFFFFF';
					jQuery('#canvas_bg').val('FFFFFF')
					jQuery('#canvas_bg').css({'background-image':'none','background-color':'rgb(255, 255, 255)', 'color':'rgb(0, 0, 0)'});                    
                    canvas.deactivateAll().renderAll();	                 
                    canvas.clear();   
                },
			success : function(data){	
		if(data == 'success') {		
			var templateUrl = '<?php echo get_admin_url().'upload.php'; ?>';							
			window.location.href = templateUrl;
            //jQuery("#message").show().addClass("updated").removeClass('error').html("<p>The file uploaded successfully.</p>");
          } else{
          	jQuery("#message").show().addClass("error").removeClass('updated').html("<p>"+data+"</p>");          	
          }
           
			}		
		})
		
		
	});
	
	jQuery('#generate_image').click(function(e){
		
		canvas.deactivateAll().renderAll();	
		var canvas_new  = document.getElementById("c1");		
		var dataUrl = canvas_new.toDataURL();
		
		window.open(dataUrl, "toDataURL() image", "width=500, height=500");
	});

	function preventLeaving(e) {

		var activeObject = e.target;

		if ((activeObject.get('left') - (activeObject.currentWidth  / 2) < 0))
		activeObject.set('left', activeObject.get('width') * activeObject.get('scaleX')  / 2);

		if ((activeObject.get('top') - activeObject.currentHeight  / 2) < 0)
		activeObject.set('top', activeObject.currentHeight  / 2);

		if ((activeObject.get('left') + activeObject.currentWidth  / 2) > canvas.getWidth())
		{
			var positionX = canvas.getWidth() - activeObject.currentWidth  / 2;
			activeObject.set('left', positionX > canvas.getWidth() / 2 ? positionX : canvas.getWidth() / 2);
		}

		if ((activeObject.get('top') + activeObject.currentHeight / 2) > canvas.getHeight())
		{
			var positionY = canvas.getHeight() - (activeObject.currentHeight / 2);
			activeObject.set('top', positionY > canvas.getHeight() / 2 ? positionY : canvas.getHeight() / 2);
		}

		//below just prevention for object from getting width or height greater than canvas width and height
		if (activeObject.currentWidth  > canvas.getWidth())
		{
			activeObject.set('scaleX', canvas.getWidth() / activeObject.get('width'));
		}

		if (activeObject.currentHeight > canvas.getHeight())
		{
			activeObject.set('scaleY', canvas.getHeight() / activeObject.get('height'));
		}
	}
	
});


function save_object_data(e){

	
	var actual_weight = e.target.width * e.target.scaleX;
	var actual_height = e.target.height * e.target.scaleY;

	var object_attributes = '{ "target_datas" : [' +
	'{ "top":"'+e.target.top+'" , "left":"'+e.target.left+'" , "height":"'+e.target.height+'" , "width":"'+e.target.width+'" , "src":"'+e.target.getSrc()+
	'","scaleX":"'+e.target.scaleX+'" ,"scaleY":"'+e.target.scaleY+'","actualWidth":"'+actual_weight+'" ,"actualHeigth":"'+actual_height+
	'","angle":"'+e.target.angle+'"}]}';


	if(jQuery('#'+e.target.id).length == 0){
		var input = document.createElement('input');
		input.setAttribute("type","hidden");
		input.setAttribute("name","canvas_objects[]");
		input.setAttribute("id",e.target.id);
		input.setAttribute("value",object_attributes);

	}else{
		jQuery('#'+e.target.id).val(object_attributes);
	}
}
</script>
    	<!-- canvas end -->    	
    	</div>
</div>    	