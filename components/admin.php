	<div class="wrap">
		<br>
		<h2 style="text-align: center"><?php _e("To Do Management", 'matodo'); ?></h2>
		<br>
		<?php
		\Inc\Pages\Admin::matodo_add_button();
		?>
		<table id="todo" class="display" style="width:100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Submitter</th>
					<th>Asigned</th>
					<th>Status</th>
					<th>Quick Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				self::matodo_tasks();
				?>
			</tbody>
		</table>
	</div>
	<?php
	\Inc\Pages\Admin::matodo_add_form();
	?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#todo').DataTable({
				responsive: true
			});
		});
	</script>