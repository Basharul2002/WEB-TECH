<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrow System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007BFF;
        }
        .details {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .details p {
            margin: 8px 0;
            font-size: 16px;
        }
        .message {
            text-align: center;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            border-radius: 5px;
        }
        .message.success {
            background-color: #28a745;
        }
        .message.error {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
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

            $date1 = strtotime($borrowDate); 
            $date2 = strtotime($returnDate);

            if ($date1 == $date2)
            {
                echo "You're not allow to return in same date";
                return;
            }

            if ($date1 > $date2)
            {
                echo "You're not allow to return in same date";
                return;
            }


            // Validation
            // User name
            if (!preg_match("/[A-Za-z\-]/", $_POST['userName'])) 
            {
                echo "<div class='message error'>Invalid Name</div>";
                return;
            }
            // Student Name
            if (!preg_match("/\d{2}-\d{5}-\d{1}/", $studentID)) 
            {
                echo "<div class='message error'>Invalid UserID</div>";
                return;
            }
            // Fee
            if (!preg_match("/[0-9]/", $_POST['fees'])) 
            {
                echo "<div class='message error'>Invalid Fees</div>";
                return;
            }

            if ($bookTitle == "book0")
            {
                echo "Select a book please";
                return;
            }

            $cookieName = str_replace(['=', ',', ';', ' ', "\t", "\r", "\n", "\013", "\014"], '_', $bookTitle); // Cookie name is the book title

            if (isset($_COOKIE[$cookieName])) 
            {
                // Check if the cookie value matches the student name
                if ($_COOKIE[$cookieName] == $studentName) 
                {
                    echo "<div class='message error'>You're not allowed to loadn the same book again.</div>";
                    return;
                }
            }

            // Set cookie {Name: book title & value: student name
            setcookie($cookieName, $studentName, time() + (10 * 24 * 60 * 60), "/"); // Cookie expires in 10 days

            echo "<div class='message success'>You're allowed to loan this book.</div>";

            // Display the submitted data
            echo "<div class='details'>";
            echo "<h2>Form Submission Details:</h2>";
            echo "<p><strong>Student Full Name:</strong> " . $studentName . "</p>";
            echo "<p><strong>Student ID:</strong> " . $studentID . "</p>";
            echo "<p><strong>Book Title:</strong> " . $bookTitle . "</p>";
            echo "<p><strong>Borrow Date:</strong> " . $borrowDate . "</p>";
            echo "<p><strong>Token:</strong> " . $token . "</p>";
            echo "<p><strong>Return Date:</strong> " . $returnDate . "</p>";
            echo "<p><strong>Fees:</strong> $" . $fees . "</p>";
            echo "</div>";
            return;
        } 

        echo "<div class='message error'>No data submitted.</div>";
        ?>
    </div>
</body>
</html>
