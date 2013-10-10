<?php include('header.php'); ?>	
	<section id="content">
	<?php
		// Jumlah row per page
		$rowsperpage = 9;
		
		if (isset($_GET["category"]))
			$category = $_GET["category"];
		
		// Nyari banyak row
			if (isset($category)) {
				$sql_count = mysqli_query($conn, "SELECT COUNT(*) FROM gallery WHERE Category='$category'");
			} else
				$sql_count = mysqli_query($conn, "SELECT COUNT(*) FROM category");
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
			<div id="gallery_header">
			<?php if (isset($category)) { ?>
				<a href="http://localhost/loopies/gallery">&larr; Gallery</a> - <?php echo $category; ?>
			<?php } else { ?>
				Loopies Radio Gallery
			<?php } 
			if (isset($_SESSION['admin'])) { 
				if (isset($category)) { ?>
					<button id="gallery_add_new" class="button right">+ Add New</button>
			<?php } else { ?>
					<button id="gallery_category_edit" class="button right">Edit</button>
					<button id="gallery_category_add_new" class="button right">+ Add New</button>
			<?php } 
			} ?>
			</div>
			<div id="gallery_slot_container">
			<?php 
				if (isset($category)) {
					$sql_gallery = mysqli_query($conn, "SELECT * FROM gallery WHERE Category = '$category' ORDER BY ID DESC LIMIT $offset, $rowsperpage");
					while ($gallery = mysqli_fetch_array($sql_gallery)) { ?>
						<div class="gallery_slot"><img src="images/gallery/<?php echo $category."/".$gallery['Gambar']; ?>"></div>
			<?php 	}
				} else {
					$sql_category = mysqli_query($conn, "SELECT * FROM category ORDER BY ID DESC LIMIT $offset, $rowsperpage");
					while ($category = mysqli_fetch_array($sql_category)) { ?>
						<div class="gallery_category_slot">
							<a href="http://localhost/loopies/gallery?category=<?php echo $category['Nama']; ?>">
								<img src="images/folder.png">
								<div class="gallery_category"><?php echo $category["Nama"]; ?></div>
							</a>
						</div>
			<?php 	}
				} ?>
			</div>
			<?php
			/* --- Pagination linksss --- */
			$range = 5;
			
			if (isset($category)) {	// Udah masuk folder
				echo "<div id='pagination'>";
				// if not on page 1, don't show back links
				if ($page > 1) {
				   // show << link to go back to page 1
				   echo " <a href='http://localhost/loopies/gallery?category=$category&page=1'><<</a> ";
				   // get previous page num
				   $prevpage = $page - 1;
				   // show < link to go back to 1 page
				   echo " <a href='http://localhost/loopies/gallery?category=$category&page=$prevpage'><</a> ";
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
						 echo " <a href='http://localhost/loopies/gallery?category=$category&page=$x'>$x</a> ";
					  }
				   }
				}
								 
				// if not on last page, show forward and last page links        
				if ($page != $totalpages) {
				   // get next page
				   $nextpage = $page + 1;
					// echo forward link for next page 
				   echo " <a href='http://localhost/loopies/gallery?category=$category&page=$nextpage'>></a> ";
				   // echo forward link for lastpage
				   echo " <a href='http://localhost/loopies/gallery?category=$category&page=$totalpages'>>></a> ";
				}
				
				echo "</div>";
			}
			else // Blom masuk folder
			{	
				echo "<div id='pagination'>";
				// if not on page 1, don't show back links
				if ($page > 1) {
				   // show << link to go back to page 1
				   echo " <a href='http://localhost/loopies/gallery?page=1'><<</a> ";
				   // get previous page num
				   $prevpage = $page - 1;
				   // show < link to go back to 1 page
				   echo " <a href='http://localhost/loopies/gallery?page=$prevpage'><</a> ";
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
						 echo " <a href='http://localhost/loopies/gallery?page=$x'>$x</a> ";
					  }
				   }
				}
								 
				// if not on last page, show forward and last page links        
				if ($page != $totalpages) {
				   // get next page
				   $nextpage = $page + 1;
					// echo forward link for next page 
				   echo " <a href='http://localhost/loopies/gallery?page=$nextpage'>></a> ";
				   // echo forward link for lastpage
				   echo " <a href='http://localhost/loopies/gallery?page=$totalpages'>>></a> ";
				}
				
				echo "</div>";
			}
			?>
		</div>
		<div id="gallery_desc_bg">
		</div>
		<div id="gallery_desc_container">
			<img id="gallery_close" src="images/close.png">
		<?php if (isset($_SESSION['admin'])) { ?>
			<div id="gallery_admin_header"></div>
			<div id="normal_buttons">
				<button id="gallery_delete" class="button right pcg-btn">Delete</button>
				<button id="gallery_edit" class="button right pcg-btn">Edit</button>
			</div>
			<button id="gallery_save_edit" class="button right pcg-btn" style="display:none">Save</button>
		<? } ?>
		<?php
			$sql_gallery2 = mysqli_query($conn, "SELECT * FROM gallery WHERE Category = '$category' ORDER BY ID DESC LIMIT $offset, $rowsperpage");
			while ($gallery2 = mysqli_fetch_array($sql_gallery2)) { ?>
				<div class="gallery_desc">
					<div id="gallery_img">
						<a href="http://localhost/loopies/images/gallery/<?php echo $category."/".$gallery2['Gambar']; ?>" target="_blank">
							<img src="images/gallery/<?php echo $category."/".$gallery2['Gambar']; ?>">
						</a>
					</div>
					<div id="gallery_name">
						<span id="name"><?php echo $gallery2['Nama']; ?></span>
					</div>
					<div id="category" style="display:none">
						<?php echo $gallery2["Category"]; ?>
					</div>
					<div id="ID" style="display:none">
						<?php echo $gallery2["ID"]; ?>
					</div>
					<div id="gambar" style="display:none">
						<?php echo $gallery2["Gambar"]; ?>
					</div>
					<input type="text" name="ID" id="gallery_ID" value="<?php echo $gallery2["ID"]; ?>" style="display:none">
				</div>
		<?php } ?>
			<form method="POST" action="add.php" id="gallery_add" enctype="multipart/form-data">
				<table>
					<tr>
						<td>Gambar</td>
						<td>:</td>
						<td><input type="file" id="gambar" name="gambar[]" accept=image/* multiple/></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><input type="text" name="nama"></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><input type="submit" id="gallery_save_add" class="button right" value="Save"></td>
					</tr>
				</table>				
				<input type="text" name="mode" value="gallery" style="display:none">
				<input type="text" name="category" value="<?php echo $category; ?>" style="display:none">
			</form>
		</div>
		<div id="category_add_edit">
			<div id="category_admin_header">
				
			</div>
			<form method="POST" action="add.php" id="category_add">
				<table>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><input type="text" name="nama"></td>
					</tr>
				</table>
				<div id="category_add_buttons">
					<input type="button" id="category_cancel_add" class="button right" value="Cancel">
					<input type="submit" id="category_save_add" class="button right" value="Save">
				</div>
				<input type="text" name="mode" value="category" style="display:none">
			</form>
			<div id="category_edit">
				<table>
				<?php
				$i = 0;
				$sql_category2 = mysqli_query($conn, "SELECT * FROM category");
				while ($category2 = mysqli_fetch_array($sql_category2)) { ?>
					<tr>
						<td><input type="text" id="nama<?php echo $i; ?>" name="nama" value="<?php echo $category2["Nama"]; ?>"></td>
						<td><button class="button category_edit_save" name="<?php echo $i; ?>">Save</button></td>
						<td><button class="button category_delete" name="<?php echo $i; ?>">Delete</button></td>
						<td><input type="text" id="ID<?php echo $i; ?>" name="ID" value="<?php echo $category2["ID"]; ?>" style="display:none"></td>
					</tr>
			<?php $i++;
				} ?>
				</table>
				<div id="category_edit_btn">
					<button class="button right" id="category_edit_cancel">Cancel</button>
				</div>
			</div>
		</div>
	</section>
<?php include('footer.php'); ?>