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
  <link href="angularjs/css/site.css" type="text/css" rel="stylesheet">
</head>
<body>

  <div ng-view></div>

</body>
</html>
