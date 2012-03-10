<div class="row hasManyRelation">
    <!-- exists items -->
    <?php if ( $model->steps ): ?>
        <?php foreach ( $model->steps as $index => $step ): ?>
            <div class="has-many-step">
                <?php if (!$step->isNewRecord): ?>
                    <?php echo $form->hiddenField($model, "steps.$index.id"); ?>
                <?php endif; ?>
				 <?php echo $form->labelEx($model, "steps.$index.title"); ?>
				<?php echo $form->textField($model, "steps.$index.title"); ?>
				<?php echo $form->error($model, "steps.$index.title"); ?>
				
                <?php echo $form->labelEx($model, "steps.$index.text"); ?>
                <?php echo $form->textArea($model, "steps.$index.text"); ?>
                <?php echo $form->error($model, "steps.$index.text"); ?>
                <a href="#" class="delete">Delete</a>
            </div>
        <?php endforeach ?>
    <?php endif; ?>
 
    <!-- create new items -->
    <div class="has-many-item just-empty-form-template-hasManyRelation">
		<?php echo $form->labelEx($model, "steps..title"); ?>
        <?php echo $form->textField($model, "steps..title"); ?>
        <?php echo $form->error($model, "steps..title"); ?>
		
        <?php echo $form->labelEx($model, "steps..text"); ?>
        <?php echo $form->textArea($model, "steps..text"); ?>
        <?php echo $form->error($model, "steps..text"); ?>
        <a href="#" class="delete">Delete</a>
    </div>
 
    <a href="#" class="add">Add more</a>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        // init controls for multiply form
        $('.hasManyRelation').multiplyForms({
            embedClass: 'has-many-item',
            templateClass: 'just-empty-form-template-hasManyRelation'
        });
	});
</script>