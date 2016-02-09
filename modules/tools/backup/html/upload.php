<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>

<!-- http://webcheatsheet.com/php/file_upload.php -->
<div class="panel panel-info">
<div class="panel-heading">
<h3 class="panel-title">Upload</h3>
</div>
<div class="panel-body">
<?php
//Сheck that we have a file
if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 350Kb
  $filename = basename($_FILES['uploaded_file']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);
  if (($ext == "gz") && ($_FILES["uploaded_file"]["size"] < 3500000000)) {
    //Determine the path to which we want to save this file
      $newname = "tmp/backup/$filename";
      //Check if the file with the same name is already exists on the server
      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname))) {
           echo "It's done! The file has been saved as: ".$newname;
        } else {
           echo "Error: A problem occurred during file upload!";
        }
      } else {
         echo "Error: File ".$_FILES["uploaded_file"]["name"]." already exists";
      }
  } else {
     echo "Error: Only .tar.gz images";
  }
} else {
 echo "Error: No file uploaded";
}
?>
<FORM><INPUT Type="button" VALUE="Back" onClick="history.go(-1);return true;" class="btn btn-info"></FORM>
</div>
</div>