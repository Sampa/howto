<h1><?php echo $this->pageTitle.' ('.count($badges).')'; ?>
      <small> - <?php echo CHtml::link( Yii::t('badgerModule.Site','View my badges'), Yii::app()->createUrl('badger/badge/my')); ?></small>
</h1>
<hr/>
<?php

$this->renderPartial('_list',array(
    'badges' => $badges,
));
