<?php if(!empty($_GET['tag'])): ?>
<h1>Howto's Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>
<?php if(!empty($_GET['category'])): ?>
<h1>Howto's in  <i><?php echo CHtml::encode($_GET['category']); ?></i></h1>
<?php endif; ?>
<div style="float:left;">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>"{items}<div style=''>{pager}</div>",
)); ?>
</div>

