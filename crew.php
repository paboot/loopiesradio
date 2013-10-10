<?php include('header.php'); ?>	
	<section id="content">
	<?php
		// Jumlah row per page
		$rowsperpage = 9;
		
		// Nyari banyak row
			$sql_count = mysqli_query($conn, "SELECT COUNT(*) FROM crew");
			$r = mysqli_fetch_row($sql_count);
			$numrows = $r[0];
			
		// Total page
		$totalpages = ceil($numrows / $rowsperpage);
		
		// Get current page or set a default
		if (isset($_GET['page']) && is_numeric($_GET['page'])) {
		   // cast var as int
		   $page = (int) $_GET['page'];
		} else {
		   // default page
		   $page = 1;
		}
		
		// if current page is greater than total pages...
		if ($page > $totalpages) {
		   // set current page to last page
		   $page = $totalpages;
		}
		// if current page is less than first page...
		if ($page < 1) {
		   // set current page to first page
		   $page = 1;
		}
		
		// the offset of the list, based on current page 
		$offset = ($page - 1) * $rowsperpage;
	?>
		<div class="container">
			<div id="crew_header">
				Loopies Radio Crew
			<?php if (isset($_SESSION['admin'])) { ?>
				<button id="crew_add_new" class="button right">+ Add New</button>
			<? } ?>
			</div>
			<div id="crew_slot_container">
			<?php
				$sql_crew = mysqli_query($conn, "SELECT * FROM crew ORDER BY ID DESC LIMIT $offset, $rowsperpage");
				while ($crew = mysqli_fetch_array($sql_crew)) { ?>
					<div class="crew_slot"><img src="images/crew/<?php echo $crew['Gambar']; ?>"></div>
			<?php } ?>
			</div>
			<?php
			/* --- Pagination linksss --- */
			$range = 5;
			
			echo "<div id='pagination'>";
			// if not on page 1, don't show back links
			if ($page > 1) {
			   // show << link to go back to page 1
			   echo " <a href='http://localhost/loopies/crew?page=1'><<</a> ";
			   // get previous page num
			   $prevpage = $page - 1;
			   // show < link to go back to 1 page
			   echo " <a href='http://localhost/loopies/crew?page=$prevpage'><</a> ";
			}
			
			// loop to show links to range of pages around current page
			for ($x = ($page - $range); $x < (($page + $range) + 1); $x++) {
			   // if it's a valid page number...
			   if (($x > 0) && ($x <= $totalpages)) {
				  // if we're on current page...
				  if ($x == $page) {
					 // 'highlight' it but don't make a link
					 echo " <b>$x</b> ";
				  // if not current page...
				  } else {
					 // make it a link
					 echo " <a href='http://localhost/loopies/crew?page=$x'>$x</a> ";
				  }
			   }
			}
							 
			// if not on last page, show forward and last page links        
			if ($page != $totalpages) {
			   // get next page
			   $nextpage = $page + 1;
				// echo forward link for next page 
			   echo " <a href='http://localhost/loopies/crew?page=$nextpage'>></a> ";
			   // echo forward link for lastpage
			   echo " <a href='http://localhost/loopies/crew?page=$totalpages'>>></a> ";
			}
			
			echo "</div>";
			?>
		</div>
		<div id="crew_desc_bg">
		</div>
		<div id="crew_desc_container">
			<img id="crew_close" src="images/close.png">
		<?php if (isset($_SESSION['admin'])) { ?>
			<div id="crew_admin_header"></div>
			<div id="normal_buttons">
				<button id="crew_delete" class="button right pcg-btn">Delete</button>
				<button id="crew_edit" class="button right pcg-btn">Edit</button>
			</div>
			<button id="crew_save_edit" class="button right pcg-btn" style="display:none">Save</button>
		<? } ?>
		<?php
			$sql_crew2 = mysqli_query($conn, "SELECT * FROM crew ORDER BY ID DESC LIMIT $offset, $rowsperpage");
			while ($crew2 = mysqli_fetch_array($sql_crew2)) { ?>
				<div class="crew_desc">
					<div id="crew_img">
						<a href="http://localhost/loopies/images/crew/<?php echo $crew2['Gambar']; ?>" target="_blank">
							<img src="images/crew/<?php echo $crew2['Gambar']; ?>">
						</a>
					</div>
					<div id="crew_name">
						<span id="name"><?php echo $crew2['Nama']; ?></span>
					</div>
					<div id="ID" style="display:none">
						<?php echo $crew2["ID"]; ?>
					</div>
					<div id="gambar" style="display:none">
						<?php echo $crew2["Gambar"]; ?>
					</div>
				</div>
		<?php } ?>
			<form method="POST" action="add.php" id="crew_add" enctype="multipart/form-data">
				<table>
					<tr>
						<td>Gambar</td>
						<td>:</td>
						<td><input type="file" id="gambar" name="gambar" accept=image/*></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><input type="text" name="nama"></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><input type="submit" id="crew_save_add" class="button right" value="Save"></td>
					</tr>
				</table>				
				<input type="text" name="mode" value="crew" style="display:none">
			</form>
		</div>
	</section>
<?php include('footer.php'); ?>