
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
function getCreate(){
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
getCreate();
$('#dialogCreate').modal('show');
return false; 
});
</script>
<!-- end -->
