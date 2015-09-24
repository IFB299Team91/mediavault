<!DOCTYPE html>
<html>
<head>
    <meta content="initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">

    <title>Media Vault</title>

    <script>
        function ShowMenu() {
            document.getElementById("ProfileMenu").style.display = "block";
        }

        function HideMenu() {
            document.getElementById("ProfileMenu").style.display = "none";
        }

        function UploadFile() {
        	document.getElementById("upload_div").style.display = "block";
        }
        function CloseUpload() {
        	document.getElementById("upload_div").style.display = "none";
        }
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <h1><img alt="Media Vault" height="37" src="img/logo.png">Media Vault</h1>
        </div>

        <div class="user right">
            <p><?php echo $current_user; ?></p>

            <nav>
                <ul>
                    <li>
                        <img class="identity" alt="My Profile" height="40" onclick="ShowMenu();" src="img/menu.png">
                    </li>
                    <li>
                        <ul id="ProfileMenu" onmouseleave="HideMenu();">
                            <li>
                                <a href="account.php"><img height="18" src="img/person.png">Personal</a>
                            </li>

                            <li>
                                <a href="#"><img height="18" src="img/admin.png">Admin</a>
                            </li>

                            <li>
                                <a href="#"><img height="18" src="img/help.png">Help</a>
                            </li>

                            <li>
                                <a href="logout.php"><img height="18" src="img/logout.png">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <aside>
        <div class="options">
            <ul>
                <li class="search"><input name="search" placeholder="Search..." type="text"></li>

                <li><a href="home.php"><img src="img/folder.png" height="19">All Files</a></li>

                <li onclick="UploadFile()"><a href="#"><img src="img/upload.png" height="19">Upload</a></li>
            </ul>
        </div>
    </aside>

    <section class="content">
        <audio id="videoplayer" controls>
            <source src="">
        Your browser does not support the video tag.
        </audio>
    <div id="upload_div">
        <form method="post" enctype="multipart/form-data" action="file_upload.php">
            <p>Upload a file</p>
            <input type="file" name="datafile" id="datafile" size="40">

            <button type="submit">SUBMIT</button>
            <button onclick="CloseUpload()">CLOSE</button>
        </form>
    </div>