<html>
  <body>...
<?php
   session_start();
  echo $_SESSION['api_rd'];
  header("Location: " . $_SESSION['api_rd']);
?>
    
  </body>
</html>