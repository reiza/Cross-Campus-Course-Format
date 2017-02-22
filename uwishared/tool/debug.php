<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Minimum Requirements Test</title>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>

    <style media="screen">
    body {
      font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",sans-serif;
    }
    </style>
  </head>
  <body>
<?php
$path = ini_get('error_log') ;
// echo "<div style='height:240px;overflow-y:auto;' class='content'>";
echo "<pre class='prettyprint' style='max-height: 360px;overflow-y: scroll;'>";
echo 'Last 50 lines from error log found at: ' . $path . "\n\n";

//echo htmlspecialchars(file_get_contents($path));
$fileArray = file($path);
if (is_array($fileArray)) {
  $lastLines = array_slice($fileArray,-50);
  foreach ($lastLines as $key=>$row) {
  		 echo htmlspecialchars($row);
  }
}
echo "</pre>";
?>
  </body>
</html>
