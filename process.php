<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrow System</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // Retrieve form data
        $studentName = $_POST['userName'];
        $studentID = $_POST['userID'];
        $bookTitle = $_POST['books'];
        $borrowDate = $_POST['borrowDate'];
        $token = $_POST['token'];
        $returnDate = $_POST['returnDate'];
        $fees = $_POST['fees'];
        $paid = $_POST['paid'];

        // Validation
        if (!preg_match("/[A-Za-z\-]/", $_POST['userName'])) 
        { 
            echo "Invalid Name";
            return;
        }
        
        if (!preg_match("/\d{2}-\d{5}-\d{1}/", $studentID)) 
        {
            echo "Invalid UserID";
            return;
        }

        if (!preg_match("/[0-9]/", $_POST['fees'])) 
        { 
            echo "Invalid Name";
            return;
        }

        $cookieName = $bookTitle; // Cookie name is the book title
        if (isset($_COOKIE[$cookieName])) 
        {
            // Check if the cookie value matches the student name
            if ($_COOKIE[$cookieName] === $studentName) 
            {
                echo "<h3 style='color: red;'>You're not allowed to borrow the same book again.</h3>";
                return;
            }
        }

        // Set the cookie with the book title as the name and student name as the value
        setcookie($cookieName, $studentName, time() + (10 * 24 * 60 * 60), "/"); // Cookie expires in 10 days


        // Display the submitted data
        echo "<h2>Form Submission Details:</h2>";
        echo "Student Full Name: " . $studentName . "<br>";
        echo "Student ID: " . $studentID . "<br>";
        echo "Book Title: " . $bookTitle . "<br>";
        echo "Borrow Date: " . $borrowDate . "<br>";
        echo "Token: " . $token . "<br>";
        echo "Return Date: " . $returnDate . "<br>";
        echo "Fees: $" . $fees . "<br>";
        return;
    } 

        echo "No data submitted.";
    
    ?>
</body>
</html>
