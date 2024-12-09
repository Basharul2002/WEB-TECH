<?php
session_start();

if (!isset($_SESSION['ac_number']))
    $_SESSION['ac_number'] = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // Retrieve form data
    $acc_no = $_POST['ac_number'] ?? null;
    $action = $_POST['action'] ?? null;
    $amount = $_POST['amount'] ?? null;

    if (!is_numeric($acc_no)) 
    {
        echo "Invalid A/C Number";
        return;
    }

    if (!is_numeric($amount)) 
    {
        echo "Invalid amount";
        return;
    }

    $currentBalance = 0; 

    if (isset($_COOKIE[$acc_no])) 
        $currentBalance = (float)$_COOKIE[$acc_no]; 

    if ($action == "deposit") 
        $currentBalance += $amount; 
    else if ($action == "withdraw") 
    {
        if ($currentBalance - $amount > 1000) 
        { 
            echo "Insufficient balance. Your Balance: " . $currentBalance;
            return;
        }
        $currentBalance -= $amount; 
    } 
    
    else 
    {
        echo "Invalid action.";
        return;
    }

    // Update the cookie with the new balance
    setcookie($acc_no, $currentBalance, time() + 60 * 10, "/");
    echo "Transaction successful. Your Balance: " . $currentBalance;

    // Clear session
    session_unset();
    session_destroy();
}
?>
