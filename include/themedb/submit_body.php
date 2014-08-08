<h2>Submit a Theme</h2>

<form method="post" action="include/db-handler.php">
  <div class="col" id="col1">
    Theme name:<br />
    <input type="text" name="name" /><br />
    Theme author:<br />
    <input type="text" name="author" />
  </div>
  <div class="col" id="col2">
    Theme screenshot (url):<br />
    <input type="text" name="screenshot" /><br />
    Theme version (e.g. 1.2):<br />
    <input type="text" name="version" />
  </div>
  <div class="col" id="col3">
    Theme stage:<br />
    <input type="radio" name="stage" value="[DEV]" id="[DEV]" checked="yes" /><label for="[DEV]">[DEV]</label><br />
    <input type="radio" name="stage" value="[ALPHA]" id="[ALPHA]" /><label for="[ALPHA]">[ALPHA]</label><br />
    <input type="radio" name="stage" value="[BETA]" id="[BETA]" /><label for="[BETA]">[BETA] </label>
  </div>
  <div id="fields">
    Theme Description (optional):<br />
    <textarea id="description" name="description"></textarea><br />
    Theme CSS:<br />
    <textarea id="css" name="code"></textarea>
    <input type="submit" name="submit" style="font-size: 15px;" />
    <input type="hidden" name="mode" value="submit-theme" />
  </div>
</form>
