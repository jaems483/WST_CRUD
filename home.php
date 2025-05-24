<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class List</title>
    
    <link rel="stylesheet" href="home.css">
    <script src="main.js"></script>

    <?php 
        if(isset($_GET['del_admin'])){
            $user = $_GET['user'];
            $dom = new DOMDocument();
            $dom->load('admin.xml');
    
            foreach($dom->getElementsByTagName('admins') as $root){
                foreach($root->getElementsByTagName('admin') as $admin){
                    if($user == $admin->getElementsByTagName('username')->item(0)->nodeValue){
                        $root->removeChild($admin);
                    }
                }
            }
            $saved = $dom->save('admin.xml');
            if ($saved){
                echo '<script>alert("Admin Deleted!")</script>';
                sleep(2);
            }
            header('location: home.php');
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
                }
            }
            $saved = $dom->save('users.xml');
            if ($saved){
                echo '<script>alert("User Updated!")</script>';
            }
        }
    ?>

</head>
<body>

    <div class="logo_holder">
        <img src="cict logo.png" alt="CICT Logo" class="cict_logo">
        <img src="bulsu gear.png" alt="BULSU Logo" class="bulsu_logo">
    </div>

    <div class="options">
        <button class="about_us" onclick="show_aboutus()">About Us</button>
        <button class="admin_show" onclick="show_admin()">Admin List</button>
        <button class="logout" onclick="location.href='./index.php'">Logout</button>
    </div>

    <div class="about_us_frame" id="about_us_frame" style="display: none;">
        <h2>ABOUT US</h2>
        <button id="close" onclick="unshow_aboutus()">X</button>
        <img src="Silpao_JamesKarl_G.jpg" alt="Profile Picture">
        <p><b>NAME</b>: James Karl G. Silpao</p>
        <p><b>COURSE</b>: BSIT 3B-G2</p>
        <p><b>STUDENT</b> ID: 2022-105931</p>
        <p><b>E-MAIL</b>: 2022105931@ms.bulsu.edu.ph</p>
    </div>

    <div class="admin_list" id="admin_list" style="display: none;">
        <h1>ADMIN LIST</h1>
        <button id="close" onclick="unshow_admin()">X</button>
        <table>
            <?php 
                $dom = new DOMDocument();
                $dom->load('admin.xml');
                $str = "<tr><th>USERNAME</th><th>CONFIGURE</th></tr>";
                foreach($dom->getElementsByTagName('admin') as $admin){
                    $user = $admin->getElementsByTagName('username')->item(0)->nodeValue;
                    $pass = $admin->getElementsByTagName('password')->item(0)->nodeValue;
                    $str .= "<tr>";
                        $str .= "<td>" . $user . "</td>";
                        $str .= "<td><a href='./home.php?del_admin=true&user=".$user."'><button class='delete'>DELETE</button></td>";
                    $str .= "</tr>";
                }
                echo $str;
            ?>
        </table>

    </div>

    <h1>3BG2 STUDENT LIST</h1>
        <div class="menu">
            <ul>
                <button class="open_addform" onclick="add_form()">ADD</button>
                <button class="open_delform" onclick="del_form()">DELETE</button>
                <button class="open_editform" onclick="edit_form()">EDIT</button>
            </ul>
        </div>
        <div id="users_list">
        <?php 
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
        ?>
        </div>

    <div class="addform" id="add_myForm" style="display: none;">
        <h1>ADD USER</h1>
        <form action="./home.php">
            <input type="number" name="user_ID" id="ID" placeholder="USER ID" required>
            <input type="text" name="user_Name" id="NAME" placeholder="FULLNAME" required>
            <select name="user_Course" id="COURSE">
                <option value="BSIT">BSIT</option>
                <option value="BSIS">BSIS</option>
                <option value="BSCS">BSCS</option>
            </select>
            <input type="text" value="true" name="add" style="display: none;">
            <button type="submit" onclick="close_add_form">CONFIRM</button>
        </form>
        <a href=""><button id="CANCEL" name="cancel_Button" onclick="close_form()">CANCEL</button></a>
    </div>

    <div class="delform" id="del_myForm" style="display: none;">
        <h1>DELETE USER</h1>
        <form action="./home.php">
            <input type="number" name="user_ID" id="ID" placeholder="USER ID" required>
            <button type="submit" onclick="close_del_form">CONFIRM</button>
            <input type="text" value="true" name="del" style="display: none;">
        </form>
        <a href=""><button id="CANCEL" name="cancel_Button" onclick="close_form()">CANCEL</button></a>

    </div>

    <div class="editform" id="edit_myForm" style="display: none;">
        <h1>EDIT USER</h1>
        <form action="./home.php">
                <input type="number" name="user_ID" id="ID" placeholder="USER ID" required>
                <input type="text" name="user_Name" id="NAME" placeholder="NEW FULLNAME" required>
                <select name="user_Course" id="COURSE">
                    <option value="BSIT">BSIT</option>
                    <option value="BSIS">BSIS</option>
                    <option value="BSCS">BSCS</option>
                </select>
                <button type="submit" onclick="close_edit_form">CONFIRM</button>
                <input type="text" value="true" name="edit" style="display: none;">
        </form>
        <a href=""><button id="CANCEL" name="cancel_Button" onclick="close_form()">CANCEL</button></a>
    </div>
    
</body>
</html>
