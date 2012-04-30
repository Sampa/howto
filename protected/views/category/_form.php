<div class="well">

<?php $form=$this->beginWidget('BootActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row-fluid">
	<?php echo $form->labelEx($model,'parent'); ?>

	<?php
	// retrieve the models from db
$models = Category::model()->findAll(array(
					'order'=>'name', 
					'condition'=>'parent=:parent', 
					'params'=>array(':parent'=>'no parent')
					));
 
// format models as $key=>$value with listData
$list = CHtml::listData($models, 
                'id', 'name');

?>
<?php echo CHtml::dropDownList('categories', $models, 
              $list,
              array('empty' => 'Select a category','class'=>'chzn-select'));
			  ?>
<br/><p>Or add new parent</p>
<?php echo $form->textField($model,'parent');?>
<?php echo $form->error($model,'parent'); ?>
	</div>
	<?php $this->widget( 'ext.EChosen.EChosen' ); ?>
	<div class="row-fluid buttons">
	<div id="response"></div>
	<?php echo CHtml::ajaxSubmitButton( $model->isNewRecord ? 'Create' : 'Save',
						
                                        CHtml::normalizeUrl(array('category/create')),
                                        array(
                                        'error'=>'js:function(){
                                            alert(\'error\');
                                        }',
                                      
                                        'update'=>'#response',
                                        ),array('class'=>'btn btn-primary')
                                    );
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->