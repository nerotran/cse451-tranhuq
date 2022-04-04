<?php
/*
 *Name: Nero Tran Huu
 *Course: CSE 551
 *Assignment: rest3-billboard
 *Date: 3/28/2022
 *File: index.php
 **/
require_once ".db.php";

$nonce = time();
$token = hash_hmac('ripemd160','nero'.$nonce,$MYSECRETTOKEN);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Billboard Assignment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script type="text/javascript">
      var nonce = <?php echo "'$nonce'"; ?>;
      var token = <?php echo "'$token'" ?>;
    </script>
    <script src="index.js"></script>

    <style>
     .border {
        outline:  3px solid black;
     }
     #footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
      }
    </style>

  </head>

  <body>

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.html"><img alt="Logo" src="logo.png" height="24" width="40"/></a>
        </div> <!-- class="navbar-header" -->
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.html">Home</a></li>
        </ul>
      </div> <!-- class="container-fluid" -->
    </nav> 

    <div class="jumbotron text-center">
      <h1>Billboard Database</h1>
      <p>Nero Tran Huu, CSE 551, 3/26/2022</p> 
    </div> <!-- class="jumbotron text-center" -->
  
    <div>
      <table class="table" >
        <thead>
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Song</th>
            <th scope="col">Artist</th>
            <th scope="col">Rank</th>
            <th scope="col">Thumbs</th>
          </tr>
        </thead>
        <tbody id="table">
        </tbody>
      </table>

    </div> <!-- id="table" -->

    <div class="footer">
    <div class="container">
    <div class="row">
    <div class="col-md-12 text-center">
      <p>Nero Tran Huu, CSE551, Billboard Database, 3/26/2022</p>
    </div> <!-- class="footer" -->
    </div> <!-- class="container" -->
    </div> <!-- class="row" -->
    </div> <!-- class="col-md-12 text-center" -->
  </body>
</html>

