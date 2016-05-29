<?php
/**
 * @file polls.php
 * @author Patrick Nicholls, adapted from Matthew Ruffell
 * @date 18/05/2016
 * @brief This file simply serves up the original angular frontpage
 */
echo doctype('html5');
?>


<html lang="en" ng-app="pollsApp">
<head>
  <meta charset="utf-8">
  <title>Polls</title>
  <?php
  $links = array (
    "angularjs/scripts/jquery.min.js", 
    "angularjs/scripts/angular.js", 
    "angularjs/scripts/angular-route.js",
    "angularjs/scripts/bootstrap.min.js",
    "angularjs/js/app.js",
    "angularjs/js/controllers.js"
    );
  $scripts = "";
  foreach ($links as $value) {
      $scripts.= '<script src="';
      $scripts.= base_url($value);
      $scripts.= '"></script>';
      $scripts.= "\n";
  }
  echo $scripts;
  ?>
    
    <link href="angularjs/css/bootstrap.min.css" rel="stylesheet">
    <link href="angularjs/css/heroic-features.css" rel="stylesheet">
</head>
<body>
        <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#/polls/">Poll List</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#/about/">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
    <div ng-view></div>
        
    <hr>
  
    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Patrick Nicholls </p>
            </div>
        </div>
    </footer>
    </div>

</body>
</html>
