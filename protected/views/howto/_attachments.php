<?php  Yii::app()->clientScript->registerScriptFile('/js/elfinder.min.js');
$ClientScript = Yii::app()->getClientScript();        
$ClientScript->registerScriptFile("/js/jquery-ui-1.8.13.custom.min.js");
?>

<div id="currentcontentholder" class="span9 well" style="z-index:9999; display:none;position:absolute; top:30%;left:60px;margin-left:0px; padding:10px;">
	<a id="closecontent"><i class="icon-remove" ></i></a>
	<div id="currentContent">
		    <h3>Manage attachments</h3>

		<div class="span12" >
					<?php
				Yii::app()->user->setFlash('success', 'Drag&drop files from your filelibrary to add them to this howto! ');
				$this->widget('bootstrap.widgets.BootAlert'); 
			?>
				<ul id="selectedfiles">

				</ul>

				<div id="droppable" class="well" style="min-width:82%;">
					<h1> DROP FILES HERE </h1>
				</div>
			
			<?php
				Yii::app()->user->setFlash('success', 'This is your personal filelibrary<br/>
					All files you upload and changes you make will be saved for your next visit<br/> Upload files by dragging them from your computer to the filelibrary or use the upload button.<br/>');
				$this->widget('bootstrap.widgets.BootAlert'); 
			?>

				<div id="elfinder"></div>
		</div>
	</div>
</div>
<script type="text/javascript" >
/* FILES */
function removeItem(array, item){
    for(var i in array){
        if(array[i]==item){
            array.splice(i,1);
            break;
            }
    }
}

function foundFile(name){
$('<li class="del_file" id="'+name+'">'+name+' <span>Remove</span></li>').prependTo("#selectedfiles");
$("#Howto_files").val($("#Howto_files").val()+name + ',');
}

$(".del_file").live('click', function(){
	var name = $(this).attr('id');
	var array = $("#Howto_files").val().split(',');
	removeItem(array,name);
	array.toString();
	$("#Howto_files").val(array);
	console.log(name);
	console.log($("#"+name));
	$(this).remove();
	
});
/* END FILES */
	$().ready(function() {
		$("#closecontent").click(function(){
			$("#currentcontentholder").hide();
		});

	$('#attachments').click(function(){
		$("#currentcontentholder").show();
	});	
	
	 $("#droppable").droppable({

		drop: function(event,ui) { foundFile(ui.draggable.parent().find(".elfinder-cwd-filename").html()); }
    });
		var elf = $('#elfinder').elfinder({
			url : '/connectors/connector.php?userid=1',  // connector URL (REQUIRED)
			contextmenu : {
			// navbarfolder menu
			navbar : ['open', '|', 'copy', 'cut', 'paste', 'duplicate', 'info'],

			// current directory menu
			cwd    : ['reload', 'back', '|', 'upload', 'mkfile', 'paste', '|', 'info'],

			// current directory file menu
			files  : [
				'getfile', '|','open', 'quicklook', '|', 'delete', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|',
		'|', 'edit', 'resize', '|', 'info'
			]
			},
			uiOptions : {
			toolbar : [
			['back', 'forward'],
			 ['reload'],
			// ['home', 'up'],
			[ 'mkfile', 'upload'],
			['open', 'download', 'getfile'],
			['info'],
			['quicklook'],
			['copy', 'cut', 'paste'],
			['edit', 'resize'],
			['help']
		],}
		}).elfinder('instance');			
	});
</script>

<!-- Element where elFinder will be created (REQUIRED) -->
<style type="text/css">
#droppable{
background-color:#0088CC;
max-width:50%;
padding:50px;
 }

 #droppable h1{
 color:#fff;
text-align:center;

 }
.del_file span{
color:#0088CC;
}
</style>