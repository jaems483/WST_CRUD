<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
    <script src="main.js"></script>

    <?php

        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $dom = new DOMDocument();
            $dom->load('admin.xml');
            foreach($dom->getElementsByTagName('admin') as $admin){
                $user = $admin->getElementsByTagName('username')->item(0)->nodeValue;
                $pass = $admin->getElementsByTagName('password')->item(0)->nodeValue;

                if($user == $username && $pass == $password){
                    header('location: home.php');
                    exit();
                }
            }
            echo "<script>alert('Invalid Username or Password!')</script>";
        }

        if(isset($_GET['add_user']) && isset($_GET['add_pass'])){
            $n_user = $_GET['add_user'];
            $n_pass = $_GET['add_pass'];
            $duplicate = false;

            $dom = new DOMDocument();
            $dom->load('admin.xml');
            $root = $dom->getElementsByTagName('admins')->item(0);

            foreach($root->getElementsByTagName('admin') as $admin){
                $user = $admin->getElementsByTagName('username')->item(0)->nodeValue;
                if($user == $n_user){
                    $duplicate = true;
                    break;
                }
            }

            if($duplicate){
                echo ("<script>alert('Username already exists!')</script>");
                sleep(2);
            }
            else {
                $admin = $dom->createElement('admin');
                $username = $dom->createElement('username', $n_user);
                $password = $dom->createElement('password', $n_pass);
                $admin->appendChild($username);
                $admin->appendChild($password);
                $root->appendChild($admin);

                $saved = $dom->save('admin.xml');
                if ($saved){
                    echo ("<script>alert('New Admin Added!')</script>");
                    sleep(2);
                }
            }
            
            header('location: index.php');

        }

    ?>
</head>
<body>
    <div class="title_frame">
        <h1 id="title">3BG2</h1>
    </div>
    <div class="title_frame1">
        <h1 id="title1">BUSINESS ANALYTICS</h1>
    </div>
    <div class="title_frame2">
        <h1 id="title2">CLASS LIST</h1>
    </div>

    <div class="logo_holder">
        <img src="cict logo.png" alt="CICT Logo" class="cict_logo">
        <img src="bulsu gear.png" alt="BULSU Logo" class="bulsu_logo">
    </div>

    
    <div id="login_form" class="login_form">
        <h1>LOGIN</h1>
        <form method="POST">
            <input type="text" id="username" name="username" placeholder="USERNAME" style="text-align: center;"><br>
            <input type="password" id="password" name="password" placeholder="PASSWORD" style="text-align: center;">
            <br><br>
            <div class="login_button">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>

    <button id="s_form" onclick="show_form()">New Admin</button>

    <div class="add_admin" style="display: none;">
        <h1>ADD ADMIN</h1>
        <form>
            <div>
                <input type="text" id="add_user" name="add_user" placeholder="USERNAME" style="text-align: center;"><br>
                <input type="password" id="add_pass" name="add_pass" placeholder="PASSWORD" style="text-align: center;">
            </div>
            <br><br>
            <input id="add" type="submit" value="SUBMIT">
        </form>
            <div>
                <button id="cancel" onclick="close_admin()">CANCEL</button>
            </div>
    </div>
</body>