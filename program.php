<?php include('header.php'); ?>	
	<section id="content">
		<div class="container">
			<div id="program_header">
				Loopies Program
			<?php if (isset($_SESSION['admin'])) { ?>
				<button id="program_add_new" class="button right">+ Add New</button>
			<? } ?>
			</div>
			<div id="program_slot_container">
			<?php
				$sql_program = mysqli_query($conn, "SELECT * FROM program");
				while ($program = mysqli_fetch_array($sql_program)) { ?>
					<div class="program_slot"><img src="images/program/<?php echo $program['Gambar']; ?>"></div>
			<?php } ?>
			</div>
		</div>
		<div id="program_desc_bg">
		</div>
		<div id="program_desc_container">
			<img id="program_close" src="images/close.png">
		<?php if (isset($_SESSION['admin'])) { ?>
			<div id="program_admin_header"></div>
			<div id="normal_buttons">
				<button id="program_delete" class="button right pcg-btn">Delete</button>
				<button id="program_edit" class="button right pcg-btn">Edit</button>
			</div>
			<button id="program_save_edit" class="button right pcg-btn" style="display:none">Save</button>
		<? } ?>
		<?php
			$sql_program2 = mysqli_query($conn, "SELECT * FROM program");
			while ($program2 = mysqli_fetch_array($sql_program2)) { ?>
				<div class="program_desc">
					<img src="images/program/<?php echo $program2['Gambar']; ?>">
					<div id="gambar" style="display:none">
						<?php echo $program2["Gambar"]; ?>
					</div>
					<div id="program_name">
						<span id="name"><?php echo $program2['Nama']; ?></span>
					</div>
					<div id="program_host">
						Host : <span id="italic"><?php echo $program2['Host']; ?></span>
					</div>
					<div id="program_content">
						<span id="jadwal"><?php echo $program2['Jadwal']; ?></span>
						<br>
						<span id="desc"><?php echo $program2['Description']; ?></span>
					</div>
				</div>
		<?php } ?>
			<form method="POST" action="add.php" id="program_add" enctype="multipart/form-data">
				<table>
					<tr>
						<td>Gambar</td>
						<td>:</td>
						<td><input type="file" id="gambar" name="gambar" accept=image/*></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><div id="recomm">Recommended size is 250x130</div></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><input type="text" name="nama"></td>
					</tr>
					<tr>
						<td>Host</td>
						<td>:</td>
						<td><input type="text" name="host"></td>
					</tr>
					<tr>
						<td>Jadwal</td>
						<td>:</td>
						<td><input type="text" name="jadwal"></td>
					</tr>
					<tr>
						<td>Description</td>
						<td>:</td>
						<td><textarea id="program_text_area" class="program_add_text_area" name="desc" row="10" cols="25"></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><input type="submit" id="program_save_add" class="button right" value="Save"></td>
					</tr>
				</table>				
				<input type="text" name="mode" value="program" style="display:none">
			</form>
		</div>
	</section>
<?php include('footer.php'); ?>