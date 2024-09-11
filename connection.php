<!-- <?php
// Database connection details
$servername = "localhost";  // Server name
$username = "root";         // MySQL username (usually root)
$password = "";             // Leave password empty if no password is set
$dbname1 = "registration_db"; // Database for registration
$dbname2 = "login_db";        // Database for login

// // Create connections
// $conn1 = new mysqli($servername, $username, $password, $dbname1);
// $conn2 = new mysqli($servername, $username, $password, $dbname2);

// // Check connections
// if ($conn1->connect_error) {
//     die("Connection to registration_db failed: " . $conn1->connect_error);
// }
// if ($conn2->connect_error) {
//     die("Connection to login_db failed: " . $conn2->connect_error);
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $form_type = $_POST['form_type'];

    // if ($form_type == "register") {
    //     // Registration form data
    //     $name = $_POST['name'];
    //     $email = $_POST['email'];
    //     $password = $_POST['newPassword'];
    //     $gender = $_POST['gender'];
    //     $mode = $_POST['mode'];
    //     $age = $_POST['age'];
    //     $phoneNumber = $_POST['phoneNumber'];


        // Insert data into registration_db
    //     $sql = "INSERT INTO registrations (name, email, password, gender, mode, age, phoneNumber, smoker, alcoholic)
    //             VALUES ('$name', '$email', '$password', '$gender', '$mode', '$age', '$phoneNumber', '$smoker', '$alcoholic')";

    //     if ($conn1->query($sql) === TRUE) {
    //         echo "Registration successful";
    //     } else {
    //         echo "Error: " . $sql . "<br>" . $conn1->error;
    //     }
    // }
    // elseif ($form_type == "login") {
    //     // Login form data
    //     $username = $_POST['username'];
    //     $password = $_POST['password'];
    //     $bloodGroup = $_POST['bloodGroup'];

    //     // Insert data into login_db
    //     $sql = "INSERT INTO users (username, password, bloodGroup)
    //             VALUES ('$username', '$password', '$bloodGroup')";

    //     if ($conn2->query($sql) === TRUE) {
    //         echo "Login successful";
    //     } else {
    //         echo "Error: " . $sql . "<br>" . $conn2->error;
    //     }
    // }
}

// Close connections
$conn1->close();
$conn2->close();
?> -->
