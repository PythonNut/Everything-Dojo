<?php 
  include("include/include.php");
page_protect();

if(!checkAdmin()) {
  header("Location: myaccount.php");
  exit();
}

$table = TB_NAME;

$page_limit = 10;

if(isset($_POST['announcementsSubmit'])) {
  $announcearray = $_POST['announcements'];
  $implode = "";
  foreach ($announcearray as $value) {
    if (!empty($value)) {
      $implode .= "~".filter($value);
    }
  }
  $implode = substr($implode, 1);
  $sql = "UPDATE data
      SET data=\"".$implode."\"
      WHERE fetchname=\"announcements\"";
  mysql_query($sql, $link) or die("Update Failed:" . mysql_error());
}

$rs_all = mysql_query("SELECT count(*) AS total_all FROM $table") or die(mysql_error());
$rs_active = mysql_query("SELECT count(*) AS total_active FROM $table WHERE approved = 1") or die(mysql_error());
$rs_total_pending = mysql_query("SELECT count(*) AS total_pending FROM $table WHERE approved = 0");

list($total_pending) = mysql_fetch_row($rs_total_pending);
list($all) = mysql_fetch_row($rs_all);
list($active) = mysql_fetch_row($rs_active);
?>
<?php
  $title = "Admin CP";
  //dbc already included
  get_header();
?>
<div id="content">
  <h2>Admin CP</h2>
  <p>Total users: <?php echo $all;?><br />
  Active users: <?php echo $active; ?><br />
  Pending users: <?php echo $total_pending; ?></p>

  <p>
  <?php
  $open = FALSE;
  if (isset($_GET['doSearch'])) { $open = TRUE; }
  if ($open == TRUE) { ?>
  <a href="admin.php">Close User Table</a>
  <?php } else { ?>
  <a href="admin.php?doSearch=yes">Display User Table</a>
  <?php } ?>
  </p>

  <?php
  if (isset($_GET['doSearch'])) {
    $open = TRUE;
    $sql = "SELECT * FROM $table";
    $rs_total = mysql_query($sql) or die(mysql_error());
    $total = mysql_num_rows($rs_total);

    if (!isset($_GET['page'])) { $start = 0; }
    else { $start = ($_GET['page'] - 1) * $page_limit; }

    $rs_results = mysql_query($sql." LIMIT $start, $page_limit") or die(mysql_error());
    $total_pages = ceil($total / $page_limit);
    if ($total > $page_limit) {
      echo "<div>Pages:";
      $i = 0;
      while ($i < $page_limit) {
        $page_no = $i+1;
        $qstr = ereg_replace("&page=[0-9]+", "", $_SERVER['QUERY_STRING']);
        echo "<a href=\"admin.php?$qstr&page=$page_no\">$page_no</a>";
        $i++;
      }
      echo "</div>";
    }
  ?>
  <table>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Email</th>
      <th>Registration Date</th>
      <th>Approval</th>
    </tr>
    <?php
    while ($rrows = mysql_fetch_array($rs_results)) {
      list($year, $month, $day) = explode("-", $rrows['date']);
      $timestamp = mktime(0, 0, 0, $month, 10);
      $monthName = date("F", $timestamp);
      $date = $monthName." ".$day.", ".$year;
    ?>
    <tr>
      <td><?php echo $rrows['id']; ?></td>
      <td><?php echo $rrows['user_name']; ?></td>
      <td><?php echo $rrows['user_email']; ?></td>
      <td><?php echo $date; ?></td>
      <td><?php if(!$rrows['approved']) { echo "Pending"; } else { echo "Active"; } ?>
      </td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
  <?php
  $result = mysql_query("SELECT data FROM data WHERE fetchname='announcements' limit 1") or die(); 
  $announcements = explode("~", mysql_result($result, 0));
  if (count($announcements) == 0) {
    $counter = 2;
  } else {
    $counter = count($announcements) + 1;
  }
  ?>
  <script>
  $(function(){

    var counter = <?php echo $counter; ?>;

    if (counter == 2) {
      $("#removeButton").hide();
    }

    $("#addButton").click(function() {
      if(counter == 11){
        return false; 
      }
      if(counter == 2) {
        $("#removeButton").show();
      }
      var newTextBoxDiv = $(document.createElement("div")).attr("id", "textboxdiv" + counter);
      newTextBoxDiv.after().html("<label class=\"inline\">"+counter+" </label>" +
      "<input type=\"text\" name=\"announcements[]\" id=\"textbox" + counter + "\" autocomplete=\"off\" size=\"100\" />");
      newTextBoxDiv.appendTo("#textboxgroup");
      counter++;
      if (counter == 11) {
        $("#addButton").hide();
      }
    });

    $("#removeButton").click(function(){
      counter--;
      $("#textboxdiv" + counter).remove();
      if(counter == 2){
        $("#removeButton").hide();
      }
      if (counter == 10) {
        $("#addButton").show();
      }
    });
  });
  </script>
  <form name="announcements" method="post" action="admin.php">
    <h4>Announcements</h4>
    <label class="small">You may write up to 10 announcements. The announcements that are visible when you submit this form will be the announcements. Any empty fields will be ignored. If there should be no announcements, leave the original field blank. Do NOT use the character "~" in announcements.</label>
    <?php
    if (count($announcements) == 0) { ?>
    <div id="textboxgroup">
      <div id="textboxdiv1">
        <label class="inline">1 </label><input type="text" id="textbox1" name="announcements[]" autocomplete="off" size="100" />
      </div>
    </div>
    <?php } else {
      $othercounter = 1;
      echo "<div id=\"textboxgroup\">";
      foreach ($announcements as $value) { ?>
        <div id="textboxdiv<?php echo $othercounter; ?>">
          <label class="inline"><?php echo $othercounter; ?> </label><input type="text" id="textbox<?php echo $othercounter; ?>" name="announcements[]" value="<?php echo $value; ?>" autocomplete="off" size="100" />
        </div>
      <?php
        $othercounter++;
      }
      echo "</div>";
    }
    ?>
    <input type="button" value="Add Text Box" id="addButton" class="inline" />
    <input type="button" value="Remove Text Box" id="removeButton" class="inline" />
    <input name="announcementsSubmit" type="submit" value="Update" />
  </form>
</div>
<?php get_footer(); ?>