<?php

// set hash-map 
// $set = array(
//   'food' => array('occur' => 0, 'ratio' => 0),
//   'love' => array('occur' => 0, 'ratio' => 0),
//   'play' => array('occur' => 0, 'ratio' => 0),
//   'write' => array('occur' => 0, 'ratio' => 0),
//   'run' => array('occur' => 0, 'ratio' => 0),
//   'gym' => array('occur' => 0, 'ratio' => 0),
//   'sex' => array('occur' => 0, 'ratio' => 0),
//   'python' => array('occur' => 0, 'ratio' => 0),
//   'programming' => array('occur' => 0, 'ratio' => 0),
//   'pasta' => array('occur' => 0, 'ratio' => 0),
//   'chicken' => array('occur' => 0, 'ratio' => 0),
//   'yellow' => array('occur' => 0, 'ratio' => 0),
//   'red' => array('occur' => 0, 'ratio' => 0),
//   'color' => array('occur' => 0, 'ratio' => 0),
//   'I' => array('occur' => 0, 'ratio' => 0),
//   'am' => array('occur' => 0, 'ratio' => 0),
//   'scripting' => array('occur' => 0, 'ratio' => 0),
//   'friends' => array('occur' => 0, 'ratio' => 0),
//   'auto' => array('occur' => 0, 'ratio' => 0),
//   'plan' => array('occur' => 0, 'ratio' => 0),
//   'car' => array('occur' => 0, 'ratio' => 0),
//   'building' => array('occur' => 0, 'ratio' => 0),
//   'logo' => array('occur' => 0, 'ratio' => 0),
//   'code' => array('occur' => 0, 'ratio' => 0),
//   'php' => array('occur' => 0, 'ratio' => 0),
//   'javascript' => array('occur' => 0, 'ratio' => 0)
// );

$set = array(
  'A' => array('occur' => 0, 'ratio' => 1),
  'B' => array('occur' => 0, 'ratio' => 1),
  'C' => array('occur' => 0, 'ratio' => 1),
  'D' => array('occur' => 0, 'ratio' => 1),
  'E' => array('occur' => 0, 'ratio' => 1),
  'F' => array('occur' => 0, 'ratio' => 1),
  'G' => array('occur' => 0, 'ratio' => 1),
  'H' => array('occur' => 0, 'ratio' => 1),
  'I' => array('occur' => 0, 'ratio' => 1),
  'J' => array('occur' => 0, 'ratio' => 1),
  'K' => array('occur' => 0, 'ratio' => 1),
  'L' => array('occur' => 0, 'ratio' => 1),
  'M' => array('occur' => 0, 'ratio' => 1),
  'N' => array('occur' => 0, 'ratio' => 1),
  'O' => array('occur' => 0, 'ratio' => 1),
  'P' => array('occur' => 0, 'ratio' => 1),
  'Q' => array('occur' => 0, 'ratio' => 1),
  'R' => array('occur' => 0, 'ratio' => 1),
  'S' => array('occur' => 0, 'ratio' => 1),
  'T' => array('occur' => 0, 'ratio' => 1),
  'U' => array('occur' => 0, 'ratio' => 1),
  'V' => array('occur' => 0, 'ratio' => 1),
  'W' => array('occur' => 0, 'ratio' => 1),
  'X' => array('occur' => 0, 'ratio' => 1),
  'Y' => array('occur' => 0, 'ratio' => 1),
  'Z' => array('occur' => 0, 'ratio' => 1)
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
} else if (!preg_match('/^<([A-Za-z]+([:][0][.][1-9])?[;])+>$/', $queryUpper)){
    $title = "Whoops...";
    $message = "We're unable to find data you're looking for";
    $btnText = "Find Again";
} else { 

  // function score to calculate the score of the 3 files
  function score($set, $queryUpper, $fileContent, $len) {
    // init score var with 0 
    $score = 0;
    // loop through $set characters to fetch each char
    foreach($set as $key => $val) {
      // check if character exist in query
      if(strpos($queryUpper, $key)){
        // count occur for every $key
        $numberOfKey = count_occur($fileContent, $key);
        // add how many key exist in file to 'occur counter'
        $set[$key]['occur'] += $numberOfKey;
        // get the start position of ratio
        $start = strpos($queryUpper, $key);
        if($queryUpper[$start + strlen($key)] == ';') {
          $set[$key]['ratio'] = 1;
        } else {
          $start = strpos($queryUpper, $key) + strlen($key) + 1;
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
  
  // function takes string => 'file content' and search substring 
  // then return how many time substring exist
  function count_occur ($fileContent, $key) {
    // result
    $result = 0;
    // get file length
    $keyLength = strlen($key);
    // each loop add character occur in set
    for($i = 0; $i < strlen($fileContent); $i++) {
      // if $key found add $key length to $i
      if(substr($fileContent, $i, $keyLength) == $key) {
        $result += 1;
        $i += $keyLength - 1;
      }
    }
    return $result;
  }

  // get files content
  $fileContent1 = file_get_contents("file1.txt");
  $fileContent2 = file_get_contents("file2.txt");
  $fileContent3 = file_get_contents("file3.txt");
  $fileContent4 = file_get_contents("file4.txt");
  $fileContent5 = file_get_contents("file5.txt");

  // get files score
  $fileScore_1 = score($set, $queryUpper, $fileContent1, strlen($fileContent1));
  $fileScore_2 = score($set, $queryUpper, $fileContent2, strlen($fileContent2));
  $fileScore_3 = score($set, $queryUpper, $fileContent3, strlen($fileContent3));
  $fileScore_4 = score($set, $queryUpper, $fileContent4, strlen($fileContent4));
  $fileScore_5 = score($set, $queryUpper, $fileContent5, strlen($fileContent5));

  // files
  $files = [
      "<a href='http://localhost/information-retrieval/statistical-model/file1.txt' target='_blank'>file1</a>" => $fileScore_1,
      "<a href='http://localhost/information-retrieval/statistical-model/file2.txt' target='_blank'>file2</a>" => $fileScore_2,
      "<a href='http://localhost/information-retrieval/statistical-model/file3.txt' target='_blank'>file3</a>" => $fileScore_3,
      "<a href='http://localhost/information-retrieval/statistical-model/file4.txt' target='_blank'>file4</a>" => $fileScore_4,
      "<a href='http://localhost/information-retrieval/statistical-model/file5.txt' target='_blank'>file5</a>" => $fileScore_5
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
          <a href="http://localhost/information-retrieval/statistical-model/index.php" class="back"> Search Again </a>
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
          <a href="http://localhost/information-retrieval/statistical-model/index.php">' . $btnText . '</a>
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
