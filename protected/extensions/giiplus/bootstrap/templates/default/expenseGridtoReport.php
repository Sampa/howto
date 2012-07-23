<?php echo"<?php";?> if ($model !== null):?>
<table border="1">

	<tr>
<?php
  foreach($this->tableSchema->columns as $column)
        {
  ?>
		<th width="80px">
		      <?php echo $column->name; ?>
		</th>
 <?php } ?>
	</tr>
	<?php echo "<?php";?> foreach($model as $row): ?>
	<tr>
        <?php
  foreach($this->tableSchema->columns as $column)
        {
          ?>
		<td>
			<?php echo "<?php"; ?> echo $row-><?php echo $column->name; ?>; ?>
		</td>
       <?php 
        }
     ?>
	</tr>
     <?php echo"<?php"; ?> endforeach; ?>
</table>
<?php echo"<?php";?> endif; ?>
