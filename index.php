<?php include('header.php'); ?>
	<section id="content">
		<div id="slideshow">
		<?php
			$slide_query = mysqli_query($conn, "SELECT * FROM slideshow");
			while ($slide = mysqli_fetch_array($slide_query)) { ?>
				<img src="images/<?php echo $slide['Gambar']; ?>">
		<?php } ?>
		</div>
		<?php if (isset($_SESSION["admin"])) { ?>
			<div class="slideshow">
				<div id="normal_buttons">
					<button id="slide_add_btn" class="button right pcg-btn">Add</button>
					<button id="slide_edit_btn" class="button right pcg-btn">Edit</button>
				</div>
				<div id="slide_admin">
					<div id="slide_header"></div>
					<form action="add.php" method="POST" id="slide_add" enctype="multipart/form-data">
						<table>
							<tr>
								<td>Gambar</td>
								<td>:</td>
								<td><input type="file" name="gambar" accept=image/*></td>
							</tr>
						</table>
						<div id="slide_add_btn_container">
							<input type="button" id="slide_add_cancel" class="button right" value="Cancel">
							<input type="submit" id="slide_save_add" class="button right" value="Add">
						</div>
						<input type="text" name="mode" value="slide" style="display:none">
					</form>
					<div id="slide_edit">
					<?php
						$slide_edit_query = mysqli_query($conn, "SELECT * FROM slideshow");
						$i = 0;
						while ($slide_edit = mysqli_fetch_array($slide_edit_query)) { 
							$i++;
					?>
							<form action="edit.php" method="POST">
								<table>
									<tr>
										<td>Slide <?php echo $i; ?></td>
										<td>:</td>
										<td><?php echo $slide_edit["Gambar"];?></td>
										<td><input type="submit" class="button" value="Delete"></td>
									</tr>
								</table>
								<input type="text" name="mode" value="slide" style="display:none">
							</form>
					<?php
						}
					?>
						<div id="slide_edit_cancel_container">
							<button id="slide_edit_cancel" class="button right">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<div id="index_event_container">
			<div id="index_event_header">
				EVENT
			</div>
			<div id="index_event_content_container">
				<!--<div class="index_event_content">
					<img src="images/event/dara2-r.jpg">
					<div><span>Dara</span></div>
				</div>
				<div class="index_event_content">
					<img src="images/event/cl-r.jpg">
					<div>CL</div>
				</div>
				<div class="index_event_content">
					<img src="images/event/bom-r.jpg">
					<div>Bom</div>
				</div>
				<div class="index_event_content">
					<img src="images/event/minzy-r.jpg">
					<div>Minzy</div>
				</div>
				<div class="index_event_content">
					<img src="images/event/dara-r.jpg">
					<div>Dara</div>
				</div>-->
			<?php
				$sql_index_event = mysqli_query($conn, "SELECT * FROM event ORDER BY ID DESC");
				while ($index_event = mysqli_fetch_array($sql_index_event)) { ?>
					<div class="index_event_content">
						<img src="images/event/<?php echo $index_event["Gambar"]; ?>">
						<div>
							<a href="event?get=<?php echo $index_event["Nama"]; ?>">
							<span>
								<?php echo $index_event["Nama"]; ?>
							</span>
							</a>
						</div>
					</div>
			<?php } ?>
			</div>
		</div>
	</section>
<?php include('footer.php'); ?>