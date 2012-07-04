
<?php



class LatestKnowledge extends CWidget
{
	public $title='';
	public $maxTags=20;
  public function init() {
        parent::init();
    }

    public function run() {
	
       $this->render("latestknowledge",array());

    }

}
?>