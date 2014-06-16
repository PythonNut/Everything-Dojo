<h2>Submit a Theme</h2>

<form method="post" action="">
	<div class="col" id="col1">
    Theme name:<br />
    <input type="text" name="name" /><br />
    Theme author:<br />
    <input type="text" name="author" />
  </div>
  <div class="col" id="col2">
    Theme screenshot (url):<br />
    <input type="text" name="screenshot" /><br />
    Theme version (i.e. 1.2):<br />
    <input type="text" name="version" />
	</div>
  <div class="col" id="col3">
    Theme stage:<br />
    <input type="radio" name="stage" value="[DEV]" id="[DEV]" /><label for="[DEV]">[DEV]</label><br />
    <input type="radio" name="stage" value="[ALPHA]" id="[ALPHA]" /><label for="[ALPHA]">[ALPHA]</label><br />
    <input type="radio" name="stage" value="[BETA]" id="[BETA]" /><label for="[BETA]">[BETA] </label> 
  </div>
</form>