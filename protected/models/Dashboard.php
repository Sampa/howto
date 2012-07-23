<?php

/**
 * This is the model class for table "{{dashboard}}".
 *
 * The followings are the available columns in table '{{dashboard}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property integer $position
 * @property string $render
 */
class Dashboard extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Dashboard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public static function renderProperties()
	{
		return array(
					'_example'=>array('parameter'=>'Example of passing info'),
				);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dashboard}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('content,render,active','safe'),
			array('user_id, position', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, title, content, position, render', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'title' => 'Title',
			'content' => 'Content',
			'position' => 'Position',
			'render' => 'Render this view together with content:',
		);
	}

	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('render',$this->render,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}