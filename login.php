<?php
   session_start();
   if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
   {
       header("location: welcome.php");
       exit;
   }
   require_once "config.php";
   $username = $password = "";
   $username_err = $password_err = $login_err = "";
   if ($_SERVER["REQUEST_METHOD"] == "POST")
   {
       if (empty(trim($_POST["username"])))
       {
           $username_err = "Please enter username.";
       }
       else
       {
           $username = trim($_POST["username"]);
       }
       if (empty(trim($_POST["pw"])))
       {
           $password_err = "Please enter your password.";
       }
       else
       {
           $password = trim($_POST["pw"]);
       }
       if (empty($username_err) && empty($password_err))
       {
           $sql = "SELECT id, username, password FROM users WHERE username = ?";
   
           if ($stmt = mysqli_prepare($link, $sql))
           {
               mysqli_stmt_bind_param($stmt, "s", $param_username);
               $param_username = $username;
               if (mysqli_stmt_execute($stmt))
               {
                   mysqli_stmt_store_result($stmt);
                   if (mysqli_stmt_num_rows($stmt) == 1)
                   {
                       mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                       if (mysqli_stmt_fetch($stmt))
                       {
                           if (password_verify($password, $hashed_password))
                           {
                               session_start();
                               $_SESSION["loggedin"] = true;
                               $_SESSION["id"] = $id;
                               $_SESSION["username"] = $username;
                               header("location: welcome.php");
                           }
                           else
                           {
                               $login_err = "Invalid username or password.";
                           }
                       }
                   }
                   else
                   {
                       $login_err = "Invalid username or password.";
                   }
               }
               else
               {
                   echo "Oops! Something went wrong. Please try again later.";
               }
               mysqli_stmt_close($stmt);
           }
       }
       mysqli_close($link);
   }
   ?>
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
               <form style="margin-top:2vh" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="form-group">
                     <h2> Login </h2>
                     <label for="username">Username</label>
                     <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                     <span class="invalid-feedback"><?php echo $username_err; ?></span>
                  </div>
                  <div class="form-group">
                     <label for="pw">Password:</label>
                     <input type="password" name="pw" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                     <span class="invalid-feedback"><?php echo $password_err; ?></span>
                  </div>
                  <input type="submit" class="btn btn-primary" value="Login" id="login">
                  <p>Don't have an account? <a href="register.php" style="text-decoration: none;">Sign up now</a>.</p>
               </form>
            </section>
         </section>
      </section>
      <script>  
         function validation()  
         {  
             var us=document.f1.user.value;  
             var ps=document.f1.pw.value;  
             if(us.length=="" && ps.length=="") {  
                 alert("Fields are empty");  
                 return false;  
             }  
             else  
             {  
                 if(id.length==0) {  
                     alert("User Name is empty");  
                     return false;  
                 }   
                 if (ps.length==0) {  
                 alert("Password field is empty");  
                 return false;  
                 }  
             }                             
         }  
      </script>  
   </body>
</html>