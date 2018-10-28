<?php
// characters array from [A-E]
$charSet = ['A','B','C','D','E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

// open  5-files and add flag 'w' => 'write'
$fileOne    = fopen("file1.txt", "w") or die("Unable to open file!");
$fileTwo    = fopen("file2.txt", "w") or die("Unable to open file!");
$fileThree  = fopen("file3.txt", "w") or die("Unable to open file!");
$fileFour   = fopen("file4.txt", "w") or die("Unable to open file!");
$fileFive   = fopen("file5.txt", "w") or die("Unable to open file!");

// generate function takes file, lengthOfFile, charsArray 
// and generate string from charSet array randomly 
// then write it in each files 
function generate ($file, $chars) {
  // get random file length of characters 
  $fileLength = rand(10, 20);
  // define empty string to add the generated characters
  $str = '';
  // generate random number from 0 - 4 length of characters array
  // and then add to str string 
  for($i = 0; $i < $fileLength; $i++){
    $index = rand(0, 25);
    $str.= $chars[$index];
  }
  // write str in the opened file
  fwrite($file, $str);
  // close the file
  fclose($file);
}

// generate function call 5 times of 5 files
generate($fileOne, $charSet);
generate($fileTwo, $charSet);
generate($fileThree, $charSet);
generate($fileFour, $charSet);
generate($fileFive, $charSet);

// get files content
$fileContent1 = file_get_contents("file1.txt");
$fileContent2 = file_get_contents("file2.txt");
$fileContent3 = file_get_contents("file3.txt");
$fileContent4 = file_get_contents("file4.txt");
$fileContent5 = file_get_contents("file5.txt");

// check if all 5-files generated successfully
if ( ($fileContent1 != "") && ($fileContent2 != "") && ($fileContent3 != "") && ($fileContent4 != "") && ($fileContent5 != "") ) {
  $title = "Done.";
  $message = "files generated successfully";
  $btnText = "start search";
} else {
  $title = "Whoops...";
  $message = "error while generate, please go back and try again!";
  $btnText = "Try Again";
}

$htmlStructure = '
  <div class="handler--white">
    <div class="header-text">
      <div class="header-square">
        <h1>' . $title . '</h1>
        <p>' . $message . '</p>
        <a href="http://localhost/IR-engine/index.php">' . $btnText . '</a>
      </div>
    </div>
    <div class="image">
      <div class="image--square">
          <img src="images/file.PNG"/>
      </div>
    </div>
  </div>';
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/normalize.css"> 
    <link rel="stylesheet" href="css/ir.css">
  <body>
      <?php echo $htmlStructure; ?>
  </body>
</html>