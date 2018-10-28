<?php

// set hash-map 
$set = array(
  'A' => array('occur' => 0, 'ratio' => 0),
  'B' => array('occur' => 0, 'ratio' => 0),
  'C' => array('occur' => 0, 'ratio' => 0),
  'D' => array('occur' => 0, 'ratio' => 0),
  'E' => array('occur' => 0, 'ratio' => 0),
  'F' => array('occur' => 0, 'ratio' => 0),
  'G' => array('occur' => 0, 'ratio' => 0),
  'H' => array('occur' => 0, 'ratio' => 0),
  'I' => array('occur' => 0, 'ratio' => 0),
  'J' => array('occur' => 0, 'ratio' => 0),
  'K' => array('occur' => 0, 'ratio' => 0),
  'L' => array('occur' => 0, 'ratio' => 0),
  'M' => array('occur' => 0, 'ratio' => 0),
  'N' => array('occur' => 0, 'ratio' => 0),
  'O' => array('occur' => 0, 'ratio' => 0),
  'P' => array('occur' => 0, 'ratio' => 0),
  'Q' => array('occur' => 0, 'ratio' => 0),
  'R' => array('occur' => 0, 'ratio' => 0),
  'S' => array('occur' => 0, 'ratio' => 0),
  'T' => array('occur' => 0, 'ratio' => 0),
  'U' => array('occur' => 0, 'ratio' => 0),
  'V' => array('occur' => 0, 'ratio' => 0),
  'W' => array('occur' => 0, 'ratio' => 0),
  'X' => array('occur' => 0, 'ratio' => 0),
  'Y' => array('occur' => 0, 'ratio' => 0),
  'Z' => array('occur' => 0, 'ratio' => 0)
);
// get query from input
$queryLower = $_POST["querystring"];
// convert the query to uppercase
$queryUpper = strtoupper($queryLower);

// check if query empty [rewrite] else check regular expression
if ($queryUpper == "") {
  $title = "Whoops...";
  $message = "We're unable to find data you're looking for";
  $btnText = "Find Again";
} else if (!preg_match('/^<([A-Z]([:][0][.][1-9])?[;])+>$/', $queryUpper)){
    $title = "Whoops...";
    $message = "We're unable to find data you're looking for";
    $btnText = "Find Again";
} else { 

  // function score to calculate the score of the 3 files
  function score($set, $queryUpper, $len) {
    // init score var with 0 
    $score = 0;
    // loop through $set characters to fetch each char
    foreach($set as $key => $val) {
      // check if character exist in query
      if(strpos($queryUpper, $key)){
        // get the start position of ratio
        $start = strpos($queryUpper, $key);
        if($queryUpper[$start + 1] == ';') {
          $set[$key]['ratio'] = 1;
        } else {
          $start = strpos($queryUpper, $key) + 2;
          // assign the value of ration in char ratio index
          $set[$key]['ratio'] = substr($queryUpper, $start, 3);
        }
      }
      // add score 
      $score += (($set[$key]['occur']/$len)*$set[$key]['ratio']);
    }
    // return score
    return $score;
  }

  // getFileScore gets the score for each file after count all characters numbers
  // then send to score calculations function to return each file score
  function getFileScore($fileContent, $query, $set) {
    // get file length
    $fileLength = strlen($fileContent);
    // each loop add character occur in set
    for($i = 0; $i < $fileLength; $i++){
      $set[$fileContent[$i]]['occur'] += 1;
    }
    // call score()  
    $result = score($set,$query,$fileLength);
    return $result;
  }

  // get files content
  $fileContent1 = file_get_contents("file1.txt");
  $fileContent2 = file_get_contents("file2.txt");
  $fileContent3 = file_get_contents("file3.txt");
  // $fileContent4 = file_get_contents("file4.txt");
  // $fileContent5 = file_get_contents("file5.txt");

  // get files score
  $fileScore_1 = getFileScore($fileContent1, $queryUpper, $set);
  $fileScore_2 = getFileScore($fileContent2, $queryUpper, $set);
  $fileScore_3 = getFileScore($fileContent3, $queryUpper, $set);
  $fileScore_4 = getFileScore($fileContent4, $queryUpper, $set);
  $fileScore_5 = getFileScore($fileContent5, $queryUpper, $set);


  // files
  $files = [
      "<a href='http://localhost/IR-engine/file1.txt' target='_blank'>file1</a>" => $fileScore_1,
      "<a href='http://localhost/IR-engine/file2.txt' target='_blank'>file2</a>" => $fileScore_2,
      "<a href='http://localhost/IR-engine/file3.txt' target='_blank'>file3</a>" => $fileScore_3,
      "<a href='http://localhost/IR-engine/file4.txt' target='_blank'>file4</a>" => $fileScore_4,
      "<a href='http://localhost/IR-engine/file5.txt' target='_blank'>file5</a>" => $fileScore_5
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
          <a href="http://localhost/IR-engine/index.php" class="back"> Search Again </a>
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
          <a href="http://localhost/IR-engine/index.php">' . $btnText . '</a>
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