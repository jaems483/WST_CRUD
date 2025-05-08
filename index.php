<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">

    <?php 
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
                header("location: home.php?load=true");
            } else {
                echo "<script>alert('Invalid Username or Pass!');</script>";
            }
        }
    }
    ?>
</head>
<body>
    <div class="login_form">
        <h1>LOGIN</h1>
        <form action="index.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <div class="login_button">
                <input type="submit" value="Login">
            </div>
            
        </form>
    </div>
</body>