<?php
	/*
		Adam Coffman CS418 Index/home page
		
	*/
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>eSports Q and A Site</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>


  </head>

  <body>
    <nav class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
			      <li><a href="profile.php">Profile Page</a></li>
            <li><a href="logForm.php">Login/Register</a></li>  
            <li><a href="uploadBlob.php">Avatar</a></li>
            <li><a href="tagDisplay.php">Archive</a></li>            
			
          </ul>
        </div>
      </div>
    </nav>


    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="jumbotron">
            <h1>Hello sports fan!</h1>
            <p>This is a Q&amp;A site in response to the growing popularity of eSports. </p>
          </div>
        
      


    <!-- Code for live search box 
          Resource: http://www.finalwebsites.com/jquery-ajax-live-search/
    -->  
    
<div class="panel panel-primary">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-3">

       <?php 
        if($_SESSION['logged_in'] and $_SESSION['username'] == "ADMINISTRATOR")
        {
          echo 'Logged in as: <mark>' . $_SESSION['username'] . '</mark><br><a href="logOut.php">Log out</a>';
        }
        else if ($_SESSION['logged_in'])
        {
           echo 'Logged in as: <p class="text-info">' . $_SESSION['username'] . '</p><a href="logOut.php">Log out</a>';
        }
        else
        {}
      ?>
      <br>
      <br>

      <p><a class="btn btn-primary btn-lg" href="submitQuestion.php" role="button">Create Question</a></p>

        <form>
          <div class="search box">
            <label class="sr-only" >user name live search</label>
                <div class="input-group">
                  <div class="input-group-addon">Search:</div>
                  <input type="text" class="form-control" id="keyword" placeholder="Handle">
                </div>
          </div>
        </form>

        <ul  id="searchBar" ></ul>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
          $('#keyword').on('input', function() 
          {
            var searchKeyword = $(this).val();
            
            // If at least 1 character is entered, begin search -> searchProfile.php
            if (searchKeyword.length >= 1 ) 
            {
              $.post('userLiveSearch.php', { keywords: searchKeyword }, function(data) {
                $('ul#searchBar').empty()
                $.each(data, function() 
                {
                  $('ul#searchBar').append('<u><a href="searchProfile.php?searchname=' + this.name + '">' + this.name + '</a></li></u><p>  </p>');

                });
              }, "json");
            }

            // Else if, clear search box by appending blank space thereby clearing previous search
            else if (searchKeyword.length == 0 ) 
            {
              $.post('userLiveSearch.php', { keywords: searchKeyword }, function(data) {
                $('ul#searchBar').empty()
                $.each(data, function() 
                {
                  
                  $('ul#searchBar').append('');

                });
              }, "json");

            }
            // Else, say no match ? Not working 
            else if (searchKeyword.length > 7 ) 
            {
              $('ul#searchBar').append('No match');

            }
          });
        });
        </script>

      </div> 

     

      <div class="col-md-6">

      <!--<table class="table table-striped">-->
      <table class="table table-striped table-hover">
          <thead>
            <tr>
            
            <th>Title</th>
        
            <th>Asker</th>

            <th>Value</th>

            <th>Tags</th>
            
            </tr>
          </thead>
          <tbody>
            <?php

              // Show questions in each category where answers have highest total

              include_once 'connect.php';
              // Create connection
              $conn = new mysqli($servername, $username, $password, $dbname);
              // Check connection
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              } 
        
              $sql = "SELECT *  FROM question
                      ORDER BY q_value DESC LIMIT 5";
              $result = $conn->query($sql);
              
              while($row = mysqli_fetch_array($result))
                {
                  echo '<tr><td><a href="conversation.php?var=' . $row['q_id'] . '">' . $row['q_title'] . 
                  '</a></td><td>' . $row['q_asker'] . '</td><td>' . $row['q_value'] . '</td><td>' . 
                  '<a href="tagCollection.php?var='. $row['q_tags'] . '">' . $row['q_tags'] . '</a></td></tr>'; 
                
                }

                 mysqli_close($conn);
            ?>
          </tbody>
          </table>
      </div>

      
    



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>

    <script src="offcanvas.js"></script>
    </div>
    </div>
  </body>
</html>