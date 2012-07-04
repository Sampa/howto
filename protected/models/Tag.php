<?php

class Tag extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_tag':
	 * @var integer $id
	 * @var string $name
	 * @var integer $frequency
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tag}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('frequency', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		'howtos'=>array(self::MANY_MANY, 'Howto', 'tbl_howto_tag(tag_id,howto_id)'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'frequency' => 'Frequency',
		);
	}

	
	public static function workOnTags($tags,$howto_id)
	{
		if( is_array ( $tags ) )
		{
			foreach ($tags as $key=>$tag)
			{
				Tag::workOnTag($tag,$howto_id);
			}
		}else{
			Tag::workOnTag($tags,$howto_id);
		}
	
	}
	public static function workOnTag($tag,$howto_id)
	{
	$tag_model = Tag::model()->find("name='".$tag."'");
		if($tag_model){
			$tag_model->frequency = $tag_model->frequency +1;
			$tag_model->save();
		}else{
			$tag_model = new Tag;
			$tag_model->name = $tag;
			$tag_model->frequency = 1;
			$tag_model->save();
		}
		$relation = new HowtoTag;
		$relation->howto_id = $howto_id;
		$relation->tag_id = $tag_model->id;
		$relation->save(false);
	}
	/**
	 * Suggests a list of existing tags matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching tag names
	 */
	
	public function suggestTags($keyword,$limit=20)
	{
		$tags=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'frequency DESC, Name',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($tags as $tag)
			$names[]=$tag->name;
		return $names;
	}

	
	

	public function addTags($tags)
	{
		$criteria=new CDbCriteria;
		$criteria->addInCondition('name',$tags);
		$this->updateCounters(array('frequency'=>1),$criteria);
		foreach($tags as $name)
		{
			if(!$this->exists('name=:name',array(':name'=>$name)))
			{
				$tag=new Tag;
				$tag->name=$name;
				$tag->frequency=1;
				$tag->save();
			}
		}
	}

	public function removeTags($tags)
	{
		if(empty($tags))
			return;
		$criteria=new CDbCriteria;
		$criteria->addInCondition('name',$tags);
		$this->updateCounters(array('frequency'=>-1),$criteria);
		$this->deleteAll('frequency<=0');
	}
}