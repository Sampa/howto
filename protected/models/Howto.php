<?php

class Howto extends Model
{
	/**
	 * The followings are the available columns in table 'tbl_Howto':
	 * @var integer $id
	 * @var string $title
	 * @var string $content
	 * @var string $tags
	 * @var integer $status
	 * @var integer $create_time
	 * @var integer $update_time
	 * @var integer $author_id
	 */
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;
	const PRIVATE_STATUS=1;
	const PUBLIC_STATUS=2;

	private $_oldTags;
	public $image;
	public $files;
	public $categories;
	public $tag;


		/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		'author' => array( self::BELONGS_TO , 'User', 'author_id'),
		'comments' => array( self::HAS_MANY , 'Comment', 'howto_id', 'condition'=>'comments.status='.Comment::STATUS_APPROVED, 'order'=>'comments.create_time DESC'),
		'commentCount' => array( self::STAT , 'Comment', 'howto_id', 'condition'=>'status='.Comment::STATUS_APPROVED),
		'steps' => array(self::HAS_MANY, 'Step', 'howto_id', 'order'=>'position','together' => true,),
		'stepCount' => array( self::STAT , 'Step', 'howto_id', 'condition'=>''),
		'rating'=>array( self::BELONGS_TO, 'Rating', 'rating_id'),
		'category'=>array(self::MANY_MANY, 'Category', 'tbl_howto_category(howto_id,category_id)'),
		'tags'=>array(self::MANY_MANY, 'Tag', 'tbl_howto_tag(howto_id,tag_id)'),
		'attachments'=>array(self::HAS_MANY,'Files','howto_id','together'=>true),
	);
	}

    
    public function behaviors() {
        return array(

        );
    }
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
		return '{{howto}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content,tag,categories', 'required'),
			array('title', 'length', 'max'=>128),
			array('tag', 'match', 'pattern'=>'/^[\w\s,]+$/u', 'message'=>'Tags can only contain word characters.'),
			array('title, status', 'safe', 'on'=>'search'),
			
		);
	}
	public function findRecentHowtos( $limit ){
		
		$this->beginCriteria('created DESC');
		$today = new DateTime();
			$today->modify('-1 month'); 
			$compareDate = $today->format('Y-m-d');
		$criteria->addCondition( "created >" . $compareDate );

		return Howto::model()->with('steps')->findAll( $criteria , array( 'limit'=>10 ) );

}



	public function getTextStatus(){
		switch($this->status){
			case 1:
			return "Private";
			break;
			case 2:
			return "Public";
			break;
		}

	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
		);
	}
	
	/**
	 * @return string the URL that shows the detail of the Howto
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl( '/howto/view', 
			array(
				'id'=>$this->id,
				'title'=>$this->title,
			));
	}
	
	public function getLink($id)
	{
		$title = $this->howtoTitle($id);
		return CHtml::link($title , array('/howto/' . $id . '/' . $title ) );

	}
	
	public function getHowtoTitle($id)
	{
		$model = Howto::model()->findByPk($id);
		return $model->title;	
	
	}
	/**
	 * @return array a list of links that point to the Howto list filtered by every tag of this Howto
	 */
	public function getTagLinks()
	{
		$links = array();
		if(is_array ( $this->tags ))
		{
			foreach ( $this->tags as $tag ){
				$links[] = CHtml::link( CHtml::encode( $tag->name ), 
					array( 
						'/tag/'.$tag->name,
					)) . "&nbsp;";
										}
			return $links;
		}
	}
	public function getCategoryLinks()
	{
		$links = array();
		if(is_array ( $this->category ))
		{
			foreach( $this->category as $category )
			{
				$links[] = CHtml::link( CHtml::encode( $category->name ), 
				array( 
					'/category/'.$category->name,
					)) . "&nbsp;";
			}
			return $links;
		}
	}

	public function related()
	{
		$related = false;
		$objects = array();
		if (count($this->category) > 0 && count($this->tag > 0))
			{
				$related = array();
				foreach ( $this->category as $category )
				{
					$objects = array_merge($objects,$category->howtos);
					
				}
				if(is_array($this->tag)){
					foreach ( $this->tag as $tag )
					{
						$objects = array_merge($objects,$tag->howtos);
						
					}
				}
				foreach($objects as $related_howto)
				{
					if($related_howto->id == $this->id)
						continue;
					if(isset($related_howto->id)){
					$link = CHtml::link($related_howto->title , array('/howto/' . $related_howto->id . '/' . $related_howto->title ),array('class'=>'jsrp_title', 'rel'=>'bookmark' ));

					if( isset($related[$link])){
						$related[$link] = $related[$link]+ 1;						
					}else{ $related[$link]= 1; }
					}
				}
			$related = array_slice($related,0,4,true); //starts with first, takes 4, keeps same keys 
			}
		
		return $related;
	}
	/**
	 * Normalizes the user-entered tags.
	 */

	/**
	 * Adds a new comment to this Howto.
	 * This method will set status and Howto_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment( $comment )
	{
		if ( Yii::app()->params['commentNeedApproval'] )
			$comment->status = Comment::STATUS_PENDING;
		else
			$comment->status = Comment::STATUS_APPROVED;
		$comment->howto_id = $this->id;
		return $comment->save();
	}


	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		parent::afterFind();
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if ( parent::beforeSave() )
		{
			if ( $this->isNewRecord )
			{
				$this->create_time = $this->update_time = time();
				$this->author_id = Yii::app()->user->id;
				if($_POST['Howto']['status'] == 1){
					$this->status = 1;
				}else{$this->status = 2;}
			}
			else
				$this->update_time = time();
			return true;
		}
		else
			return false;
	}
	public function getRatingObject(){
		return Rating::model()->findByPk($this->rating_id);			
	}
	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		parent::afterSave();
		if(!$this->status == 1){
		$title = $this->howtoTitle($this->id);
		$tags = $this->tagLinks();
		$title = CHtml::link('Created '.$title , array('/howto/' . $this->id . '/' . $title ) );
		$shortText = substr($this->content,0,160);
		$content = $shortText."...<br/>Tags:";
		foreach($tags as $tag){
			$content .=" ".$tag.",";
		}
		Action::newAction($content,$title);
		}
		
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
		Comment::model()->deleteAll( 'howto_id=' . $this->id );
		Bookmark::model()->deleteAll( 'howto_id=' . $this->id );
		HowtoCategory::model()->deleteAll( 'howto_id=' . $this->id );
  		Slide::model()->deleteAll( 'howto_id=' . $this->id );
		Step::model()->deleteAll( 'howto_id=' . $this->id );
		HowtoTag::model()->deleteAll( 'howto_id=' . $this->id );
	}

	public function attachmentArray($data){
			if ( is_array($data) ) {
			return $data;
			} else if ( $data !== null ) {
			return array($data);
			} else {
			return array();
		}
	}
	/**
	 * Retrieves the list of howto- based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed howto-.
	 */
	
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare( 'title' , $this->title , true );

		$criteria->compare( 'status' , $this->status );

		return new CActiveDataProvider( 'Howto' ,
			array(
				'criteria'=>$criteria,
				'sort'=>array(
					'defaultOrder'=>'status, update_time DESC',
					),
				));
	}
}