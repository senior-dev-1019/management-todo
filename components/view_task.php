<br>
<h2><?php _e("Task #$id", 'matodo'); ?></h2>
<br>
<div class="hidden" id="timer"></div>
<br>
<h5 class="title"><?php echo $matodo_view_item['0']->title; ?></h5>
<p class="desc"><?php echo $matodo_view_item['0']->desc; ?></p>
<p>By <strong><?php echo self::matodo_from((int) $matodo_view_item['0']->from); ?></strong> on <em><?php echo self::matodo_date($matodo_view_item['0']->date); ?></em> Deadline <em><?php echo self::matodo_date($matodo_view_item['0']->until); ?></em>, currently assigned to <em><strong><?php echo self::matodo_from((int) $matodo_view_item['0']->for); ?></strong></em></p>
<br>
<?php
if ($matodo_view_item_comments) {
	echo "<h6>Comments</h6>";
	$matodo_counted = count($matodo_view_item_comments);
	$c = 0;
	echo '<p><ol>';
	while ($c != $matodo_counted) {
		echo '<li><p>' . $matodo_view_item_comments["$c"]->body . '</p>
									<small>On ' . self::matodo_date($matodo_view_item_comments["$c"]->date) . ' by ' . self::matodo_from((int) $matodo_view_item_comments["$c"]->from) . '</small></li>';
		$c++;
	}
	echo '</ol></p>';
}
\Inc\Pages\Admin::matodo_cancel();
?>
<br>
<form action="" id="matodo_addnewcomment" method="post">
	<input name="matodo_comment_author" type="hidden" value="<?php echo \Inc\Pages\Admin::get_user_id(); ?>" />
	<input name="matodo_comment_task" type="hidden" value="<?php echo $matodo_view_item['0']->id; ?>" />
	<!--table starts-->
	<table>
		<tr>
			<td><textarea cols="40" rows="5" name="matodo_comment_body" id="matodo_comment_body" placeholder="Add a Comment" required></textarea></td>
		</tr>
		<tr>
			<td>
				<input name="matodo_comment_submit" id="matodo_comment_submit" value="Add" type="submit">
			</td>
</form>
<td>
	<form action="" method="post">
		<input name="cancel" value="Cancel" type="submit" />
	</form>
</td>
</tr>
</table>
<!--table Ends-->
<?php
\Inc\Pages\Admin::matodo_countdown_timer(self::matodo_date($matodo_view_item['0']->until), $matodo_view_item['0']->status);
?>