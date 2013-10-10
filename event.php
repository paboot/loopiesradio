<?php include('header.php'); ?>	
	<section id="content">
	<?php if(!isset($_GET['get'])) { ?>
	<?php
		// Jumlah row per page
		$rowsperpage = 9;
		
		// Nyari banyak row
			$sql_count = mysqli_query($conn, "SELECT COUNT(*) FROM event");
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
			<div id="event_header">
				Hot Events
			<?php if (isset($_SESSION['admin'])) { ?>
				<button id="event_add_new" class="button right">+ Add New</button>
			<? } ?>
			</div>
			<div id="event_slot_container">
			<?php
				$sql_event = mysqli_query($conn, "SELECT * FROM event ORDER BY ID DESC LIMIT $offset, $rowsperpage");
				while ($event = mysqli_fetch_array($sql_event)) { ?>
					<div class="event_slot">
						<a href="event?get=<?php echo $event['Nama']; ?>">
							<img src="images/event/<?php echo $event['Gambar']; ?>" title="<?php echo $event['Nama']; ?>">
						</a>
					</div>
			<?php } ?>
			</div>
			<?php
			/* --- Pagination linksss --- */
			$range = 5;
			
			echo "<div id='pagination'>";
			// if not on page 1, don't show back links
			if ($page > 1) {
			   // show << link to go back to page 1
			   echo " <a href='http://localhost/loopies/event?page=1'><<</a> ";
			   // get previous page num
			   $prevpage = $page - 1;
			   // show < link to go back to 1 page
			   echo " <a href='http://localhost/loopies/event?page=$prevpage'><</a> ";
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
					 echo " <a href='http://localhost/loopies/event?page=$x'>$x</a> ";
				  }
			   }
			}
							 
			// if not on last page, show forward and last page links        
			if ($page != $totalpages) {
			   // get next page
			   $nextpage = $page + 1;
				// echo forward link for next page 
			   echo " <a href='http://localhost/loopies/event?page=$nextpage'>></a> ";
			   // echo forward link for lastpage
			   echo " <a href='http://localhost/loopies/event?page=$totalpages'>>></a> ";
			}
			
			echo "</div>";
			?>
			<div id="event_add_form_container">
				<div id="event_add_header">
					Add Data
				</div>
				<form action="add.php" method="POST" id="event_add_form" enctype="multipart/form-data">
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
							<td>Content</td>
							<td>:</td>
							<td><textarea id="event_add_textarea" name="content" rows="7" cols="40"></textarea></td>
						</tr>
					</table>
					<input type="text" name="mode" value="event" style="display:none">
					<div id="event_add_btn_container">
						<input type="button" class="button right" id="event_add_cancel" value="Cancel">
						<input type="submit" class="button right" value="Save">
					</div>
				</form>
			</div>
		</div>
	<?php } else { 
		$get = $_GET['get'];
		$sql_event = mysqli_query($conn, "SELECT * FROM event WHERE Nama = '$get'");
		$event = mysqli_fetch_array($sql_event);
	?>
		<div class="container">
			<div id="event_header">
				<span id="name"><?php echo $event["Nama"]; ?></span>
				<?php if (isset($_SESSION["admin"])) { ?>
				<div id="ID" style="display:none">
					<?php echo $event["ID"]; ?>
				</div>
				<div id="event_buttons">
					<button id="event_delete" class="button right pcg-btn">Delete</button>
					<button id="event_edit" class="button right pcg-btn">Edit</button>
					<button id="event_edit_cancel" class="button right pcg-btn">Cancel</button>
					<button id="event_save_edit" class="button right pcg-btn">Save</button>
				</div>
				<?php } ?>
			</div>
			<div id="event_specific">
				<img src="images/event/<?php echo $event['Gambar']; ?>">
			</div>
			<div id="gambar" style="display:none">
				<?php echo $event["Gambar"]; ?>
			</div>
			<div id="event_content">
				<?php echo nl2br($event["Content"]); ?>
			</div>
			<div id="event_pagination">
			<?php
				$c_event_id = $event["ID"];
				$n_event_id = $c_event_id-1;
				$p_event_id = $c_event_id+1;
				
				$n_event_query = mysqli_query($conn, "SELECT * FROM event WHERE ID = '$n_event_id'");
				$p_event_query = mysqli_query($conn, "SELECT * FROM event WHERE ID = '$p_event_id'");
				
				$n_event = mysqli_fetch_array($n_event_query);
				$p_event = mysqli_fetch_array($p_event_query);
				
				if ($p_event) {
					echo "<div>";
					echo "<a href='event?get=".$p_event["Nama"]."'>&larr;".$p_event["Nama"]."</a>";
					echo "</div>";
				}
				
				if ($n_event) {
					echo "<div>";
					echo "<a href='event?get=".$n_event["Nama"]."'>".$n_event["Nama"]."&rarr;</a>";
					echo "</div>";
				}
			?>
			</div>
		</div>
	<?php } ?>
	</section>
<?php include('footer.php'); ?>