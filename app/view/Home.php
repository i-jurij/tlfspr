<div class="content">
	 <div style="text-align: left;">
	<?php
    if (file_exists(PUBLICROOT.DS.'templates'.DS.'add_contact.html')) {
        echo getOutput(PUBLICROOT.DS.'templates'.DS.'add_contact.html');
    }
	?>
	</div>
	<?php
	if (!empty($data['page_db_data'][0]['page_content'])) { ?>
		<div>
			<?php
	        if (is_array($data['page_db_data'][0]['page_content'])) {?>
				<table class="table">
					<colgroup>
					<col width="10%">
					<col width="30%">
					<col width="30%">
					<col width="30%">
					</colgroup>
					<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Phone</th>
						<th>Actions</th>
					</tr>
					</thead>
					<tbody>
					<?php
	                foreach ($data['page_db_data'][0]['page_content'] as $name => $tel) {
	                    $format_name = mb_convert_case(mbStrReplace('_', ' ', $name), MB_CASE_TITLE);
	                    $i = 1;
	                    ?>
						<tr>
						<td><?php echo $i; ?></td>
						<td style="text-align:left"><?php echo $format_name; ?></td>
						<td><?php echo phone_number_view($tel); ?></td>
						<td>
							<a class="buttons" href="<?php echo URLROOT; ?>/Contact/delete/<?php echo $name; ?>/">Delete</a>
							<a class="buttons" href="<?php echo URLROOT; ?>/Contact/update/<?php echo $name; ?>/">Update</a>
						</td>
						</tr>
						<?php
	                    ++$i;
	                }
	            ?>
					</tbody>
				</table>
				<?php
	        } else {
	            echo htmlentities($data['page_db_data'][0]['page_content']);
	        }
	    ?>
		</div>
		<?php
	}
	?>
</div>