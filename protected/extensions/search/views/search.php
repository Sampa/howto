
    <form id="searchForm" method="post">
           	<input id="search" type="text" style="float:left;" class="ac_input" style="" 
			value="Search how2.com"  />
            <button class="btn btn-primary" id="searchbutton" style="position:absolute; right:9px;">
				<i class="icon-search icon-white"></i> Search
			</button>            
    </form>

    <div id="resultsDiv"></div>
	<script type="text/javascript">
	$("#search").click(function(){
		$("#search").val('');
	});
	</script>
