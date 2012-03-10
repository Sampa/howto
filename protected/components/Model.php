<?php

class Model extends CActiveRecord
{

	public function beginCriteria( $order = 'DESC' , $condition = null ){

		return new CDbCriteria(
				array(
					'condition'=>$ondition,
					'order'=>$order,
				));
		}
	public function attributeAlias( $column , $value )
	{
		$alias = array(
			'yesno'=>array(
				0=>'No',
				1=>'yes',
				),
			);
		return $alias[$column][$value];
	}
	
}