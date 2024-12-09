<?php

       $students = json_decode(file_get_contents("info.json")); // fetching the json file
        function check($input) {
                if ($input==1)
                    return "true";
                return "false";
                
        }
        
        foreach ($students as $student) {
                echo "<li> Name: " . $student->name . "<br>Age: " . $student->age . "<br>Status: " . $student->status . "<br> Hobbies: " . implode(", ", $student->hobbies) . "</li>";
                // Loop through the grades
                echo "Grades:<br>";
                foreach ($student->grade as $subject => $grade) 
                        echo ucfirst($subject) . " Grade: " . $grade . "<br>";
                
                echo "</li><br>";
                echo "<li>";
                echo $student->name . " -> ";
                echo $student->grade->biology . " -> ";
                echo check($student->status) . "<br>";
                echo "</li>";

                
        }
        echo "Name: ". $students[1]->name."<br>";
        echo "2nd Hobbie: ".$students[1]->hobbies[2]."<br>";
        echo  "Chemistry Grade: ".$students[1]->grade->chemistry."br>";

        // echo "<br>";
        echo "check(1): ".check(1)."<br>";

        $a = 1;
        $b = true;
        $c = false;

        echo "Input: a = 1 Output: " .is_bool($a)."<br>";
        echo "Input: b = true Output: " .is_bool($b)."<br>";
        echo "Input: c = false Output: ". is_bool($c);
        echo "Input: a = 1 Output: " .is_numeric($a)."<br>";


?>