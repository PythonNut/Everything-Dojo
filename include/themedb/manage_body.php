<?php
$data = $themedb->get_own_themes($_SESSION['user_id']);
?>
<h2>Manage Your Themes</h2>
<div id="popup-box">
  <h2 id="popup-header"></h2>
  <span style="color: white;">Confirm your action in the box below.</span>
  <div id="popup-wrapper">
    <div id="popup-inner">
      <div id="popup-form">
        Are you sure you want to <span id="replace"></span> this theme?
        <form action="include/db-handler.php" method="post">
          <input type="submit" name="submit" value="Confirm" style="font-size: 15px;" />
          <input type="hidden" value="" name="id" id="replace-id" />
          <input type="hidden" value="" name="mode" id="replace-form" />
        </form>
      </div>
    </div>
  </div>
</div>
<div class="manage-item">
  <div class="manage-header" id="header-1"><h4>Unapproved Themes (<?php echo count($data['unapproved']) ?>)</h4></div>
  <div id="manage-1">
    <table class="manage-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td>Theme</td>
          <td class="med-col">Author</td>
          <td class="small-col">Version</td>
          <td class="small-col">Stage</td>
          <td class="small-col">Manage</td>
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
          <td>-</td>
        </tr>
      <?php
        }
        else{
          for($i=0;$i<count($data['unapproved']);$i++){
            $description = shorten_desc($data['unapproved'][$i]['description']);
      ?>
        <tr class="style">
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['unapproved'][$i]['id']; ?>'"><b><?php echo $data['unapproved'][$i]['name']; ?></b></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['unapproved'][$i]['id']; ?>'"><?php echo $data['unapproved'][$i]['author']; ?></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['unapproved'][$i]['id']; ?>'"><?php echo $data['unapproved'][$i]['version']; ?></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['unapproved'][$i]['id']; ?>'"><?php echo $data['unapproved'][$i]['stage']; ?></td>
          <td><a href="<?php echo URL_DATABASE; ?>?mode=edit&id=<?php echo $data['unapproved'][$i]['id']; ?>"><img src="../../images/edit.png" class="img-edit" /></a> <a href="<?php echo URL_DATABASE; ?>?mode=settings&id=<?php echo $data['unapproved'][$i]['id']; ?>"><img src="../../images/gear.png" class="img-edit" /></a> <a href="javascript:;" class="view" onclick="popup_options('delete', <?php echo $data['unapproved'][$i]['id']; ?>);"><img src="../../images/trash.png" class="img-edit" /></a></td>
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
  <div class="manage-header" id="header-2"><h4>Approved Themes (<?php echo count($data['approved']) ?>)</h4></div>
   <div id="manage-2">
    <table class="manage-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td>Theme</td>
          <td class="med-col">Author</td>
          <td class="small-col">Version</td>
          <td class="small-col">Stage</td>
          <td class="small-col">Manage</td>
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
          <td>-</td>
        </tr>
      <?php
        }
        else{
          for($i=0;$i<count($data['approved']);$i++){
            $description = shorten_desc($data['approved'][$i]['description']);
      ?>
        <tr class="style">
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['approved'][$i]['id']; ?>'"><b><?php echo $data['approved'][$i]['name']; ?></b></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['approved'][$i]['id']; ?>'"><?php echo $data['approved'][$i]['author']; ?></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['approved'][$i]['id']; ?>'"><?php echo $data['approved'][$i]['version']; ?></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['approved'][$i]['id']; ?>'"><?php echo $data['approved'][$i]['stage']; ?></td>
          <td><a href="<?php echo URL_DATABASE; ?>?mode=edit&id=<?php echo $data['approved'][$i]['id']; ?>"><img src="../../images/edit.png" class="img-edit" /></a> <a href="<?php echo URL_DATABASE; ?>?mode=settings&id=<?php echo $data['approved'][$i]['id']; ?>"><img src="../../images/gear.png" class="img-edit" /></a> <a href="javascript:;" class="view" onclick="popup_options('delete', <?php echo $data['approved'][$i]['id']; ?>);"><img src="../../images/trash.png" class="img-edit" /></a></td>
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
  <div class="manage-header" id="header-3"><h4>Themes with Validation Request (<?php echo count($data['validate_request']) ?>)</h4></div>
  <div id="manage-3">
    <table class="manage-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td>Theme</td>
          <td class="med-col">Author</td>
          <td class="small-col">Version</td>
          <td class="small-col">Stage</td>
          <td class="small-col">Manage</td>
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
          <td>-</td>
        </tr>
      <?php
        }
        else{
          for($i=0;$i<count($data['validate_request']);$i++){
            $description = shorten_desc($data['validate_request'][$i]['description']);
      ?>
        <tr class="style">
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validate_request'][$i]['id']; ?>'"><b><?php echo $data['validate_request'][$i]['name']; ?></b></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validate_request'][$i]['id']; ?>'"><?php echo $data['validate_request'][$i]['author']; ?></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validate_request'][$i]['id']; ?>'"><?php echo $data['validate_request'][$i]['version']; ?></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validate_request'][$i]['id']; ?>'"><?php echo $data['validate_request'][$i]['stage']; ?></td>
          <td><a href="<?php echo URL_DATABASE; ?>?mode=edit&id=<?php echo $data['validate_request'][$i]['id']; ?>"><img src="../../images/edit.png" class="img-edit" /></a> <a href="<?php echo URL_DATABASE; ?>?mode=settings&id=<?php echo $data['validate_request'][$i]['id']; ?>"><img src="../../images/gear.png" class="img-edit" /></a> <a href="javascript:;" class="view" onclick="popup_options('delete', <?php echo $data['validate_request'][$i]['id']; ?>);"><img src="../../images/trash.png" class="img-edit" /></a></td>
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
  <div class="manage-header" id="header-4"><h4>Validated Themes (<?php echo count($data['validated']) ?>)</h4></div>
  <div id="manage-4">
    <table class="manage-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td>Theme</td>
          <td class="med-col">Author</td>
          <td class="small-col">Version</td>
          <td class="small-col">Stage</td>
          <td class="small=col">Manage</td>
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
          <td>-</td>
        </tr>
      <?php
        }
        else{
          for($i=0;$i<count($data['validated']);$i++){
            $description = shorten_desc($data['validated'][$i]['description']);
      ?>
        <tr class="style">
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validated'][$i]['id']; ?>'"><b><?php echo $data['validated'][$i]['name']; ?></b></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validated'][$i]['id']; ?>'"><?php echo $data['validated'][$i]['author']; ?></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validated'][$i]['id']; ?>'"><?php echo $data['validated'][$i]['version']; ?></td>
          <td onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validated'][$i]['id']; ?>'"><?php echo $data['validated'][$i]['stage']; ?></td>
          <td><a href="<?php echo URL_DATABASE; ?>?mode=edit&id=<?php echo $data['validated'][$i]['id']; ?>"><img src="../../images/edit.png" class="img-edit" /></a> <a href="<?php echo URL_DATABASE; ?>?mode=settings&id=<?php echo $data['validated'][$i]['id']; ?>"><img src="../../images/gear.png" class="img-edit" /></a> <a href="javascript:;" class="view" onclick="popup_options('delete', <?php echo $data['validated'][$i]['id']; ?>);"><img src="../../images/trash.png" class="img-edit" /></a></td>
        </tr>
      <?php
          }
        }
      ?>
      </tbody>
    </table>
    </div>
</div>
