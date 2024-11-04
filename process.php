<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $studentName = $_POST['userName'];
        $studentID = $_POST['userID'];
        $bookTitle = $_POST['books'];
        $borrowDate = $_POST['borrowDate'];
        $token = $_POST['token'];
        $returnDate = $_POST['returnDate'];
        $fees = $_POST['fees'];
        $paid = $_POST['paid']
    
        // Display the submitted data
        echo "<h2>Form Submission Details:</h2>";
        echo "Student Full Name: " . htmlspecialchars($studentName) . "<br>";
        echo "Student ID: " . htmlspecialchars($studentID) . "<br>";
        echo "Book Title: " . htmlspecialchars($bookTitle) . "<br>";
        echo "Borrow Date: " . htmlspecialchars($borrowDate) . "<br>";
        echo "Token: " . htmlspecialchars($token) . "<br>";
        echo "Return Date: " . htmlspecialchars($returnDate) . "<br>";
        echo "Fees: $" . htmlspecialchars($fees) . "<br>";

        return;
    } 
    
    echo "No data submitted.";
    
    
    ?>
</body>
</html>