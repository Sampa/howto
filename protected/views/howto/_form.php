
<div class="well" style="position:relative;min-height:1040px;border:0px solid black; " >

<style type="text/css">
	#howto-form div.row-fluid{
	 padding:10px; 
	 padding-bottom:3px;
	 width:700px;
	}
	#howto-form div.formlabel{
	width:230px;
	margin-right:10px;
	background-color:#0088CC;
	float:left;
	}
	#howto-form div.formlabel h4{
	color:#f5f5f5;
	}
	#howto-form div.formhelp {
	width:275px;
	background-color:#DFF0D8; color: #468847;
	}
</style>
<?php 
	$form = $this->beginWidget('BootActiveForm', 
	array(
		'id'=>'howto-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		 'clientOptions' => 
		 array(
		  'validateOnSubmit'=>true,
		  'validateOnChange'=>true,
		  'validateOnType'=>true,
			 ),
 		'htmlOptions'=>array( 'class'=>'span8','style'=>'float:left;' ),
		) );
 ?>
 <h3>Share some knowledge!</h3>
	<?php  echo $form->errorSummary(array($model));?>
	<div class="row-fluid">
		
		<div class="well formlabel">
			<h4>Give your Howto a name</h4>
			<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		</div>
		
		<div  style="float:left;">
			<?php echo $form->error($model,'title'); ?>
			<div class="well formhelp" >
			Try to pick a title that well describes what the howto is about,<br/>
			so other users easily can see if it's for them
			</div>
		</div>
	</div>

	<div class="row-fluid" >
		<div class="well formlabel">
			<h4> Categories	</h4>
				<?php 
					$category = Category::model()->findAll('parent <> "no parent" ORDER BY name');
					$categories = CHtml::listData($category, 'id', 'name'); // Get the list of options
					$this->widget('ext.select2.ESelect2',array(
					  'model'=>$model,
					  'attribute'=>'categories',
					  'data'=>$categories,
					  'multiple'=>true,
					  'options'=>array(),
					  'htmlOptions'=>array('class'=>'ac_input')
					)); 
				?>		
		</div>
		<div  style="float:left;">
			<?php echo $form->error($model,'categories'); ?>
			<div class="well formhelp" >
			Select one or more categories that is <b>the most</b> suiting. 
			Obviously missplaced Howtos will be removed.
			</div>
		</div>
	</div>
	<div class="row-fluid" >
		<div class="well formlabel">
			<h4>Tags</h4>		
			<?php echo $form->textField($model,'tag',array('size'=>80,'maxlength'=>128)); ?>
			<script type="text/javascript">
			
			var url = '/howto/jsonTags';
			jQuery.getJSON(url, {}, function(data) {
				if (data){
					$("#Howto_tag").select2({tags:data});
				};
			return false;
			});
			</script>
		</div>
		<div  style="float:left;">
			<?php echo $form->error($model,'tag'); ?>
			<div class="well formhelp" >
				Please seperate diffrent tags with a <b>,</b> (comma)<br/>
				Tags are used to in one word point out more
				exactly what the Howto is about,<br/>
				making it more likely to attract viewers.<br/>
			</div>
			
		</div>
	</div>

	<div class="row-fluid">
		<div class="well formlabel">
			<h4>Private</h4>
			<?php echo $form->checkBox($model,'status',array()); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
		<div style="float:left;">
			<div class="well formhelp" >
			If you make the Howto private,<br/> only you and the people you give the link to will see it
			</div>
		</div>
		<?php $this->widget('ext.ibutton.IButton', array(
            'model'     => $model,
            'attribute' => 'status',
            'options' =>array(
                'labelOn'=>Yii::t('app','Yes'),
                'labelOff'=>Yii::t('app','No'),
            )
		));?>
	</div>
	
	<div class="row-fluid">
		<div class="well formlabel">
			<a class="btn" id="attachments">Attachments</a>
			
		</div>
		<div style="float:left;">
			<div class="well formhelp" >
			Attachments is files the reader might need to complete the Howto
			</div>
		</div>
			<?php $this->renderPartial('_attachments',array());?>

		<!-- current content -->
	</div>

	<div class="row-fluid" style="width: 780px;" >

		<div class="well formlabel" style="width:400px;">
			<h4>The description</h4>
			<div  id="new_howto_nic_holder" style="display:none; min-width:100%;"></div>
			<div id="content_background" style="background-color:whiteSmoke;">
			<?php echo $form->textArea($model,'content',array('class'=>'well','style'=>'min-width:100%; min-height:150px; max-height:300px;'));?>
			</div>
		</div>

	<div style="float:left;">
			<?php echo $form->error($model,'content'); ?>
			<div class="well formhelp" style="">
				<h5>Note!</h5> This is only the description<br/>
				You will guide the user thrue the howto on a step-by-step basis after you save these settings.
				<h5> Examples that you could write about about:</h5>
				<ul>
					<li>Is any Preparations needed?</li>
					<li>Where can one read more?</li>
					<li>Will you give support and answer questions?</li>
				</ul> 
			</div>
			<div class="float:left;">
				<button class="btn btn-large btn-success" id="save_continue">
					<i class="icon-ok icon-white"></i> Save & Continue
				</button>
			</div>

	</div>
	
	
	</div>
		<?php echo $form->hiddenField($model,'files',array()); ?>
		<?php echo $form->error($model,'files'); ?>

	<?php $this->endWidget();?>
	
	
</div>
 



<script type="text/javascript">


$("#content_background").click(function(){
	$("#new_howto_nic_holder").fadeIn('slow');
});


$(document).ready(function(){
		
var myNicEditor = new nicEditor({uploadURI:'/nic/upload.php?hej=<?=Yii::app()->user->id;?>'});
			myNicEditor.setPanel('new_howto_nic_holder');
			myNicEditor.addInstance('Howto_content');
	$(".workzone").attr('style','height:200px');
});
</script>
