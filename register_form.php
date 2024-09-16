<?php

@include 'config.php';
include 'navbar.html';


if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   $age = mysqli_real_escape_string($conn, $_POST['age']);
   $bloodGroup = mysqli_real_escape_string($conn, $_POST['bloodGroup']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $district = mysqli_real_escape_string($conn, $_POST['district']);
   $thana = mysqli_real_escape_string($conn, $_POST['thana']);
   $area = mysqli_real_escape_string($conn, $_POST['area']);
   $availability = isset($_POST['availability']) ? 1 : 0;

// Handle image upload
$image = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];
$image_size = $_FILES['image']['size'];
$image_error = $_FILES['image']['error'];
$image_type = $_FILES['image']['type'];

$image_ext = strtolower(end(explode('.', $image)));
$allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

if (in_array($image_ext, $allowed_ext)) {
   if ($image_size <= 2097152) { // 2MB
      $image_name = uniqid('', true) . '.' . $image_ext;
      $image_path = 'uploads/' . $image_name;
      move_uploaded_file($image_tmp, $image_path);
   } else {
      $error[] = 'Image size should be less than 2MB';
   }
} else {
   $error[] = 'Invalid image format';
}

   $select = " SELECT * FROM donor_information WHERE email = '$email' && password = '$pass' ";


   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{
      $insert = "INSERT INTO donor_information (name, email, password, gender, bloodGroup, age, phone, district, thana, area, availability, image) 
      VALUES ('$name', '$email', '$pass', '$gender', '$bloodGroup', $age, $phone, '$district', '$thana', '$area', $availability, '$image_path')";


         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!-- custom css file link  -->
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
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease;
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            color: #333;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-field {
            flex: 1;
            min-width: 200px;
            display: flex;
            flex-direction: column;
        }

        .form-field label {
            margin-bottom: 5px;
            font-size: 16px;
            color: #555;
            font-weight: 500;
        }

        .form-field input,
        .form-field select {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: border 0.3s ease, box-shadow 0.3s ease;
        }

        .form-field input:focus,
        .form-field select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .form-field input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: border 0.3s ease, box-shadow 0.3s ease;
        }

        .form-field input[type="number"]::placeholder {
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
        }

        .form-group button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .error-msg {
            color: red;
            display: block;
            margin-bottom: 10px;
            text-align: center;
        }

        .form-group small {
            color: #666;
            font-size: 14px;
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

        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-inline {
                flex-direction: column;
            }
        }
        

        
    </style>
</head>
<body>
   
<div class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Register as a Donor</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
<!-- Name and Email Fields -->
<div class="form-group inline-group">
    <div class="form-inline">
        <div class="form-field">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
    </div>
</div>

<!-- Password Field -->
<div class="form-group">
    <div class="form-field">
        <label for="newPassword">Password:</label>
        <input type="password" id="newPassword" name="password" required>
    </div>
</div>

<!-- Gender, Blood Group, Age and Phone Number Fields -->
<div class="form-group">
    <div class="form-inline">
        <div class="form-field">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="" disabled selected>Select your gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-field">
            <label for="bloodGroup">Blood Group:</label>
            <select id="bloodGroup" name="bloodGroup" required>
                <option value="" disabled selected>Select your blood group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>
    </div>
</div>

<!-- Phone Number and Age Fields -->
<div class="form-group phone-age-group">
    <div class="form-inline">
        <div class="form-field input-half">
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" pattern="\d{10}" required>
            <small>Enter 10-digit phone number</small>
        </div>
        <div class="form-field input-half">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="0" max="100" placeholder="Enter your age" required>
        </div>
    </div>
</div>

<!-- District, Thana, Area, and Availability Fields -->
<div class="form-group">
    <div class="form-inline">
        <div class="form-field">
            <label for="district">District:</label>
            <select id="district" name="district" required>
                <option value="" disabled selected>Select your district</option>
                <option value="District1">District 1</option>
                <option value="District2">District 2</option>
                <option value="District3">District 3</option>
            </select>
        </div>
        <div class="form-field">
            <label for="thana">Thana:</label>
            <select id="thana" name="thana" required>
                <option value="" disabled selected>Select your thana</option>
                <option value="Thana1">Thana 1</option>
                <option value="Thana2">Thana 2</option>
                <option value="Thana3">Thana 3</option>
            </select>
        </div>
        <div class="form-field">
            <label for="area">Area:</label>
            <select id="area" name="area" required>
                <option value="" disabled selected>Select your area</option>
                <option value="Area1">Area 1</option>
                <option value="Area2">Area 2</option>
                <option value="Area3">Area 3</option>
            </select>
        </div>
        <div class="form-field">
            <label for="availability">Available for donation right now?</label>
            <select id="availability" name="availability" required>
                <option value="" disabled selected>Select an option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
    </div>
</div>

<!-- Image Upload Field -->
<div class="form-group">
    <div class="form-field">
        <label for="image">Upload Profile Picture:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
    </div>
</div>

<!-- Submit Button -->
<div class="form-group">
    <button type="submit" name="submit" value="register now">Register</button>
</div>

<p>Already have an account? <a href="login_form.php">Login now</a></p>
   </form>
</div>

</body>
</html>
