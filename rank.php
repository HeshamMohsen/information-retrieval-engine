<?php

// get query from input
$queryLower = $_POST["querystring"];
// convert the query to uppercase
$queryUpper = strtoupper($queryLower);

// check if query empty [rewrite] else check regular expression
if ($queryUpper == "") {
  $title = "Whoops...";
  $message = "We're unable to find data you're looking for";
  $btnText = "Find Again";
} else if (!preg_match('/^<([A-E]([:][0][.][1-9])?[;])+>$/', $queryUpper)){
    $title = "Whoops...";
    $message = "We're unable to find data you're looking for";
    $btnText = "Find Again";
} else { 

  // function score to calculate the score of the 3 files
  function score($As,$Bs,$Cs,$Ds,$Es,$queryUpper,$len) {
    $Aratio=1;
    $Bratio=1;
    $Cratio=1;
    $Dratio=1;
    $Eratio=1;

    if(strpos($queryUpper, "A:")){
      $start=strpos($queryUpper, "A:")+2;
      $Aratio=substr($queryUpper,$start,3);
    }
    if(strpos($queryUpper, "B:")){
      $start=strpos($queryUpper, "B:")+2;
      $Bratio=substr($queryUpper,$start,3);
    }
    if(strpos($queryUpper, "C:")){
      $start=strpos($queryUpper, "C:")+2;
      $Cratio=substr($queryUpper,$start,3);
    }
    if(strpos($queryUpper, "D:")){
      $start=strpos($queryUpper, "D:")+2;
      $Dratio=substr($queryUpper,$start,3);
    }
    if(strpos($queryUpper, "E:")){
      $start=strpos($queryUpper, "E:")+2;
      $Eratio=substr($queryUpper,$start,3);
    }
    return $score =($As/$len*$Aratio)+($Bs/$len*$Bratio)+($Cs/$len*$Cratio)+($Es/$len*$Eratio)+($Ds/$len*$Dratio);
  }

  // getFileScore gets the score for each file after count all characters numbers
  // then send to score calculations function to return each file score
  function getFileScore($fileContent, $query) {
    $result = 0;
    $fileLength = strlen($fileContent);

    $As=0;
    $Bs=0;
    $Cs=0;
    $Ds=0;
    $Es=0;

    for($i = 0; $i < $fileLength; $i++){
      switch ($fileContent[$i]) {
        case 'A':
          $As++;
          break;
        case 'B':
          $Bs++;
          break;
        case 'C':
          $Cs++;
          break;
        case 'D':
          $Ds++;
          break;
        case 'E':
          $Es++;
          break;
      }
    }

    $result = score($As,$Bs,$Cs,$Ds,$Es,$query,$fileLength);
    return $result;
  }

  // get files content
  $fileContent1 = file_get_contents("file1.txt");
  $fileContent2 = file_get_contents("file2.txt");
  $fileContent3 = file_get_contents("file3.txt");
  $fileContent4 = file_get_contents("file4.txt");
  $fileContent5 = file_get_contents("file5.txt");

  // get files score
  $fileScore_1 = getFileScore($fileContent1, $queryUpper);
  $fileScore_2 = getFileScore($fileContent2, $queryUpper);
  $fileScore_3 = getFileScore($fileContent3, $queryUpper);
  $fileScore_4 = getFileScore($fileContent4, $queryUpper);
  $fileScore_5 = getFileScore($fileContent5, $queryUpper);


    // files
  $files = [
      "<a href='http://localhost/IRP/file1.txt' target='_blank'>file1</a>" => $fileScore_1,
      "<a href='http://localhost/IRP/file2.txt' target='_blank'>file2</a>" => $fileScore_2,
      "<a href='http://localhost/IRP/file3.txt' target='_blank'>file3</a>" => $fileScore_3,
      "<a href='http://localhost/IRP/file4.txt' target='_blank'>file4</a>" => $fileScore_4,
      "<a href='http://localhost/IRP/file5.txt' target='_blank'>file5</a>" => $fileScore_5
  ];

  // sort assoc. files according to the values
  arsort($files);

  // inject table rows in table 
  $list = '';
  foreach ($files as $key => $val) {
    $list .= '  
     <p> 
      <span>File: </span><strong>'. $key .'</strong>,
      <span>Score: </span><strong>'. $val .'</strong>
      </p>   
    '; 
  }

  $htmlSucessStructure = '
    <div class="handler--white">
      <div class="header-text">
        <div class="header-square-top">
          <h1> Ranking </h1>
          <div class="list">
             '. $list .'
          </div>
          <a href="http://localhost/IRP/index.php" class="back"> Search Again </a>
        </div>
      </div>
      <div class="image">
        <div class="image--square">
            <img src="images/file.PNG"/>
        </div>
      </div>
    </div>';
}

  if( isset($title) && isset($message) && isset($btnText) ) {
    $htmlStructure = '
    <div class="handler--white">
      <div class="header-text">
        <div class="header-square">
          <h1>' . $title . '</h1>
          <p>' . $message . '</p>
          <a href="http://localhost/IRP/index.php">' . $btnText . '</a>
        </div>
      </div>
      <div class="image">
        <div class="image--square">
            <img src="images/file.PNG"/>
        </div>
      </div>
    </div>';
  }
?>


<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/normalize.css"> 
    <link rel="stylesheet" href="css/ir.css">
  <body>
      <?php if(isset($htmlStructure)) echo $htmlStructure ?>
      <?php if(isset($htmlSucessStructure)) echo $htmlSucessStructure ?>
  </body>
</html>