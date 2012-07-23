<?php

/**
 * This is the model class for table "{{files}}".
 *
 * The followings are the available columns in table '{{files}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $howto_id
 * @property string $filename
 */
class Files extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return files the static model class
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
		return '{{files}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, howto_id, filename', 'required'),
			array('user_id, howto_id', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
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
	static function checkFiles($files)
	{
		$return = array();
		$files = explode( ',',$files );
		foreach( $files as $file )
		{

			if( Yii::app()->file->set('files/users/'.Yii::app()->user->id.'/'.$file)->exists  && $file !== "")
			{
				$return[] = $file;	
			}
		}	
		return $return;
	
	}
	static function workOnFile($file,$attachto)
	{

		if( Yii::app()->file->set('files/users/'.Yii::app()->user->id.'/'.$file)->exists  && $file !== "")
				{
					$model = new Files;
					$model->user_id = Yii::app()->user->id;
					$model->howto_id = $attachto;
					$model->filename = $file;
					$model->save();
				}
	}
	static function workOnFiles($files,$attachto)
	{
		$files = Files::checkFiles($files);

		foreach($files as $file)
		{
			$files = new Files;
			$files->user_id = Yii::app()->user->id;
			$files->howto_id = $attachto;
			$files->filename = $file;
			$files->save();
		}
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'howto_id' => 'Howto',
			'filename' => 'Filename',
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
		$criteria->compare('howto_id',$this->howto_id);
		$criteria->compare('filename',$this->filename,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}