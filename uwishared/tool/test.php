<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Minimum Requirements Test</title>
    <style media="screen">
    body {
      font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",sans-serif;
    }
    .card {
    border:1px solid #ddd;
    display: flex;
    align-items: center;
    min-height: 96px;
    min-width:  96px;
    max-width: 30%;
    margin-bottom:10px;
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    /* Add some padding inside the card container */
    .container {
        padding: 2px 16px;
    }

    .func {
      color: green;
    }
    </style>
  </head>
  <body>

      <?php

      echo '<div class="card"><div class="container">';

      if (version_compare(phpversion(), '5.5') < 0) {
        echo "<p>Requires at least PHP 5.5 (currently using version " . phpversion() . ").</p>";
      } else {
        echo "<p>PHP version " . phpversion() . " is OK.</p>";
      }
      echo '</div></div>';

      $funcs = array(
        'hash',
        'json_encode',
        'json_decode',
        'base64_encode',
        'base64_decode',
        'openssl_encrypt',
        'openssl_decrypt'
      );

      foreach ($funcs as $key => $func) {
        echo '<div class="card"><div class="container">';

        if (!function_exists($func)) {
            echo '<p>Requires the <span class="func">' . $func . '()</span> PHP function.</p>';
        } else {
          echo '<p>The <span class="func">' . $func . '()</span> PHP function is OK.</p>';
        }
        echo '</div></div>';

      }
      ?>
    </div>
  </body>
</html>
