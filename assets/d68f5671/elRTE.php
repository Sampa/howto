<?php
class elRTE extends CInputWidget
{
   public $options = array();
   public $elfoptions = array();
   public $jui_elrte_css = "default";
   public $jui_elfinder_css = "default";
   public $userid;
   public function run()
   {
      $cs=Yii::app()->clientScript;
      
      $dir = dirname(__FILE__).DIRECTORY_SEPARATOR;
      $baseUrl = Yii::app()->getAssetManager()->publish($dir).'/elrte';
      $baseUrlE = Yii::app()->getAssetManager()->publish($dir).'/elfinder';
      list($name, $id) = $this->resolveNameID();
      if(isset($this->htmlOptions['id']))
      {
            $id=$this->htmlOptions['id'];
      } else {
            $this->htmlOptions['id']=$id;
      }
      if(isset($this->htmlOptions['name']))
      {
            $name=$this->htmlOptions['name'];
      } else {
            $this->htmlOptions['name']=$name;
      }

      $clientScript = Yii::app()->getClientScript();

      //$clientScript->registerCssFile($baseUrl.'/js/ui-themes/base/ui.all.css');
      if(!empty($this->jui_elrte_css))
      {
        if($this->jui_elrte_css == "default") //backward Compatibility
        {
            $clientScript->registerCssFile($baseUrl.'/css/elrte.full.css');
        } else {
            $clientScript->registerCssFile($baseUrl.'/css/'.$this->jui_elrte_css);
        }
      } else {
		$clientScript->registerCssFile($baseUrl.'/css/elrte.full.css');
	  }
     // $clientScript->registerCoreScript('jquery');
	  //$clientScript->registerCoreScript('jquery.ui');
            $clientScript->registerScriptFile($baseUrl.'/js/jquery-1.4.4.min.js',CClientScript::POS_HEAD);
      $clientScript->registerScriptFile($baseUrl.'/js/jquery-ui-1.8.7.custom.min.js',CClientScript::POS_HEAD);
      $clientScript->registerScriptFile($baseUrl.'/js/elrte.min.js',CClientScript::POS_HEAD);
	  
	  $clientScript->registerCssFile($baseUrl.'/css/smoothness/jquery-ui-1.8.13.custom.css');
      $clientScript->registerScriptFile($baseUrl.'/js/elrte.full.js',CClientScript::POS_HEAD);
	  

	  

      if (isset($this->options['lang']))
            $clientScript->registerScriptFile($baseUrl.'/js/i18n/elrte.'.$this->options['lang'].'.js',CClientScript::POS_HEAD);
      if (!isset($this->options['name']))
            $this->options['name'] = $name;
      
      if(!empty($this->options['cssfiles']))
      {
         $css_paths = array();
         foreach ($this->options['cssfiles'] as $cssf)
         {
             $css_paths[] = $baseUrl.'/'.$cssf;
         }
         $this->options['cssfiles'] = $css_paths;
      }

      //from here
      $elfopts = "";
      if(!empty($this->options['fmAllow']))
      {
            //$clientScript->registerCssFile($baseUrlE.'/js/ui-themes/base/ui.all.css');
            if(!empty($this->jui_elfinder_css))
              {
                if($this->jui_elfinder_css == "default") //backward Compatibility
                {
                    $clientScript->registerCssFile($baseUrlE.'/css/elfinder.css');
                } else {
                    $clientScript->registerCssFile($baseUrlE.'/css/'.$this->jui_elfinder_css);
                }
              } else {
			    $clientScript->registerCssFile($baseUrlE.'/css/elfinder.css');
			  }
            $clientScript->registerCssFile($baseUrlE.'/css/elfinder.css');
            $clientScript->registerScriptFile($baseUrlE.'/js/elfinder.min.js',CClientScript::POS_HEAD);
          if (isset($this->options['lang']) && !isset($this->elfoptions['lang']))
          {
              $clientScript->registerScriptFile($baseUrlE.'/js/i18n/elfinder.'.$this->options['lang'].'.js',CClientScript::POS_HEAD);
          } elseif(isset($this->elfoptions['lang'])) {
              $clientScript->registerScriptFile($baseUrlE.'/js/i18n/elfinder.'.$this->elfoptions['lang'].'.js',CClientScript::POS_HEAD);
          }

          if(!empty($this->elfoptions))
          {
              if($this->elfoptions['url'] == 'auto') $this->elfoptions['url'] =  $baseUrlE.'/connectors/php/connector.php?userid={$this->userid}';
              if(!empty($this->elfoptions['passkey'])) $this->elfoptions['url'] .= '?passkey='.urlencode($this->elfoptions['passkey']) ;
          }
          $elfopts = CJavaScript::encode($this->elfoptions);
      }

      //to here!
      $optsenc = CJavaScript::encode($this->options);
      if(!empty($elfopts)) $optsenc = str_replace('%elfopts%', $elfopts, $optsenc);
      $js="$().ready(function(){";
      $js.="var opts=";
      $js.= $optsenc;
      $js.=";";
      $js.="$('".$id."').elrte(opts);";
      $js.="})";

      $cs->registerScript($id,$js,CClientScript::POS_HEAD);
      echo '<textarea id="'.$id.'" name="'.$name.'" rows="5" cols="30">';
          echo $this->model['attributes'][$this->attribute];
      echo '</textarea>';
    }
}
?>
