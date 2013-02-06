<form class="searchform" action="/" id="searchform-main" method="get">
<label class="assistive-text" for="search-word">Search</label>
<input type="text" placeholder="Search..." id="search-word" name="s" class="field" value="<?php if (isset($_GET['s'])) {echo $_GET['s'];} ?>">
<input type="submit" value="Search" id="searchsubmit-main" name="submit" class="submit">
</form>