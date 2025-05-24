<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
        function loadXML() {
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->load('admin.xml');

            $admin = $dom->createElement("admin");

            $username = $dom->createElement("username", "\nadmin\n");
            $password = $dom->createElement("password", "\npassword\n");

            $admin->appendChild($username);
            $admin->appendChild($password);

            $admins = $dom->getElementsByTagName("admins")->item(0);
            $admins->appendChild($admin);

            $saved = $dom->save("admin.xml");

            if ($saved) {
                echo "<script>alert('XML file updated successfully');</script>";
            }
        }
    ?>

</head>
<body>
    <h1>Load XML File</h1>
    <form method="POST" action="loadfile.php">
        <input type="submit" name="load" value="Load XML File">
    </form>

    <?php
        if (isset($_POST['load'])) {
            loadXML();
        }
    ?>
    
</body>
</html>