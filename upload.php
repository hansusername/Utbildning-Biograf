<?php/*
  Detta låg i phpAdmin.php innan men i exempelt som jag fäljde från w3schools
  låg detta i en egen fil.
  Nu visas bara en vit sida men en text som berättar om filen är en bild eller inte.

  $target_dir = "C:\xampp\htdocs\Projekt\wsp1\Biograf\images";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (isset($_POST['submit']))
  {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false)
    {
      echo "Filen är en bild - " . $check["mime"] . ".";
      $uploadOk = 1;
    }
    else
    {
      echo "Filen är inte en bild.";
      $uploadOk = 0;
    }
  }
*/
    $target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
?>