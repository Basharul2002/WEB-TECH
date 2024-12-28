<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrow System</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
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


            if (file_exists("./token.json")) 
            {
                $jsonData = json_decode(file_get_contents("./token.json"), true);

                if (isset($jsonData[0]['token'])) 
                {
                    $inputToken = (int)$_POST['token']; 
                    $tokens = $jsonData[0]['token'];    

                    if (in_array($inputToken, $tokens)) 
                        $flagToken = 1;
                    else 
                        $flagToken = 0;
                } 
                if (isset($jsonData[0]['usedToken']) && $flagToken == 1)
                    $flagUsedToken = 0;

                    if (isset($jsonData[0]['usedToken'])) 
                    {
                        $inputToken = (int)$_POST['token']; 
                        $tokens = $jsonData[0]['usedToken'];    
    
                        if (in_array($inputToken, $tokens)) 
                            $flagUsedToken = 1;
                        else 
                            $flagUsedToken = 0;
                    } 
                    else 
                        $flagUsedToken = -1;
            } 

            if ($date1 == $date2)
            {
                echo "You're not allow to return in same date";
                return;
            }

            if ($date1 > $date2)
            {
                echo "Invalid return date";
                return;
            }

            if ($flagUsedToken != 0)
            {
                echo "You are not allow to use this token because its already used";
                return;
            }

            // 1 day = 86400 seconds
            if (($date2 - $date1) > 10 * 86400 && $flagToken != 1) 
            {
                echo "You're not allowed to loan the book because the return date is more than 10 days. Days: " . (($date2 - $date1) / 86400);
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

            if (file_exists("./token.json") && $flagToken == 1) 
            {
                // Read and decode the JSON file
                $jsonData = json_decode(file_get_contents("./token.json"), true) ?: [];
                
                if (!isset($jsonData[0]['usedToken']) || !is_array($jsonData[0]['usedToken'])) 
                    $jsonData[0]['usedToken'] = [];
                
            
                // Add the token if it doesn't exist
                if (!in_array($token, $jsonData[0]['usedToken'])) 
                    $jsonData[0]['usedToken'][] = $token; // Push the new used token
                
            
                // Save the updated JSON back to the file
                file_put_contents("./token.json", json_encode($jsonData, JSON_PRETTY_PRINT));
            }
            
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
