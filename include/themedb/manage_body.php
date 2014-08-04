<?php
$data = $themedb->get_own_themes($_SESSION['user_id']);
?>
<h2>Manage Your Themes</h2>
<div class="manage-item">
	<div class="manage-header"><h4>Unapproved Themes</h4></div>
  <div>
    <table class="manage-table">
    	<thead style="border-bottom: 1px black solid;">
      	<tr>
        	<td>Theme</td>
         	<td class="med-col">Author</td>
        	<td class="small-col">Version</td>
        	<td class="small-col">Stage</td>
        </tr>
      </thead>
   		<tbody>
      <?php 
				if(count($data['unapproved']) == 0){
			?>
      	<tr>
        	<td><b>No unapproved themes</b></td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
      <?php	
				}
				else{
					for($i=0;$i<count($data['unapproved']);$i++){
						$description = shorten_desc($data['unapproved'][$i]['description']);
			?>
      	<tr class="style" onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['unapproved'][$i]['id']; ?>'">
        	<td><b><?php echo $data['unapproved'][$i]['name']; ?></b></td>
        	<td><?php echo $data['unapproved'][$i]['author']; ?></td>
        	<td><?php echo $data['unapproved'][$i]['version']; ?></td>
        	<td><?php echo $data['unapproved'][$i]['stage']; ?></td>
        </tr>
      <?php	
					}
				}
			?>
      </tbody>
    </table>
    </div>
</div>
<div class="manage-item">
	<div class="manage-header"><h4>Approved Themes</h4></div>
 	<div>
    <table class="manage-table">
    	<thead style="border-bottom: 1px black solid;">
      	<tr>
        	<td>Theme</td>
         	<td class="med-col">Author</td>
        	<td class="small-col">Version</td>
        	<td class="small-col">Stage</td>
        </tr>
      </thead>
   		<tbody>
      <?php 
				if(count($data['approved']) == 0){
			?>
      	<tr>
        	<td><b>No approved themes</b></td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
      <?php	
				}
				else{
					for($i=0;$i<count($data['approved']);$i++){
						$description = shorten_desc($data['approved'][$i]['description']);
			?>
      	<tr class="style" onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['approved'][$i]['id']; ?>'">
        	<td><b><?php echo $data['approved'][$i]['name']; ?></b></td>
        	<td><?php echo $data['approved'][$i]['author']; ?></td>
        	<td><?php echo $data['approved'][$i]['version']; ?></td>
        	<td><?php echo $data['approved'][$i]['stage']; ?></td>
        </tr>
      <?php	
					}
				}
			?>
      </tbody>
    </table>
    </div>
</div>
<div class="manage-item">
	<div class="manage-header"><h4>Themes with Validation Request</h4></div>
  <div>
    <table class="manage-table">
    	<thead style="border-bottom: 1px black solid;">
      	<tr>
        	<td>Theme</td>
         	<td class="med-col">Author</td>
        	<td class="small-col">Version</td>
        	<td class="small-col">Stage</td>
        </tr>
      </thead>
   		<tbody>
      <?php 
				if(count($data['validate_request']) == 0){
			?>
      	<tr>
        	<td><b>No themes with validate request.</b></td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
      <?php	
				}
				else{
					for($i=0;$i<count($data['validate_request']);$i++){
						$description = shorten_desc($data['validate_request'][$i]['description']);
			?>
      	<tr class="style" onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validate_request'][$i]['id']; ?>'">
        	<td><b><?php echo $data['validate_request'][$i]['name']; ?></b></td>
        	<td><?php echo $data['validate_request'][$i]['author']; ?></td>
        	<td><?php echo $data['validate_request'][$i]['version']; ?></td>
        	<td><?php echo $data['validate_request'][$i]['stage']; ?></td>
        </tr>
      <?php	
					}
				}
			?>
      </tbody>
    </table>
    </div>
</div>
<div class="manage-item">
	<div class="manage-header"><h4>Validated Themes</h4></div>
  <div>
    <table class="manage-table">
    	<thead style="border-bottom: 1px black solid;">
      	<tr>
        	<td>Theme</td>
         	<td class="med-col">Author</td>
        	<td class="small-col">Version</td>
        	<td class="small-col">Stage</td>
        </tr>
      </thead>
   		<tbody>
      <?php 
				if(count($data['validated']) == 0){
			?>
      	<tr>
        	<td><b>No validated themes</b></td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
      <?php	
				}
				else{
					for($i=0;$i<count($data['validated']);$i++){
						$description = shorten_desc($data['validated'][$i]['description']);
			?>
      	<tr class="style" onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validated'][$i]['id']; ?>'">
        	<td><b><?php echo $data['validated'][$i]['name']; ?></b></td>
        	<td><?php echo $data['validated'][$i]['author']; ?></td>
        	<td><?php echo $data['validated'][$i]['version']; ?></td>
        	<td><?php echo $data['validated'][$i]['stage']; ?></td>
        </tr>
      <?php	
					}
				}
			?>
      </tbody>
    </table>
    </div>
</div>
