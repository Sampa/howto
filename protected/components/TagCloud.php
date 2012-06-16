
<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet
{
	public $title='Tags';
	public $maxTags=20;

	protected function renderContent()
	{
		$tags = Tag::model()->findTagWeights($this->maxTags);
		echo '<div id="tagCloud">';
		foreach($tags as $tag=>$weight)
		{	
			echo '<li>';
			$link = CHtml::link( CHtml::encode( $tag ), array( 'tag/' . $tag ) );
			echo CHtml::tag('span', array(
				'class'=>'',
				'style'=>"font-size:{$weight}pt",
			), $link)."\n";
			echo '</li>';
		}
		echo '</div>';
	}
}