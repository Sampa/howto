<?php

Yii::import('zii.widgets.CPortlet');

class Categories extends CPortlet
{
public $title='Categories';
public $forum=false;
public $sql=false;
	public function getCategories()
	{
		if($this->sql == false){
		return Category::model()->findAll();
		}else{
		return Category::model()->findBySql($this->sql);
		}
	}

	protected function renderContent()
	{
			$this->render('categories');
		
	}
}