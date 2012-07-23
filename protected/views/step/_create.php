
<?php $this->beginWidget('BootModal', array(
    'id'=>'dialogCreate',
    'htmlOptions'=>array('class'=>'hide','style'=>'width:auto;'),
    'events'=>array(
        'show'=>"js:function() { console.log('dialogLogin show.'); }",
        'shown'=>"js:function() { console.log('dialogLogin shown.'); }",
        'hide'=>"js:function() { console.log('dialogLogin hide.'); }",
        'hidden'=>"js:function() { console.log('dialogLogin hidden.'); }",
    ),
)); ?>

<div id="modal_create" class="divForForm well" style="padding:25px;">

</div>
<?php $this->endWidget(); ?> 
<script type="text/javascript">
function createStep(){
  <?php echo CHtml::ajax(array(
            'url'=>array('/step/create?howto_id='.$howto),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'render')
                {
                    $('#modal_create').html(data.div );
			var myNicEditor = new nicEditor({uploadURI:'/nic/upload.php?hej=".$howto."'});
			myNicEditor.setPanel('Step_panel');
			myNicEditor.addInstance('Step_text');
		
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogCreate div.divForForm form').submit(getCreate);
                }
                else
                {  /* $('#dialogCreate').modal('close') */
                    $('#dialogCreate div.succesDiv').html(data.div);
                }
 
            }",
            )); ?>
}

$("#createButton").click(function(){
createStep();
$('#dialogCreate').modal('show');
return false; 
});
</script>
<!-- end -->

