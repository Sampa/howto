<?php
	$this->breadcrumbs = array( $model->title, );
	$this->pageTitle = $model->title;
	$this->layout = "column1";
	$updated = date('F j, Y',$model->update_time);
	if(Yii::app()->user->id == $model->author->id){
		$owner = true;
		}else{
		$owner = false;
		}
?>
<?php  Yii::app()->clientScript->registerScriptFile('/js/howto.view.js',CClientScript::POS_BEGIN);?>
<?php $this->widget("ViewsCountWidget", array('uniqueMode'=>false,'modelId' => $model->id, 'modelClassName' => get_class($model)));?>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "072ae230-75fe-4c32-ab84-c2c0cb6ce84e"}); </script>
	
<div id="howto_container" class="span12" style="padding-left: 5px; float:left; ">

	<div id="left" class="span6" style="" >
	
		<div style="margin-bottom:-5%;">
			<?php echo $this->renderPartial('_view',array('data'=>$model,'owner'=>$owner ,'view'=>true ),true,false ); ?>
		</div>
	<!-- steps-->
			<!--Add Step-->
	<?php if( $owner): ?>
				<button class="btn btn-mini " id="createButton"><!-- sign up button-->
					<i class="icon-plus"></i> Add Step
				</button>
			<!--delete--> 
				<button class="btn btn-mini btn-danger howtodelete" name="<?=$model->id;?>">
					<i class="icon-remove icon-white"></i> Delete
				</button>
		<div id="delete_howto_message<?=$model->id;?>" name="<?=$model->id;?> style="display:none"></div>
	<?php endif; ?>   
	
	<div id="steps" class="span12" style=" float:left;">
		<?php if ( $owner ):?>
			<!-- files with modalwindow, ajax calls etc for easier reading -->
		<?php
		$this->renderPartial('//step/_create',array('howto'=>$model->id)); 
		 if ( $model->stepCount >= 1 ): ?>
			<h3>
				<?= $model->stepCount>1 ? $model->stepCount . ' steps' : 'One step'; ?>
			</h3> 
		<?php endif; 
		
		Yii::app()->user->setFlash('info', 'Drag the titles of the steps to  re-arrange them <br/>
		Change the steps by clicking on the step text.');
		$this->widget('bootstrap.widgets.BootAlert'); 
		endif;
		?>
		<div id="stepsUpdated"></div>
		
			<ul id="sortable" style="list-style:none;">	
				<?php
				foreach ( $model->steps as $step ):
					if($owner){
						echo CHtml::tag('li',array('id'=>$step->id,'class'=>'ui-state-highlight','style'=>'border:0px;'),false);
					}
					echo CHtml::tag("h5",array('style'=>'min-width:100%;'),$step->title);
					echo "<br/>";
					echo CHtml::tag('div',array(
						'id'=>'div'.$step->id,
						'style'=>'display:none;',
						),'');
					echo CHtml::tag('div',array(
						'id'=>'step_text_div'.$step->id,
						'name'=>$step->id,
						'class'=>'well step_text',
						),$step->text);
					if($owner):
					echo CHtml::tag('button',array(
						'id'=>'button'.$step->id,
						'class'=>'btn btn-mini btn-success save_step',
						'name'=>$step->id,
						'style'=>'display:none;',
					),'Save');
					
				 ?>
		 <script type="text/javascript">
			
			bkLib.onDomLoaded(function() {
			var myNicEditor = new nicEditor({uploadURI:'/nic/upload.php?hej=<?=$model->id;?>'});
			myNicEditor.setPanel('div<?=$step->id;?>');
			myNicEditor.addInstance('step_text_div<?=$step->id;?>');

			});
		</script>
			<?php if($owner){echo "</li>";}?>
		<?php endif;?>
		<?php endforeach; ?>
			</ul>
	
	<h5>Last updated: <i><?= $updated?></i> </h5>	

	</div><!--steps-->

	<?php if($related): ?>
		
		<div id="slider-code" class="span12">
				<h3>You might also like:</h3>

			<a class="buttons prev" href="#"><img src="/images/arrow_left.gif" alt="left"/></a>
			<div class="viewport">
				<ul class="overview" >
				<?php
				foreach ( $related as $link=>$weight )
				{
					echo CHtml::tag('li',array('class'=>'well'),CHtml::tag('h4',array(),$link));
				}
				?>
				<li> some shits</li>
				<li> some second shits</li>
				<li> some third shits</li>
				<li> some  fourth shits</li>
				</ul>
			</div>
			<a class="buttons next" href="#"><img src="/images/arrow_right.gif" alt="right"/></a>
		</div>
			
		<?php endif;?>
	
</div><!-- left-->

<!------ RIGHT COLUMN -->

	<div id="side" style="margin: 25px 0px 0 25px;padding-left:25px; border-left:0px solid #08c" class="span5" >
		<!-- CATEGORIES -->
		<?php
		if (!count($model->categoryLinks) < 1){
		foreach ( $model->categoryLinks as $catLink ){echo ''.$catLink.'';}
		}
		?>
		<?php 
	
		if(count($model->tagLinks) > 0)
		{
			foreach($model->tagLinks as $taglink)
			{	echo $taglink. "&nbsp;"; }
		}
		?>
		<hr/>
			<!-- attachments-->
		<h4> Attachments </h4>
		
<ul>
		<?php foreach($attachments as $file):?>
			<li>
				 <a href="<?= USER::USER_DIR.Yii::app()->user->id."/".$file->filename;?>"><?= $file->filename;?></a>
				<?php if($owner):?>
					<button class="btn btn-danger btn-mini del_attachment" style="" name="<?=$file->id;?>">
						<i class="icon-white icon-remove"></i> Delete
					</button>
				<?php endif;?>
			</li>
		<?php endforeach;?>
</ul>
	
	<?php 
		if($owner)
		{
		$XUpload = new XUploadForm;
		$this->widget('xupload.XUpload', 
				array(
						'url' => Yii::app()->createUrl("file/upload", 
						array("parent_id" =>User::USER_DIR . Yii::app()->user->id) ),
							'model' => $XUpload,
							'attribute' => 'file',
							'multiple'=>false,
							'options'=>array(
							'autoUpload'=>true,
							'completed' => 'js:function (e,data) {
							var filename = data.files[\'0\'][\'name\'];
							var url = "/howto/newattachment";
									jQuery.getJSON(url, {filename: filename,howto_id:'.$model->id.'}, function(data) {
										if (data.status == "success") {
							$().toastmessage("showSuccessToast", "Attachment added!");
										   return true;	
											
										}else{return false;}          
									});
							}'),
				   ));

			   
		} 
	?>
<!-- end attachments -->
		<hr/>

	<script type="text/javascript">
	
function getCreate(id,content,response){
	if(response == ""){
	response = false;
	}
	var content = $(content).html();
    var url = '/comment/new?howto_id='+id;
    jQuery.getJSON(url, {content: content,response:response}, function(data) {
        if (data.status == 'success') {
           return true;	
			
        }else{return false;}          
	});}
	
$(document).ready(function() {

$('#slider-code').tinycarousel({display:2, controls:true});

$(".save_step").hide();
	$(".step_text").click(function(){
		var id = $(this).attr('name');
		console.log(id);
		$("#button"+id).fadeIn('slow');
		$("#div"+id).fadeIn('slow');

	});
	$(".save_step").click(function(){
		var id = $(this).attr('name');
		var url = '/step/inlineEdit?id='+id;
		var content = $('#step_text_div'+id).html();
		jQuery.getJSON(url, {content: content }, function(data) {
			if (data.status == 'success'){
					$("#button"+id).fadeOut('slow');
					$("#div"+id).fadeOut('slow');
				}
			});
			return false;
		});

	$(".alert").click(function(){
		$(this).hide();
	});
		
<!-- EVENT! When the user has sorted a step to a new position -->
	$("#sortable").bind( "sortupdate", function(event, ui) {
		updatePos();
	});
	function updatePos() {
		var pos = $("#sortable").sortable('toArray');
			url = '/step/updatePos/howtoid/'+<?php echo $model->id;?>;
	 
		jQuery.getJSON(url, {pos: pos}, function(data) {
			if (data.status == 'success') {
		$().toastmessage('showSuccessToast', data.div);

			}
		});
		return false;
	}
<!-- END EVENT -->
	
	$(document).ready(function(){
	$("#sortable").sortable({handle:'h5'});

	
		});
</script>

		<div style=" clear:both;position:relative; width:120%;top:0px; left:0px; ">
				<span class='st_sharethis' displayText='ShareThis'></span>
				<span class='st_twitter' displayText='Tweet'></span>
				<span class='st_email' displayText='Email'></span>
				<span class='st_plusone' displayText='Google +1'></span>
				<span class='st_fbsend' displayText='Facebook Send'></span>
				<span class='st_fbrec' displayText='Facebook Recommend'></span>
		</div>	


<?php if($model->commentCount>=1): ?>
		<h5>
			<?php echo $model->commentCount>1 ? $model->commentCount . ' comments' : 'One comment'; ?>
		</h5>
		<div id="current">
		<?php $this->renderPartial('_comments',array(
			'howto'=>$model,
			'comments'=>$model->comments,
		)); ?>
		</div>
	<?php endif; ?>


	<?php if ( !Yii::app()->user->isGuest ){
	
		$this->renderPartial('/comment/_form',array(
			'model'=>$comment,
			'howto'=>$model,
		)); 
	}else{ echo "You must be signed in to comment";}

	?>
	</div><!-- comments -->

