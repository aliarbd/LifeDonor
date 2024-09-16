<?php
include 'navbar.html';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Search</title>
    <!-- custom css file link  -->
    <link rel="stylesheet" href="search.css">
</head>
<body>
    <h2>Search for Blood Donors</h2>
    
    <!-- Search Form -->
    <form action="" method="POST">
        <div class="form-inline">
            <div class="form-field">
                <label for="blood_group">Blood Group:</label>
                <select name="blood_group" id="blood_group" required>
                    <option value="" disabled selected>Select Blood Group</option>
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
            <div class="form-field">
                <label for="district">District:</label>
                <select name="district" id="district">
                    <option value="" disabled selected>Select District</option>
                    <option value="District1">District 1</option>
                    <option value="District2">District 2</option>
                    <option value="District3">District 3</option>
                    <!-- Add more districts -->
                </select>
            </div>
        </div>

        <div class="form-inline">
            <div class="form-field">
                <label for="thana">Thana:</label>
                <select name="thana" id="thana">
                    <option value="" disabled selected>Select Thana</option>
                    <option value="Thana1">Thana 1</option>
                    <option value="Thana2">Thana 2</option>
                    <option value="Thana3">Thana 3</option>
                    <!-- Add more thanas -->
                </select>
            </div>
            <div class="form-field">
                <label for="area">Area:</label>
                <select name="area" id="area">
                    <option value="" disabled selected>Select Area</option>
                    <option value="Area1">Area 1</option>
                    <option value="Area2">Area 2</option>
                    <option value="Area3">Area 3</option>
                    <!-- Add more areas -->
                </select>
            </div>
        </div>

        <button type="submit" name="search">Search</button>
    </form>

    <!-- Results Section -->
    <div class="results">

        <?php
        @include 'config.php';

        if (isset($_POST['search'])) {
            // Collect form data
            $blood_group = $_POST['blood_group'];
            $district = isset($_POST['district']) ? $_POST['district'] : '';
            $thana = isset($_POST['thana']) ? $_POST['thana'] : '';
            $area = isset($_POST['area']) ? $_POST['area'] : '';

            // SQL query to search donors, including the image and availability columns
            $sql = "SELECT name, bloodGroup, phone, district, thana, area, image, availability FROM donor_information WHERE bloodGroup='$blood_group'";

            // Optional filters for district, thana, and area
            if (!empty($district)) {
                $sql .= " AND district='$district'";
            }
            if (!empty($thana)) {
                $sql .= " AND thana='$thana'";
            }
            if (!empty($area)) {
                $sql .= " AND area='$area'";
            }

            // Execute the query
            $result = $conn->query($sql);

            // Check if there are any results
            if ($result->num_rows > 0) {
                // Output donor profiles
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='donor-profile'>";
                    
                    // Get the correct image path without prepending 'uploads/'
                    $imagePath = $row['image'];

                    // Display the image if available
                    if (!empty($imagePath) && file_exists($imagePath)) {
                        echo "<img src='" . $imagePath . "' alt='Profile Image'>";
                    } else {
                        echo "<img src='uploads/default.jpg' alt='Default Profile Image'>";
                    }

                    // Display donor information including availability
                    echo "<div class='donor-details'>";
                    echo "<strong>Name:</strong> " . $row['name'] . "<br>";
                    echo "<strong>Blood Group:</strong> " . $row['bloodGroup'] . "<br>";
                    echo "<strong>Phone:</strong> " . $row['phone'] . "<br>";
                    echo "<strong>District:</strong> " . $row['district'] . "<br>";
                    echo "<strong>Thana:</strong> " . $row['thana'] . "<br>";
                    echo "<strong>Area:</strong> " . $row['area'] . "<br>";
                    echo "<strong>Availability:</strong> " . ($row['availability'] ? 'Available' : 'Not Available') . "<br>";
                    echo "<a href='tel:" . $row['phone'] . "' class='contact-button'> Contact </a>";
                    echo "</div>"; // Close donor-details
                    echo "</div>"; // Close donor-profile

                }
            } else {
                echo "No donors found matching your criteria.";
            }

            // Close connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
