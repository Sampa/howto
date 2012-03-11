<script type="text/javascript">
/*<![CDATA[*/
$().ready(function() {
$('input[id*="Step_title"]').show();
$('label[for="Step_title"]').show();


elRTE.prototype.options.panels.myToolbar = ['bold', 'italic', 'underline',
'strikethrough','justifyleft','justifyright', 'justifycenter', 'justifyfull',
'insertorderedlist', 'insertunorderedlist', 'docstructure','paste','removeformat','link','unlink', 'elfinder', 'image', 'fullscreen'];
elRTE.prototype.options.toolbars.myToolbar = ['myToolbar'];
var opts = {
'doctype': '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">',
'cssClass':'el-rte',
'height': '100px',
'width': '500px',
'toolbar': 'maxi',
'absoluteURLs': false,
'allowSource': false,
'styleWithCSS': true,
'fmAllow': true,
'cssfiles':['/assets/7952073/css/elrte-inner.css'],
'fmOpen' : function(callback) {
$('<div class=".eltre" />').elfinder({
'url' : '/assets/7952073/connectors/php/connector.php?userid=1',
'dialog' : { width : 900, modal : true, title : 'Files' },
'closeOnEditorCallback' : true,
'editorCallback' : callback
}) }} ;
$('.eltre').elrte(opts);});
/*]]>*/
</script> 