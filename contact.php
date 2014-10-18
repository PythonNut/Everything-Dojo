<?php
include("include/include.php");

if (isset($_POST['submit'])) {
  $err = array();

  foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
  }
  unset($data['submit']);

  require_once('recaptchalib.php');

  $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

  if (empty($data['name']) || empty($data['email']) || empty($data['reason']) || empty($data['message'])) {
    $err[] = "Error: Not all fields are filled out.";
  }

  if (!isUserID($data['name'])) {
    $err[] = "Error: Your name is too crazy. Please stick to 3-20 characters long, and containing only alphanumeric characters and underscores.";
  }

  if (!isEmail($data['email'])) {
    $err[] = "Error: Invalid email address.";
  }

  if (!$resp->is_valid) {
    $err[] = "Error: ReCaptcha response invalid! Please try again.";
  }

  $reasons = array("other" => "green",
                   "support" => "orange",
                   "bug" => "red",
                   "feature" => "yellow");

  $data['label'] = $reasons[$data['reason']];

  //yes, copied straight from discuss.php. perhaps it should be more central.
  function filter_swear_words($contaminated) {
    $swears = array(
      "freaking" => "ZnVja2luZw==", // f******
      "screw"    => "ZnVjaw==",     // f***
      "shodd"    => "c2hpdHQ=",     // plural form of below
      "shod"     => "c2hpdA==",     // s***
      "bastard"  => "Yml0Y2g=",     // b****
      "****"     => "Y3VudA==",     // c***, too offensive to replace
      "butt"     => "YXNz",         // a**
      "darn"     => "ZGFtbg=="      // d***
    );
    $cleaned = ' ' . $contaminated . ' ';

    foreach ($swears as $minced => $swear) {
      $regex_prefix = "/([\s\.;\-\'\"\(])" . base64_decode($swear) . "([\s\.;\-\'\"\)])/";
      $cleaned = preg_replace($regex_prefix, '$1' . $minced . '$2', $cleaned);
    }

    return $cleaned;
  }

  $data['message'] = filter_swear_words($data['message']);

  //data is now server-side validated

  $emailmatch = $dbc->prepare("SELECT * FROM users WHERE user_email = '".$data['email']."'");
  $emailmatch->execute();
  $emailmatch = $emailmatch->fetchAll(PDO::FETCH_ASSOC);

  if (count($emailmatch) !== 0) {
    $data['id'] = $emailmatch[0]['id'];
    $data['username'] = $emailmatch[0]['user_name'];
  }

  $postdata = array();

  $postdata['key'] = $trellokey;
  $postdata['token'] = $trellotoken;
  $postdata['name'] = $data['subject'];
  $postdata['desc'] .= "###Title: ".$data['email'];
  $postdata['desc'] .= "**Email**: ".$data['email'];
  if (isset($data['id'])) {
    $postdata['desc'] .= "\n**Has EvDo account**: ".$data['username']." (ID ".$data['id'].")";
  }
  $postdata['desc'] .= "\n\n**Message**:\n\n".$data['message']."\n\n";
  $postdata['due'] = null;
  $postdata['labels'] = $data['label'];
  $postdata['idList'] = $trellolistid;
  $postdata['urlSource'] = null;

  curl_post("https://trello.com/1/cards", $postdata);

}
?>

<?php
  $title = "Contact Us";
  //dbc already included
  session_start();
  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }
  get_header();
?>
<section id="content">
<?php if (isset($_GET['done'])) { ?>

<?php } else { ?>
  <h1>Contact Us</h1>
  <p>Having trouble with something not working on the site? Perhaps you have a bug report or a feature request? Just want to let us know how much you like us today? Use the form below.</p>
  <br />
  <form action="contact.php" method="post">
    <label for="name">Name/Alias</label>
    <input type="text" name="name">
    <br /><br />
    <label for="email">Email</label>
    <?php if ($_SESSION['user_id'] > 0){ ?>
      <label class="small">So we can contact you back. You are logged in as <b><?php echo get_user($_SESSION['user_id']); ?>.</b></label>
      <input type="text" name="email-dolly" value="<?php echo get_all_user($_SESSION['user_id'])['user_email'];?>" style="width:<?php echo strlen(get_all_user($_SESSION['user_id'])['user_email'])*11;?>px;" disabled="disabled">
      <input type="text" name="email" value="<?php echo get_all_user($_SESSION['user_id'])['user_email'];?>" hidden="hidden">
    <?php } else { ?>
      <label class="small">So we can contact you back. If you have an account on Everything Dojo, please use the same email you used to register so that we can identify your account or sign in.</label>
      <input type="text" name="email">
    <?php } ?>
    <br /><br />
    <label for="reason">What's your reason for contacting us?</label>
    <select name="reason">
      <option value="other">Just wanted to drop a line/Other</option>
      <option value="support">I need personal user support</option>
      <option value="bug">I have a bug report</option>
      <option value="feature">I have a feature request</option>
    </select>
    <br /><br />
    <label for="subject">Subject</label>
    <input type="text" name="subject">
    <label for="message">Message</label>
    <textarea name="message" rows="10">Hi Everything Dojo,</textarea>
    <br />
    <?php
      require_once('recaptchalib.php');
      echo recaptcha_get_html($publickey);
    ?>
    <div id="message"></div>
    <input type="submit" name="submit" value="Send" />
  </form>
<?php } ?>
</section>

<?php get_footer(); ?>
