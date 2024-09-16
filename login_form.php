<?php
session_start();
@include 'config.php';
include 'navbar.html';


if (isset($_POST['submit'])) {

    // Escape input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']); // Encrypt password with md5 (although it's better to use stronger hashing like bcrypt)

    // Query to check if email and password match
    $select = "SELECT * FROM donor_information WHERE email = '$email' AND password = '$pass'";
    $result = mysqli_query($conn, $select);

    // If email and password match a record in the database
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
         // Set session variables for the logged-in user
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_gender'] = $row['gender'];
         $_SESSION['user_age'] = $row['age'];
         $_SESSION['user_bloodGroup'] = $row['bloodGroup'];
         $_SESSION['user_phone'] = $row['phone'];
         $_SESSION['user_district'] = $row['district'];
         $_SESSION['user_thana'] = $row['thana'];
         $_SESSION['user_area'] = $row['area'];
         $_SESSION['user_availability'] = $row['availability'];
         
        // Redirect to user page after successful login
        header('location:user_page.php');
    } else {
        // If email or password don't match, display an error
        $error[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>
   <style>
       body {
           margin: 0;
           padding: 0;
           font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
           background: url('registerPage.jpg') no-repeat center center fixed;
           background-size: cover;
           height: 100vh;
           display: flex;
           justify-content: center;
           align-items: center;
       }

       .form-container {
           background-color: rgba(255, 255, 255, 0.95);
           padding: 40px;
           border-radius: 12px;
           width: 100%;
           max-width: 360px;
           box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
           transition: transform 0.3s ease, box-shadow 0.3s ease;
       }

       .form-container:hover {
           transform: scale(1.02);
           box-shadow: 0 18px 36px rgba(0, 0, 0, 0.2);
       }

       h3 {
           text-align: center;
           margin-bottom: 30px;
           font-size: 28px;
           color: #333;
           font-weight: 600;
       }

       .form-group {
           margin-bottom: 20px;
       }

       .form-group input {
           width: 100%;
           padding: 14px;
           font-size: 16px;
           border: 2px solid #ddd;
           border-radius: 8px;
           outline: none;
           transition: border 0.3s ease, box-shadow 0.3s ease;
           background: #f5f5f5;
           box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
       }

       .form-group input:focus {
           border-color: #007bff;
           box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
           background: #fff;
       }

       .form-group input::placeholder {
           color: #888;
       }

       .form-group button {
           width: 100%;
           padding: 14px;
           font-size: 18px;
           background-color: #007bff;
           color: white;
           border: none;
           border-radius: 8px;
           cursor: pointer;
           transition: background-color 0.3s ease, transform 0.2s ease;
           box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
       }

       .form-group button:hover {
           background-color: #0056b3;
           transform: scale(1.05);
           box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
       }

       .error-msg {
           color: red;
           display: block;
           margin-bottom: 10px;
           text-align: center;
           font-size: 14px;
       }

       .form-group p {
           text-align: center;
           margin-top: 20px;
           font-size: 14px;
       }

       .form-group a {
           color: #007bff;
           text-decoration: none;
           font-weight: 600;
       }

       .form-group a:hover {
           text-decoration: underline;
       }

       @keyframes fadeIn {
           from {
               opacity: 0;
               transform: translateY(20px);
           }
           to {
               opacity: 1;
               transform: translateY(0);
           }
       }
   </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Login Now</h3>

            <!-- Display error message if any -->
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>

            <div class="form-group">
                <input type="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <input type="password" name="password" required placeholder="Enter your password">
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Login Now</button>
            </div>
            <div class="form-group">
                <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
            </div>
        </form>
    </div>
</body>
</html>
