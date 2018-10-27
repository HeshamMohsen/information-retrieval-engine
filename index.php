<!DOCTYPE html>
<html lang="eng">
<head>
  <title>Statistical Model</title>
  <link rel="stylesheet" href="css/normalize.css"> 
  <link rel="stylesheet" href="css/ir.css">
</head>
<body>

<div class="container">

  <div class="header-title">
    <h1>Find a file.</h1>
  </div>

  <div class="forms">
    <form action="/IRP/rank.php" method="post">
      <input type="text" name="querystring" placeholder="Ex: <A:0.4;B:0.6;C;>" autofocus>
      <input type="submit" value="Search" class="button">
    </form>

    <form action="/IRP/generate.php" method="post">
      <input type="submit" value="Generate" class="button button--white">
    </form>
  </div>

</div>

</body>
</html>
