<?php class ClientScript extends CClientScript
{
  protected $disabledCoreScripts = array();
 
  public function disableCoreScript($script)
  {
    $this->disabledCoreScripts[] = $script;
  }
 
  public function registerCoreScript($script)
  {
    if(array_search($script, $this->disabledCoreScripts) === false)
      return parent::registerCoreScript($script);
    else
      return $this;
  }
}?>