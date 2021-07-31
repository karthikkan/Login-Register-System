<?php
   require_once "config.php";
   $username = $password = $confirm_password = "";
   $username_err = $password_err = $confirm_password_err = "";
   global $db;
   if ($_SERVER["REQUEST_METHOD"] == "POST")
   {
       if (empty(trim($_POST["username"])))
       {
           $username_err = "Please enter a username.";
       }
       elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"])))
       {
           $username_err = "Username can only contain letters, numbers, and underscores.";
       }
       else
       {
           $sql = "SELECT id FROM users WHERE username = ?";
   
           if ($stmt = mysqli_prepare($link, $sql))
           {
               mysqli_stmt_bind_param($stmt, "s", $param_username);
               $param_username = trim($_POST["username"]);
               if (mysqli_stmt_execute($stmt))
               {
                   mysqli_stmt_store_result($stmt);
   
                   if (mysqli_stmt_num_rows($stmt) == 1)
                   {
                       $username_err = "This username is already taken.";
                   }
                   else
                   {
                       $username = trim($_POST["username"]);
                   }
               }
               else
               {
                   echo "Oops! Something went wrong. Please try again later.";
               }
               mysqli_stmt_close($stmt);
           }
       }
       if (empty(trim($_POST["password"])))
       {
           $password_err = "Please enter a password.";
       }
       elseif (strlen(trim($_POST["password"])) < 6)
       {
           $password_err = "Password must have atleast 6 characters.";
       }
       else
       {
           $password = trim($_POST["password"]);
       }
       if (empty(trim($_POST["confirm_password"])))
       {
           $confirm_password_err = "Please confirm password.";
       }
       else
       {
           $confirm_password = trim($_POST["confirm_password"]);
           if (empty($password_err) && ($password != $confirm_password))
           {
               $confirm_password_err = "Password did not match.";
           }
       }
       if (empty($username_err) && empty($password_err) && empty($confirm_password_err))
       {
           $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
   
           if ($stmt = mysqli_prepare($link, $sql))
           {
               mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
               $param_username = $username;
               $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
               if (mysqli_stmt_execute($stmt))
               {
                   header("location: login.php");
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
   
   $image_error = "";
   if (isset($_POST['register']))
   {
       $image = $_FILES['image']['name'];
       $target = "images/" . basename($image);
   
       $sql = "INSERT INTO users (image) VALUES ('$image')";
       mysqli_query($link, $sql);
   
       if (move_uploaded_file($_FILES['image']['tmp_name'], $target))
       {
           $image_error = "Image uploaded successfully";
       }
       else
       {
           $image_error = "Failed to upload image";
       }
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
               <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                     <h2> Register </h2>
                     <label for="username">Username</label>
                     <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                     <span class="invalid-feedback"><?php echo $username_err; ?></span>
                  </div>
                  <div class="form-group">
                     <label for="pw">Password:</label>
                     <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                     <span class="invalid-feedback"><?php echo $password_err; ?></span>
                  </div>
                  <div class="form-group">
                     <label for="pw">Confirm Password:</label>
                     <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                     <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                  </div>
                  <div class="form-group">
                     <input type="file" name="image" name="Profile Picture">
                  </div>
                  <input type="submit" class="btn btn-primary" value="Register" id="login" name="register">
                  <p>Already have an account? <a href="login.php" style="text-decoration: none;">Login here</a>.</p>
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