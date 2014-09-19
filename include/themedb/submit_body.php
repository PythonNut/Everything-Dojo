<h2>Submit a Theme</h2>

<form method="post" action="include/db-handler.php">
  <div class="col" id="col1">
    <label>Theme name:</label>
    <input type="text" name="name" /><br />
    <label>Theme author:</label>
    <input type="text" name="author" />
  </div>
  <div class="col" id="col2">
    <label>Theme screenshot (url):</label>
    <input type="text" name="screenshot" /><br />
    <label>Theme version (e.g. 1.2):</label>
    <input type="text" name="version" />
  </div>
  <div class="col" id="col3">
    <label>Theme stage:</label>
    <input type="radio" name="stage" value="[DEV]" id="[DEV]" checked="yes" /><label for="[DEV]">[DEV]</label><br />
    <input type="radio" name="stage" value="[ALPHA]" id="[ALPHA]" /><label for="[ALPHA]">[ALPHA]</label><br />
    <input type="radio" name="stage" value="[BETA]" id="[BETA]" /><label for="[BETA]">[BETA] </label>
  </div>
  <div id="fields">
    <label>Theme Description (optional):</label>
    <textarea id="description" name="description"></textarea><br />
    <label>Theme CSS:</label>
    <textarea id="css" name="code"></textarea>
    <input type="submit" name="submit" style="font-size: 15px;" />
    <input type="hidden" name="mode" value="submit-theme" />
  </div>
</form>
