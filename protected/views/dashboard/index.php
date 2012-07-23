<?php 
	$accessCheckStatement  = !Yii::app()->user->isGuest;
	$adminCheck = ($accessCheckStatement) ? true : false;
	?>
	<?php $this->layout = "column1"; ?>
    <?php
	$assets = dirname(__FILE__) . '';
        $baseUrl = Yii::app() -> assetManager -> publish($assets);
        if (is_dir($assets)) {
            //the css to use
			// the js to use
			    Yii::app() -> clientScript -> registerScriptFile($baseUrl . "/jquery.easy-confirm-dialog.js", CClientScript::POS_BEGIN);
			}
			
	?>

<div id="dashboard-index">
	<div id="update-form-wrapper"></div>

	<div id="portlets_wrapper" style="padding:20px;min-height:600px;">
		<a href="#" id="show-form"><i class="icon-plus"></i></a>
		<a href="#" id="show-active"><i class="icon-wrench"></i></a>

		<div id="updateportletelements" >
			<h5>Title:</h5>
			<input id="updateportlettitle"></input><br/>
			
			<h5>Content:</h5>
			<textarea  id="updateportletcontent"></textarea>
			
			<h5>Render view</h5>
			<textarea  id="updateportletrender"></textarea>
			
			<div>
				<button class="btn btn-primary btn-mini" id="saveportletcontent">Save</button>
				<button class="btn btn-primary btn-mini" id="hide-form">Hide</button>
				<br/>
			</div>
		</div>
		<div id="active-form" >
			<?php $this->renderPartial('_activeform' ,array('adminCheck'=>$adminCheck) );?>
		</div>
		<div id="form-wrapper">
			<?php  $this->renderPartial('_form',array('model'=>$model));?>
		</div>
		<div id="portletsUpdated"></div>
			<?php $array1 = 1; $array2 = 2;?>
		<?php $this->widget('bootstrap.widgets.BootThumbnails', array(
				'dataProvider'=>$dataProvider,
				'viewData'=>array('renderProperties'=>$renderProperties),
				'template'=>"{items}",
				'itemView'=>'_portlet',
		)); ?>
			
	</div>
		
	<style type="text/css">
		#updateportletelements,#form-wrapper,#active-form{display:none;}
		#portlets{display:inline; list-style:none;}
		.portletcontent{clear:both;min-width:200px; min-height:250px; border-top:3px ridge #0088cc; margin-top:5px; padding-top:5px;} 
		.maximized{ position:absolute; left:0; top:0;z-index:100;}
		.portlettitlediv{float:left; padding:6px 6px 10px 6px;}
		.thumbnail a {float:right;padding:6px 5px 0px 0px;}
	</style>
	<script type="text/javascript">
	$(document).ready(function(){
			$(".delete_portlet").easyconfirm({locale: { title: 'Select Yes or No', button: ['No','Yes']}});

		/*deactivate a visible portlet (hide link)*/
		$(".hideportlet").click(function(){
		var id = $(this).parent().parent("li").attr('id');
		$.ajax({
			  type: "POST",
			  url: "/dashboard/deactivateportlet",
			  data: {id:id},
			}).done(function( data ) {
					$("#form-wrapper").fadeOut();
					reloadPortlets();
				});
		});
		/* show active options */
		
		$("#show-active").click(function(){

			$("#active-form").slideToggle(200);
		});
		/* deleting a portlet */
		$(".delete_portlet").click(function(){

			var id = $(this).attr('name');
			$.ajax({
			  type: "POST",
			  url: "/dashboard/delete",
			  data: {id:id}
			}).done(function( data ) {
					$('#'+id).remove();
					reloadPortlets();
					
			});
		});
		/*updating the content of a portlet*/
		
		$(".portletcontent").click(function(){
		var id = $(this).attr('name');
			$("#updateportletcontent").html($(this).find(".contentwrapper").html());
			$("#updateportletcontent").attr('name',$(this).attr('name'));
			$("#updateportlettitle").val($("span[name=portlettitle"+id+"]").html());
			$("#updateportletrender").val(	$("#render"+id).html());
			$("#updateportletelements").fadeIn();
		});
		$("#hide-form").click(function(){
			$("#updateportletelements").fadeOut();
		});
		$("#saveportletcontent").click(function(){
			var content = 	$("#updateportletcontent").val();
			var title = $("#updateportlettitle").val();
			var id = $("#updateportletcontent").attr('name');
	
			$.ajax({
			  type: "POST",
			  url: "/dashboard/updateportletcontent",
			  data: {content:content,title:title,id:id},
			}).done(function( data ) {
					$("#form-wrapper").fadeOut();
					$("#updateportletelements").fadeOut();
			reloadPortlets();

			});
		});
		/* Submitting the  create/update form*/
		$("#dashboard-form").submit(function(event){
		event.preventDefault();
			console.log($(".form-actions").find("button").val());
			$.ajax({
			  type: "POST",
			  url: "/dashboard/create",
			  data: $(this).serialize(),
			}).done(function( data ) {
					$("#form-wrapper").fadeOut();
					reloadPortlets();
			});
	});
	/* Submitting the active-portlets-form form*/
	$("#active-portlets-form").submit(function(event){
	event.preventDefault();
		console.log($(this));
		$.ajax({
		  type: "POST",
		  url: "/dashboard/active",
		  data: $(this).serialize(),
		}).done(function( data ) {
			reloadPortlets();
		});
});

		/*some init */

		$(".thumbnails").attr('id','portlets');
		$("#portlets").sortable();
		/* runs after each sorting */
		$("#portlets").bind( "sortupdate", function(event, ui) {
		updatePortletsPos();
		});
		/* toggle content view*/
		$(".toggle").click(function(){
			$(this).siblings(".portletcontent").slideToggle(200);
			$(this).parent().removeClass('maximized');
			$(this).parent().attr('style','');
		});
		/* toggle maximizing class */
		$(".maximize").click(function(){
		
		var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],width=w.innerWidth||e.clientWidth||g.clientWidth,height=w.innerHeight||e.clientHeight||g.clientHeight, fixedWidth = width-35, fixedHeight = height-10,style = 'min-width:'+fixedWidth+'px; min-height:'+fixedHeight+'px;';
			$(this).siblings(".portletcontent").fadeIn();
			if($(this).parent().hasClass('maximized')){
				$(this).parent().removeClass('maximized');
				$(this).parent().attr('style','');
				}else{
				$(this).parent().attr('style',style);
				$(this).parent().addClass('maximized');
			}
		});
		/* show form */
		$("#show-form").click(function(){
			$("#form-wrapper").slideToggle(200);
		});
		
	});

	/* js functions  */
		function reloadPortlets(){
					$.ajax({'url':'/dashboard/index','cache':false,'success':function(html){jQuery("#dashboard-index").html(html)}});		
		}

		function updatePortletsPos() {
			var pos = $("#portlets").sortable('toArray');
			var url = '/dashboard/updatePortlets';
		 
			jQuery.getJSON(url, {pos: pos}, function(data) {
				if (data.status == 'success') {
				}
			});
			return false;
		}

	</script>
</div> <!-- dashboard-index-->
