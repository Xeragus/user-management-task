<!DOCTYPE html>
<html>
  <head>
    <meta name="csrf-token" content="<?= getCsrfToken() ?>">
  	
    <title>User Management</title>
    
    <link href="favicon.ico" type="image/x-icon" rel="icon" />
    <link href="favicon.ico" type="image/x-icon" rel="shortcut icon" />	
    
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/application.css">
    
    <script type="text/javascript" charset="utf-8" src="js/jquery.min.js"></script>
	  <script type="text/javascript" charset="utf-8" src="js/bootstrap.min.js"></script>

  </head>
  <body>

    <div class="container">
      
      <?= $content ?>
      
    </div>  
    <div id="toast-container" class="toast-container"></div>
  </body>
</html>