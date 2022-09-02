<div id="addForm" title="Add New Task" style="background-color: #F6F6F6;">
	<form action="" method="post">
		<input name="matodo_addtask" id="matodo_addtask" value="true" type="hidden" />
		<input name="matodo_from" id="matodo_from" value="<?php echo self::get_user_id(); ?>" type="hidden" />
		<table>
			<tr>
				<td><label for="matodo_title">Title:</label></td>
				<td><input type="text" name="matodo_title" id="matodo_title" placeholder="Enter Title" required /></td>
			</tr>
			<tr>
				<td><label for="matodo_description">Description:</label></td>
				<td><textarea name="matodo_description" id="matodo_description" placeholder="Enter Description" required></textarea></td>
			</tr>
			<tr class="hidden">
				<td><label for="matodo_deadline">Deadline:</label></td>
				<td><input name="matodo_deadline" id="matodo_deadline" value="2022-12-31" type="date" required /></td>
			</tr>
			<tr>
				<td><label for="matodo_for">Assigned to:</label></td>
				<td><?php wp_dropdown_users("name=matodo_for&seleted"); ?> </select></td>
			</tr>
			<tr>
				<td><label for="matodo_status">Status:</label></td>
				<td>
					<select name="matodo_status" id="matodo_status" required>
						<option value="1">Pending</option>
						<option value="2">ReSolved</option>
					</select>
				</td>
			</tr>
			<tr class="hidden">
				<td><label for="matodo_priority">Priority:</label></td>
				<td>
					<select name="matodo_priority" id="matodo_priority" required>
						<option value="1" selected>Low</option>
						<option value="2">Normal</option>
						<option value="3">High</option>
						<option value="4">Important</option>
					</select>
				</td>
			</tr>
			<tr class="hidden">
				<td><label for="matodo_notify">Send alerts</label></td>
				<td><input name="matodo_notify" id="matodo_notify" value="1" type="checkbox" /></td>
			</tr>
			<!-- <tr>
				<td><button name="submit" type="submit" value="Add Task">Submit</button></td>
			</tr> -->
		</table>
	</form>
</div>
<script>
	jQuery(document).ready(function() {
		var dialog, form;

		form = jQuery("form");

		function formSubmit() {
			var errors;
			if (!jQuery("#matodo_title").val()) {
				jQuery("#matodo_title").addClass('ui-state-error');
				errors = 1;
			} else {
				jQuery("#matodo_title").removeClass('ui-state-error');
				errors = 0;
			}

			if (!jQuery("#matodo_description").val()) {
				jQuery("#matodo_description").addClass('ui-state-error');
				errors = 1;
			} else {
				jQuery("#matodo_description").removeClass('ui-state-error');
				errors = 0;
			}

			if (!jQuery("#matodo_deadline").val()) {
				jQuery("#matodo_deadline").addClass('ui-state-error');
				errors = 1;
			} else {
				jQuery("#matodo_deadline").removeClass('ui-state-error');
				errors = 0;
			}

			if (!errors) {
				form.submit();
				dialog.dialog("close");
			}
		}

		dialog = jQuery("#addForm").dialog({
			autoOpen: false,
			height: 400,
			width: 350,
			modal: true,
			buttons: {
				"Submit": formSubmit,
				Cancel: function() {
					form[0].reset();
					dialog.dialog("close");
				}
			},
			close: function() {
				form[0].reset();
				dialog.dialog("close");
			}
		});

		jQuery("#addTask-button").button().on("click", function() {
			dialog.dialog("open");
		});
	});
</script>