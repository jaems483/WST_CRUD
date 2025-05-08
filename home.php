<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class List</title>
    
    <link rel="stylesheet" href="home.css">

    <script>
        function add_form() {
            document.getElementById("add_myForm").style.display = "flex";
            document.getElementById("add_myForm").style.flexDirection = "column";
        }
        function del_form() {
            document.getElementById("del_myForm").style.display = "flex";
            document.getElementById("del_myForm").style.flexDirection = "column";
        }
        function edit_form() {
            document.getElementById("edit_myForm").style.display = "flex";
            document.getElementById("edit_myForm").style.flexDirection = "column";
        }

        function close_add_form() {
            document.getElementById("add_myForm").style.display = "none";
        }

    </script>

    <?php //convert display to foreach, add restriction to duplicates when adding data

        function display_users(){
            echo "<div class='user_list'><table><tr><th>ID</th><th>NAME</th><th>COURSE</th></tr>";
            
            $dom = new DOMDocument();
            $dom->load("users.xml");

            foreach($dom->getElementsByTagName("student") as $data){
                echo "<tr>";
                    echo "<td>" . $data->getElementsByTagName("ID")->item(0)->nodeValue . "</td>";
                    echo "<td>" . $data->getElementsByTagName("NAME")->item(0)->nodeValue . "</td>";
                    echo "<td>" . $data->getElementsByTagName("COURSE")->item(0)->nodeValue . "</td>";
                echo "</tr>";
            }
            echo "</table></div>";
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

</head>
<body>
    <h1>3BG2 STUDENT LIST</h1>
        <?php
            echo "<div class='menu'>
                    <ul>
                        <button class='open_addform' onclick='add_form()'>ADD</button>
                        <button class='open_delform' onclick='del_form()'>DELETE</button>
                        <button class='open_editform' onclick='edit_form()'>EDIT</button>
                    </ul>
                </div>";
            display_users();
        ?>
        

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
        <a href=""><button id="CANCEL" name="cancel_Button" onclick="close_add_form()">CANCEL</button></a>
    </div>

    <div class="delform" id="del_myForm" style="display: none;">
        <h1>DELETE USER</h1>
        <form action="./home.php">
            <input type="number" name="user_ID" id="ID" placeholder="USER ID" required>
            <button type="submit" onclick="close_del_form">CONFIRM</button>
            <input type="text" value="true" name="del" style="display: none;">
        </form>
        <a href=""><button id="CANCEL" name="cancel_Button" onclick="close_del_form()">CANCEL</button></a>

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
        <a href=""><button id="CANCEL" name="cancel_Button" onclick="close_edit_form()">CANCEL</button></a>
    </div>

    
</body>
</html>