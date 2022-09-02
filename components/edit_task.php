<div id="editForm">
	<br>
	<h2><?php _e("Task #$id", 'matodo'); ?></h2>
	<br>
	<div class="hidden" id="timer"></div>
	<br>

	<form id="edit_form" action="" method="post">
		<input name="matodo_updatetask" id="matodo_updatetask" value="true" type="hidden" />
		<input name="matodo_taskid" id="matodo_taskid" value="<?php echo $id; ?>" type="hidden" />
		<table>
			<tr>
				<td><label for="matodo_title">Title:</label></td>
				<td><input name="matodo_title" id="matodo_title" value="<?php echo $matodo_edit_item['0']->title; ?>" type="text" /></td>
			</tr>
			<tr>
				<td><label for="matodo_description">Description:</label></td>
				<td><textarea name="matodo_description" id="matodo_description" rows="5" cols="40"><?php echo $matodo_edit_item['0']->desc; ?></textarea></td>
			</tr>
			<tr class="hidden" style="display: none;">
				<td><label for="matodo_date">Since:</label><br></td>
				<td>
					<h6 class="ui-state-error"><?php echo $matodo_edit_item['0']->date; ?> (<?php echo self::matodo_date($matodo_edit_item['0']->date); ?>)</h6>
				</td>
			</tr>
			<tr class="hidden" style="display: none;">
				<td><label for="matodo_deadline">Deadline:</label></td>
				<td><input name="matodo_deadline" id="matodo_deadline" value="<?php echo $matodo_edit_item['0']->until; ?>" type="date" /></td>
			</tr>
			<tr>
				<td><label for="matodo_for">Assigned to:</label></td>
				<td> <?php $for = $matodo_edit_item['0']->for;
						wp_dropdown_users("name=matodo_for&selected=$for"); ?>
					</select></td>
			</tr>
			<tr>
				<td><label for="matodo_status">Status:</label></td>
				<td> <select name="matodo_status" id="matodo_status">
						<option value="1" <?php if ($matodo_edit_item['0']->status == 1) echo "selected=\"selected\""; ?>>Pending</option>
						<option value="2" <?php if ($matodo_edit_item['0']->status == 2) echo "selected=\"selected\""; ?>>ReSolved</option>
					</select></td>
			</tr>
			<tr class="hidden" style="display: none;">
				<td><label for="matodo_priority">Priority:</label></td>
				<td> <select name="matodo_priority" id="matodo_priority">
						<option value="1" <?php if ($matodo_edit_item['0']->priority == 1) echo "selected=\"selected\""; ?>>Low</option>
						<option value="2" <?php if ($matodo_edit_item['0']->priority == 2) echo "selected=\"selected\""; ?>>Normal</option>
						<option value="3" <?php if ($matodo_edit_item['0']->priority == 3) echo "selected=\"selected\""; ?>>High</option>
						<option value="4" <?php if ($matodo_edit_item['0']->priority == 4) echo "selected=\"selected\""; ?>>Important</option>
					</select></td>
			</tr>
			<tr class="hidden" style="display: none;">
				<td><label for="matodo_notify">Send alerts through email?</label></td>
				<td><input name="matodo_notify" id="matodo_notify" class="form-control" value="1" <?php if ($matodo_edit_item['0']->notify == 1) echo "checked=\"checked\""; ?> type="checkbox" /></td>
			</tr>
		</table>
		<!-- table starts -->
		<table>
			<tbody>
				<tr style="border: 0">
					<td style="border: 0">
						<input name="Submit" value="Update" type="submit" />
	</form>
	</td>
	<td style="border: 0">
		<form action="" method="post">
			<input name="matodo_taskid" id="matodo_taskid" value="<?php echo $id; ?>" type="hidden" />
			<?php
			$delete = '<input name="matodo_deletetask" value="Delete" type="submit" />';
			\Inc\Pages\Admin::matodo_delete_button($delete);
			\Inc\Pages\Admin::matodo_cancel();
			?>
	</td>
	<td style="border: 0">
		<input name="cancel" value="Cancel" type="submit" />
		</form>
	</td>
	</tr>
	</tbody>
	</table>
	<!-- table ends -->
</div>