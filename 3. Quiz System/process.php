<?php
    session_start();

    if (!isset($_SESSION[$_POST['id']]))
        $_SESSION[$_POST['id']] = $_POST['id'];

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $id = $_POST['id'];
        $q1 = $_POST['q1'] ?? null;
        $q2 = $_POST['q2'] ?? null;
        $q3 = $_POST['q3'] ?? null;
        $q4 = $_POST['q4'] ?? null;

        if (isset($_COOKIE[$id]))
        {
            echo "You are not allow to exam again <br> And your score: " . $_COOKIE[$id];
            return;
        }

        $res = 0;
        if ($q1 == "r" && $q1 != null)
            $res += 1;
        if ($q2 == "r" && $q2 != null)
            $res += 1;
        if ($q3 == "r" && $q3 != null)
            $res += 1;
        if ($q4 == "r" && $q4 != null)
            $res += 1;

        setcookie($id, $res, time()+60*10, "/");
        echo "Your score: " . $res;
    }

session_unset();
session_destroy();
?>