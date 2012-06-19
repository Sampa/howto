<?php
	$this->breadcrumbs = array( $model->title, );
	$this->pageTitle = $model->title;
	$this->layout = "column1";
?>

	
<div id="howto_container" class="span6" style="padding-left: 5px; float:left; border:0px solid black;">

	<div id="left" class="span12" style="float:left; border:0px solid red;" >
<?php 
	$this->renderPartial('_view',
	array(
		'data'=>$model,
		'owner'=>$owner,
	) ); 
?>
<?php // social plugin
	$this->widget('application.extensions.social.social', 
		array(
			'style'=>'horizontal', 
			'networks' => array(
				'twitter'=>array(
					'data-via'=>'', //http ://twitter.com/#!/YourPageAccount if exists else leave empty
					), 
				'googleplusone'=>array(
					'size'=>'medium',
					'annotation'=>'bubble',
				), 
				'facebook'=>array(
					'href'=>'https://www.facebook.com/your_facebook_page',//asociate your page http://www.facebook.com/page 
					'action'=>'recommend',//recommend, like
					'colorscheme'=>'light',
					'width'=>'130px',
					)
				)
			)
		);
		

	
 ?>


</div><!--left-->
	
	<!-- steps-->
	<div id="steps" class="span10" style="clear:both; float:left;">
		<?php if ( $owner ):?>

		<button class="btn btn-mini btn-success" id="createButton"><!-- sign up button-->
			<i class="icon-plus icon-white"></i> Add Step
		</button>
			
			<!-- files with modalwindow, ajax calls etc for easier reading -->
		<?php $this->renderPartial('//step/_create',array('howto'=>$model->id)); ?>
		<?php if ( $model->stepCount >= 1 ): ?>
			<h3>
				<?= $model->stepCount>1 ? $model->stepCount . ' steps' : 'One step'; ?>
			</h3>
		<?php endif; ?>
		<?php
		Yii::app()->user->setFlash('info', 'Drag the titles of the steps to  re-arrange them <br/>
		Change the steps by clicking on the step text.');
		$this->widget('bootstrap.widgets.BootAlert'); 
		?>
		<div id="stepsUpdated"></div>
		
			<ul id="sortable" style="display:inline;">	
		<?php
		endif;
		foreach ( $model->steps as $step ):
			if($owner)
				echo '<li id="'.$step->id.'" class="ui-state-highlight" style="border:0px solid green">';
			echo $step->title;
			echo '<br/><div id="div'.$step->id.'" style="display:none;"></div><div  name="'.$step->id.'" id="step_text_div'.$step->id.'" class="well step_text" ">' . $step->text .'</div>';
			if($owner):
			echo '<button class="btn btn-mini btn-success save_step" name ="'.$step->id.'" 
			id="button'.$step->id.'" style="display:block;">Save</button>';;
		 ?>
		 <script type="text/javascript">
			//<![CDATA[
			bkLib.onDomLoaded(function() {
			var myNicEditor = new nicEditor({uploadURI:'/nic/upload.php?hej=<?=$model->id;?>'});
			myNicEditor.setPanel('div<?=$step->id;?>');
			myNicEditor.addInstance('step_text_div<?=$step->id;?>');

			});
			//]]>
		</script>
			</li>
		<?php endif;?>
		<?php endforeach; ?>
		<?php if($owner):?>
			</ul>
		<?php endif;?>
	
	</div>
	


</div><!-- container-->
	<div id="side" style="margin: 0px 0px 0 40px;" class="span5" >
<?php
	if( $owner ) {
		echo "<br/><br/>".CHtml::htmlButton('<i class="icon-edit icon-white"></i> Manage Slides',
		array('class'=>'btn btn-mini btn-primary manage_slide'));
		$slide = new Slide('search');
		$this->renderPartial('//slide/index',array('model'=>$slide,'howto'=>$model->id));
		}
	
	$panels = Slide::model()->findAll('howto_id='.$model->id);
	if ( $panels )
	{
		$this->renderPartial('_slide',array('howto'=>$model->id,'panels'=>$panels));
	}
	?>

	<?php 
	foreach($videos as $video):
	
	endforeach;
	?>
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
	});
}	<?php if($owner):?>
$(document).ready(function() {
	$( "#sortable" ).sortable({
			placeholder: "ui-state-highlight",
			items: 'li',
			cursor: 'crosshair',
			disabled: false,
		});
		
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
            $('#stepsUpdated').fadeIn('slow');			
            $('#stepsUpdated').html(data.div);
			$('#stepsUpdated').fadeOut('slow');
        }
    });
    return false;
}
<!-- END EVENT -->
	$(".manage_slide").click(function(){
			$("#slide_div").toggle();
		});
<?php endif;?>
</script>

<?php if($model->commentCount>=1): ?>
		<h3>
			<?php echo $model->commentCount>1 ? $model->commentCount . ' comments' : 'One comment'; ?>
		</h3>
		<div id="current">
		<?php $this->renderPartial('_comments',array(
			'howto'=>$model,
			'comments'=>$model->comments,
		)); ?>
		</div>
	<?php endif; ?>

	<h3>Leave a Comment</h3>

	<?php if ( !Yii::app()->user->isGuest ){
	
		$this->renderPartial('/comment/_form',array(
			'model'=>$comment,
			'howto'=>$model,
		)); 
	}else{ echo "You must be signed in to comment";}

	?>
	</div><!-- comments -->
	<!-- to fix the rating breaking in view but not index-->
	<script>
	jQuery('#rating1 > input').rating({'cancel':'','callback':
			function(){
			url = "/howto/rating";
			jQuery.getJSON(url, {id: 1, val: $(this).val()}, function(data) {
			if (data.status == "success"){
			$("#rating_info_1").html(data.info);
			$("input[id*=1_]").rating("readOnly",true);
			}
			});}}); 
	</script>
	
