<?php

    set_time_limit(300);
    /****************************************
     Example of how to use this uploader class...
     You can uncomment the following lines (minus the require) to use these as your defaults.
     
     // list of valid extensions, ex. array("jpeg", "xml", "bmp")
     $allowedExtensions = array();
     // max file size in bytes
     $sizeLimit = 10 * 1024 * 1024;
     
     require('valums-file-uploader/server/php.php');
     
     // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
     
     // to pass data through iframe you will need to encode all html tags
     
     /******************************************/
    $allowedExtensions = array(
                               'jpeg',
                               'jpg',
                               'gif',
                               'png'
                               );

    $sizeLimit = 8* 1024 * 1024;
    $uid = uniqid();
    $_GET['qqfile'] = str_replace(' ', '_', $_GET['qqfile']);
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/temp/' . $uid)) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/temp/' . $uid);
        chmod($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/temp/' . $uid, 0777);
    }

    
    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
    
    
    
    $result = $uploader->handleUpload($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/temp/' . $uid . '/');
    
    if (intval($result['success']) == 1) {
        //insert into the database to the temp store which will be deleted over time!
        $link = mysql_connect('localhost', 'loveluxe_luser', 'OA39E}q?6xEa');
        
        mysql_select_db('loveluxe_live');
        
        $sql = "INSERT INTO adverts_temp_file_store (file_name, ftime) VALUES ('" . '/adverts_temp_store/temp/' . $uid . "/" . $_GET['qqfile'] . "', NOW())";
        
        mysql_query($sql);
        mysql_close($link);
        
        if (!session_id()) {
            session_start();
        }
        
        //figure out if the image is the right size?
        
        list($w, $h) = getimagesize($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/temp/' . $uid . "/" . $_GET['qqfile']);
        
        $inf = pathinfo($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/temp/' . $uid . "/" . $_GET['qqfile']);
        print_r($inf);
        die();
        if ($w != 200 || $h != 90) {
            //find out if width is greater
            
            if ($w/$h > 1) {
                //width greater
                //resize according to width!
                
                $dest = imagecreatetruecolor(200, 90);
                
                
                
                
                
            }
            
        }
        
        
        $_SESSION['adverts_temp_file'] = '/adverts_temp_store/temp/' . $uid . "/" . $_GET['qqfile'];
        $result['fileName'] = '/adverts_temp_store/temp/' . $uid . "/" . $_GET['qqfile'];
    }
    
    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

    
    /**
     * Handle file uploads via XMLHttpRequest
     */
    class qqUploadedFileXhr {
        /**
         * Save the file to the specified path
         * @return boolean TRUE on success
         */
        function save($path) {    
            $input = fopen("php://input", "r");
            $temp = tmpfile();
            $realSize = stream_copy_to_stream($input, $temp);
            fclose($input);
            
            if ($realSize != $this->getSize()){            
                return false;
            }
            
            $target = fopen($path, "w");        
            fseek($temp, 0, SEEK_SET);
            stream_copy_to_stream($temp, $target);
            fclose($target);
            return true;
        }
        function getName() {
            return $_GET['qqfile'];
        }
        function getSize() {
            if (isset($_SERVER["CONTENT_LENGTH"])){
                return (int)$_SERVER["CONTENT_LENGTH"];            
            } else {
                throw new Exception('Getting content length is not supported.');
            }      
        }   
    }
    
    /**
     * Handle file uploads via regular form post (uses the $_FILES array)
     */
    class qqUploadedFileForm {  
        /**
         * Save the file to the specified path
         * @return boolean TRUE on success
         */
        function save($path) {
            if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
                return false;
            }
            return true;
        }
        function getName() {
            return $_FILES['qqfile']['name'];
        }
        function getSize() {
            return $_FILES['qqfile']['size'];
        }
    }
    
    class qqFileUploader {
        private $allowedExtensions = array();
        private $sizeLimit = 10485760;
        private $file;
        
        function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){        
            $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
            $this->allowedExtensions = $allowedExtensions;        
            $this->sizeLimit = $sizeLimit;
            
            $this->checkServerSettings();       
            
            if (isset($_GET['qqfile'])) {
                $this->file = new qqUploadedFileXhr();
            } elseif (isset($_FILES['qqfile'])) {
                $this->file = new qqUploadedFileForm();
            } else {
                $this->file = false; 
            }
        }
        
        public function getName(){
            if ($this->file)
                return $this->file->getName();
        }
        
        private function checkServerSettings(){        
            $postSize = $this->toBytes(ini_get('post_max_size'));
            $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
            
            if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
                $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
                die("{'error':'Please upload a smaller image: maximum file size: " . $size . "'}");    
            }        
        }
        
        private function toBytes($str){
            $val = trim($str);
            $last = strtolower($str[strlen($str)-1]);
            switch($last) {
                case 'g': $val *= 1024;
                case 'm': $val *= 1024;
                case 'k': $val *= 1024;        
            }
            return $val;
        }
        
        /**
         * Returns array('success'=>true) or array('error'=>'error message')
         */
        function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
            if (!is_writable($uploadDirectory)){
                return array('error' => "Server error. Upload directory isn't writable.");
            }
            
            if (!$this->file){
                return array('error' => 'No files were uploaded.');
            }
            
            $size = $this->file->getSize();
            
            if ($size == 0) {
                return array('error' => 'File is empty');
            }
            
            if ($size > $this->sizeLimit) {
                return array('error' => 'File is too large');
            }
            
            $pathinfo = pathinfo($this->file->getName());
            $filename = $pathinfo['filename'];
            //$filename = md5(uniqid());
            $ext = @$pathinfo['extension'];		// hide notices if extension is empty
            
            if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
                $these = implode(', ', $this->allowedExtensions);
                return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
            }

            if (!$replaceOldFile) {
                /// don't overwrite previous files that were uploaded
                while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                    $filename .= rand(10, 99);
                }
            }
            
            if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
                return array('success'=>true);
            } else {
                return array('error'=> 'Could not save uploaded file.' .
                             'The upload was cancelled, or server error encountered');
            }
            
        }    
    }
