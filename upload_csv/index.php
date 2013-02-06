<html><body><?php
    
    if (isset($error)) {
        
        echo '<p>'.$error.'</p>';
        
    }
    
    ?><form method="post" action="/upload_csv/process_csv.php" enctype="multipart/form-data">
    <label>Browse  for csv</label><input type="file" name="csv"/><br/><input type="submit" value="upload"/>
</form></body></thml><?php
