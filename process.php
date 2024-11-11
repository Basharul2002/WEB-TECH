<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        
        // Calculate the difference between the borrow date and return date
        $interval = date_diff(new DateTime($borrowDate), new DateTime($returnDate));

        // Check if the interval is greater than 10 days
        if ($interval->format('%a') > 10) 
        {
            echo "Not able to borrow book for more than 10 days.";
            return;
        }

        
        


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