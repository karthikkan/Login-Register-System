<?php
   session_start();
   
   if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
   {
       header("location: login.php");
       exit;
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <html>
      <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
         <link rel="stylesheet" href="style.css">
      </head>
      <body>
         <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
         <section class="container-fluid">
            <section class="row justify-content-center">
               <section class="col-12 col-sm-6 col-md-4">
                  <form class="form-container" style="margin-top:20%">
                     <h2>Welcome <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.<br> Login Succesful</h2>
                  </form>
               </section>
            </section>
         </section>
      </body>
   </html>