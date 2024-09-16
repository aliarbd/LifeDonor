<?php

session_start();
@include 'config.php';
include 'navbar.html';


if (!isset($_SESSION['user_name'])) {
    header('location:login_form.php');
}


// Check if the form to update all details is submitted
if (isset($_POST['update_details'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $bloodGroup = mysqli_real_escape_string($conn, $_POST['bloodGroup']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $thana = mysqli_real_escape_string($conn, $_POST['thana']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $user_email = $_SESSION['user_email'];
    $image_path = $_SESSION['user_image']; // default to existing image

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($image_ext, $allowed_exts)) {
            $image_path = 'uploads/' . uniqid() . '.' . $image_ext;

            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Successfully uploaded image
            } else {
                $error_message = "Failed to upload image. Try again!";
            }
        } else {
            $error_message = "Invalid image format. Please upload JPG, JPEG, PNG, or GIF.";
        }
    }

    // Update all details in the database
    $update_query = "UPDATE donor_information SET name='$name', email='$email', gender='$gender', age='$age', bloodGroup='$bloodGroup', phone='$phone', district='$district', thana='$thana', area='$area', availability='$availability', image='$image_path' WHERE email='$user_email'";

    if (mysqli_query($conn, $update_query)) {
        // If updated in the database, update the session variables as well
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_gender'] = $gender;
        $_SESSION['user_age'] = $age;
        $_SESSION['user_bloodGroup'] = $bloodGroup;
        $_SESSION['user_phone'] = $phone;
        $_SESSION['user_district'] = $district;
        $_SESSION['user_thana'] = $thana;
        $_SESSION['user_area'] = $area;
        $_SESSION['user_availability'] = $availability;
        $_SESSION['user_image'] = $image_path; // Update the session image path
        $success_message = "Details updated successfully!";
    } else {
        $error_message = "Failed to update details. Try again!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>

    <link rel="stylesheet" href="user_page.css">



</head>
<body>

<div class="container">
    <div class="info-container">
        <h2>Your Information</h2>
        <div class="info-item">
            <?php if (isset($_SESSION['user_image']) && !empty($_SESSION['user_image'])): ?>
                <img src="<?php echo htmlspecialchars($_SESSION['user_image']); ?>" alt="Profile Picture" style="max-width: 150px; max-height: 150px;">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
        </div>
        <div class="info-item"><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
        <div class="info-item"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></div>
        <div class="info-item"><strong>Gender:</strong> <?php echo htmlspecialchars($_SESSION['user_gender']); ?></div>
        <div class="info-item"><strong>Age:</strong> <?php echo htmlspecialchars($_SESSION['user_age']); ?></div>
        <div class="info-item"><strong>Blood Group:</strong> <?php echo htmlspecialchars($_SESSION['user_bloodGroup']); ?></div>
        <div class="info-item"><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION['user_phone']); ?></div>
        <div class="info-item"><strong>District:</strong> <?php echo htmlspecialchars($_SESSION['user_district']); ?></div>
        <div class="info-item"><strong>Thana:</strong> <?php echo htmlspecialchars($_SESSION['user_thana']); ?></div>
        <div class="info-item"><strong>Area:</strong> <?php echo htmlspecialchars($_SESSION['user_area']); ?></div>
        <div class="info-item"><strong>Availability:</strong> <?php echo $_SESSION['user_availability'] == '1' ? 'Available' : 'Not Available'; ?></div>
        <div class="info-item"> <button> <a href="logout.php">Logout</a> </button> </div>

    </div>

    <div class="update-container">
        <h2>Update Your Details</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group full-width">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
            </div>
            <div class="form-group full-width">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" required>
            </div>
            <div class="form-group short">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="" disabled>Select your gender</option>
                    <option value="male" <?php echo $_SESSION['user_gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo $_SESSION['user_gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo $_SESSION['user_gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group short">
                <label for="age">Age:</label>
                <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($_SESSION['user_age']); ?>" required>
            </div>
            <div class="form-group short">
    <label for="bloodGroup">Blood Group:</label>
    <select name="bloodGroup" id="bloodGroup" required>
        <option value="" disabled selected>Select your blood group</option>
        <option value="A+" <?php echo $_SESSION['user_bloodGroup'] == 'A+' ? 'selected' : ''; ?>>A+</option>
        <option value="A-" <?php echo $_SESSION['user_bloodGroup'] == 'A-' ? 'selected' : ''; ?>>A-</option>
        <option value="B+" <?php echo $_SESSION['user_bloodGroup'] == 'B+' ? 'selected' : ''; ?>>B+</option>
        <option value="B-" <?php echo $_SESSION['user_bloodGroup'] == 'B-' ? 'selected' : ''; ?>>B-</option>
        <option value="AB+" <?php echo $_SESSION['user_bloodGroup'] == 'AB+' ? 'selected' : ''; ?>>AB+</option>
        <option value="AB-" <?php echo $_SESSION['user_bloodGroup'] == 'AB-' ? 'selected' : ''; ?>>AB-</option>
        <option value="O+" <?php echo $_SESSION['user_bloodGroup'] == 'O+' ? 'selected' : ''; ?>>O+</option>
        <option value="O-" <?php echo $_SESSION['user_bloodGroup'] == 'O-' ? 'selected' : ''; ?>>O-</option>
    </select>
</div>

<div class="form-group short">
                <label for="phone">Phone:</label>
                <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($_SESSION['user_phone']); ?>" required>
</div>

<div class="form-group short">
    <label for="district">District:</label>
    <select id="district" name="district" required>
        <option value="" disabled selected>Select your district</option>
        <option value="District1" <?php echo $_SESSION['user_district'] == 'District1' ? 'selected' : ''; ?>>District 1</option>
        <option value="District2" <?php echo $_SESSION['user_district'] == 'District2' ? 'selected' : ''; ?>>District 2</option>
        <option value="District3" <?php echo $_SESSION['user_district'] == 'District3' ? 'selected' : ''; ?>>District 3</option>
    </select>
</div>
<div class="form-group short">
    <label for="thana">Thana:</label>
    <select id="thana" name="thana" required>
        <option value="" disabled selected>Select your thana</option>
        <option value="Thana1" <?php echo $_SESSION['user_thana'] == 'Thana1' ? 'selected' : ''; ?>>Thana 1</option>
        <option value="Thana2" <?php echo $_SESSION['user_thana'] == 'Thana2' ? 'selected' : ''; ?>>Thana 2</option>
        <option value="Thana3" <?php echo $_SESSION['user_thana'] == 'Thana3' ? 'selected' : ''; ?>>Thana 3</option>
    </select>
</div>
<div class="form-group short">
    <label for="area">Area:</label>
    <select id="area" name="area" required>
        <option value="" disabled selected>Select your area</option>
        <option value="Area1" <?php echo $_SESSION['user_area'] == 'Area1' ? 'selected' : ''; ?>>Area 1</option>
        <option value="Area2" <?php echo $_SESSION['user_area'] == 'Area2' ? 'selected' : ''; ?>>Area 2</option>
        <option value="Area3" <?php echo $_SESSION['user_area'] == 'Area3' ? 'selected' : ''; ?>>Area 3</option>
    </select>
</div>

            <div class="form-group short">
                <label for="availability">Availability:</label>
                <select id="availability" name="availability" required>
                    <option value="1" <?php echo $_SESSION['user_availability'] == '1' ? 'selected' : ''; ?>>Available</option>
                    <option value="0" <?php echo $_SESSION['user_availability'] == '0' ? 'selected' : ''; ?>>Not Available</option>
                </select>
            </div>
            <div class="form-group full-width">
                <label for="image">Profile Picture:</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="form-group full-width">
                <button type="submit" name="update_details">Update Details</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
