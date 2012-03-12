<div class="form">

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
 		'htmlOptions'=>array( 'class'=>'well' ),
		) );
 ?>

	<?php     echo $form->errorSummary(array_merge(array($model),$validatedSteps));?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
	<?php echo $form->error($model,'content'); ?>
	<?php echo $form->textArea($model,'content',array('style'=>'display:none'));?>
	<?php 
		$this->widget('application.extensions.elrte.elRTE', 
		array(
			'selector'=>'#Howto_content',
			'userid'=>Yii::app()->user->id,
		));
	?>
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php $this->widget('CAutoComplete', array(
			'model'=>$model,
			'attribute'=>'tags',
			'url'=>array('suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>50),
		)); ?>
		<p class="hint">Please separate different tags with commas.</p>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('HowtoStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	
	<a onClick="$('#stepContainer').show();" rel=".id_step_copy" href="" id="id_step">Manage Steps</a>
	
	<div id="stepContainer" style="display:block">
<?php 
	$stepFormConfig = array(
      'elements'=>array(
        'title'=>array(
            'type'=>'text',
            'maxlength'=>40,
        ),
        'text'=>array(
            'type'=>'textarea',
			'class'=>'eltre',
			'value'=>'What do now?:)',
        ),
		 'howto_id'=>array(
            'type'=>'hidden',
            'maxlength'=>25,
        ),
        
    ));
 
	$this->widget('ext.multimodelform.MultiModelForm',
	array(
        'id' => 'id_step', //the unique widget id
        'formConfig' => $stepFormConfig, //the form configuration array
        'model' => $step, //instance of the form model
		'sortAttribute' => 'position', //if assigned: sortable fieldsets is enabled
		'jsAfterClone'=>'$(this).focus()',
		/*'jsAfterNewId'=>"eltre('.eltre'); ;",
		'jsBeforeNewId' => "alert(this.attr('id'));", 
	    'jsAfterNewId' => "alert(this.attr('id'));",
					$("#editorPlaceholder").html("lol"); 
		'jsAfterClone'=>'$("editorPlaceholde").load("/howto/eltre")',*/ 
		'tableView'=>false,
		'addItemText'=>'Add step',
        //if submitted not empty from the controller,
        //the form will be rendered with validation errors
        'validatedItems' => $validatedSteps,
 
        //array of member instances loaded from db
        'data' => $step->findAll('howto_id=:howtoId', array(':howtoId'=>$model->id)),
    ));
?>

	<div id="editorPlaceholder"></div>
		
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', 
			array( 'class'=>'btn btn-primary' ) ); ?>
	</div>

<?php $this->endWidget(); ?>
		</div><!-- stepContainer-->
	</div><!-- form -->
<script type="text/javascript">
/*<![CDATA[*/
function eltre(id) {

	elRTE.prototype.options.panels.myToolbar = ['bold', 'italic', 'underline',
	'strikethrough','justifyleft','justifyright', 'justifycenter', 'justifyfull',
	'insertorderedlist', 'insertunorderedlist', 'docstructure','paste','removeformat','link','unlink', 'elfinder', 'image', 'fullscreen'];
	elRTE.prototype.options.toolbars.myToolbar = ['myToolbar'];
	var opts = {
	'doctype': '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">',
	'cssClass':'el-rte',
	'height': '100px',
	'width': '500px',
	'toolbar': 'tiny',
	'absoluteURLs': false,
	'allowSource': false,
	'styleWithCSS': false,
	'fmAllow': true,
	'cssfiles':['/assets/7952073/css/elrte-inner.css'],
	'fmOpen' : function(callback) {
	$(".eltre").elfinder({
	'url' : '/assets/7952073/connectors/php/connector.php?userid=1',
	'dialog' : { width : 900, modal : true, title : 'Files' },
	'closeOnEditorCallback' : true,
	'editorCallback' : callback
	}) }} ;
	$('.eltre').elrte(opts);



};
/*]]>*/
</script> 
	<script>
$(document).ready(function(){
/*$("#Step_text").hide();
$("#Step_title").hide();
$('label[for="Step_title"]').hide();
$('label[for="Step_text"]').hide();
});*/

</script>