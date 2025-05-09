<?php

use Dom\Document;

    session_start();
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $SESSION['username'] = $_POST['username'];
        $SESSION['password'] = $_POST['password'];

        $dom = new DOMDocument();
        $dom->load('admin.xml');

        foreach ($admin = $dom->getElementsByTagName("admin") as $data) {
            $adminUsername = $data->getElementsByTagName('username')->item(0)->nodeValue;
            $adminPassword = $data->getElementsByTagName('password')->item(0)->nodeValue;

            if ($SESSION['username'] == $adminUsername && $SESSION['password'] == $adminPassword) {
                header("location: home.html?load=true");
            } else {
                header("location: index.php?error=Invalid username or password");
            }
        }
    }

    //convert display to foreach, add restriction to duplicates when adding data

    if(isset($_GET['load'])){
        $str = "<table><tr><th>ID</th><th>NAME</th><th>COURSE</th></tr>";
        
        $dom = new DOMDocument();
        $dom->load("users.xml");

        foreach($dom->getElementsByTagName("student") as $data){
            $str .= "<tr>";
                $str .= "<td>" . $data->getElementsByTagName("ID")->item(0)->nodeValue . "</td>";
                $str .= "<td>" . $data->getElementsByTagName("NAME")->item(0)->nodeValue . "</td>";
                $str .= "<td>" . $data->getElementsByTagName("COURSE")->item(0)->nodeValue . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";

        echo $str;
        exit;
    }

    if(isset($_GET['add'])){
        $id = $_GET['user_ID'];
        $name = $_GET['user_Name'];
        $course = $_GET['user_Course'];

        $dom = new DOMDocument();
        $dom->load('users.xml');

        $student = $dom->createElement('student');
        $uid = $dom->createElement('ID', $id);
        $uname = $dom->createElement('NAME', $name);
        $ucourse = $dom->createElement('COURSE', $course);

        $student->appendChild($uid);
        $student->appendChild($uname);
        $student->appendChild($ucourse);

        $root = $dom->getElementsByTagName('students')->item(index:0);
        $root->appendChild($student);

        $saved = $dom->save('users.xml');
        if ($saved){
            echo ("<script>alert('New User Added!')</script>");
        }
        header('location: home.php');
    }

    if (isset($_GET['edit']) || isset($_GET['del'])){
        $id = $_GET['user_ID'];
        if(isset($_GET['edit'])){
            $name = $_GET['user_Name'];
            $course = $_GET['user_Course'];
        }

        $dom = new DOMDocument();
        $dom->load(filename: 'users.xml');

        foreach($dom->getElementsByTagName('students') as $root){
            foreach($root->getElementsByTagName('student') as $student){
                if(isset($_GET['edit']) && $id == $student->getElementsByTagName('ID')->item(index:0)->nodeValue){
                    $new_Name = $dom->createElement('NAME', $name);
                    $new_Course = $dom->createElement('COURSE', $course);
                    $student->replaceChild($new_Name, $student->getElementsByTagName('NAME')->item(0));
                    $student->replaceChild($new_Course, $student->getElementsByTagName('COURSE')->item(0));
                }
                else if(isset($_GET['del']) && $id == $student->getElementsByTagName('ID')->item(index:0)->nodeValue){
                    $root->removeChild($student);
                }
                echo '<br>';
                echo $student->getElementsByTagName('ID')->item(index:0)->nodeValue;
                echo $student->getElementsByTagName('NAME')->item(index:0)->nodeValue;
                echo $student->getElementsByTagName('COURSE')->item(index:0)->nodeValue;
            }
        }
        $saved = $dom->save('users.xml');
        if ($saved){
            echo '<script>alert("User Updated!")</script>';
        }
        header('location: home.php');
    }
?>
