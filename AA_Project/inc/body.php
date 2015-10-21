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

        function ShowShare() {
            document.getElementById("ShareDialog").style.display = "block";
        }

        function CloseShare() {
            document.getElementById("ShareDialog").style.display = "none";
        }

        function ShowEdit() {
            document.getElementById("EditDialog").style.display = "block";
        }

        function CloseEdit() {
            document.getElementById("EditDialog").style.display = "none";
        }

        function UploadFile() {
            document.getElementById("upload_div").style.display = "block";
        }

        function CloseUpload() {
            document.getElementById("upload_div").style.display = "none";
        }

        function CloseImage() {
            document.getElementById("imagebox").style.display = "none";
        }

        function CloseVideo() {
            document.getElementById("vidplayerwrap").style.display = "none";
            document.getElementById("vidplayer").pause();
        }
    </script>
</head>

<body>
    <header>
        <div class="logo">
            <h1><img alt="Media Vault" height="37" src="img/logo.png">Media Vault</h1>
        </div>

        <div class="user right">
            <p>
                <?php echo $current_user; ?>
            </p>

            <nav>
                <ul>
                    <li>
                        <img class="identity" alt="My Profile" height="40" onclick="ShowMenu();" src="img/menu.png">
                    </li>
                    <li>
                        <ul id="ProfileMenu" onmouseleave="HideMenu();">
                            <li>
                                <a href="#"><img height="18" src="img/person.png">Personal</a>
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
                <li class="search">
                    <form name="search_form" action="search.php" method="post">
                        <input name="search" placeholder="Search..." type="text">
                    </form>


                </li>

                <li onclick="UploadFile()">
                    <a href="#"><img src="img/upload.png" height="19">Upload</a>
                </li>

                <li>
                    <a href="home.php"><img src="img/folder.png" height="19">All Files</a>
                </li>

                <li>
                    <a href="text.php"><img src="img/doclib.png" width="19">Documents</a>
                </li>

                <li>
                    <a href="audio.php"><img src="img/audiolib.png" width="19">Music</a>
                </li>

                <li>
                    <a href="image.php"><img src="img/photolib.png" width="19">Photos</a>
                </li>

                <li>
                    <a href="video.php"><img src="img/videolib.png" width="19">Videos</a>
                </li>

            </ul>
        </div>
    </aside>

    <section class="content">
        <div id="vidplayerwrap">
            <video onclick="CloseVideo()" id="vidplayer" controls>
                <source src=""> Your browser does not support the video tag.
            </video>
        </div>

        <div id="imagebox">
            <img onclick="CloseImage()" id="imageholder" src="">
        </div>
        <audio id="player" controls>
            <source src=""> Your browser does not support the video tag.
        </audio>
        <div id="upload_div">
            <form method="post" enctype="multipart/form-data" action="file_upload.php">
                <p>Upload a file</p>
                <input type="file" name="datafile" id="datafile" size="40">
                <br>
                <br>
                <input type="submit" value="Submit">
                <input type="button" value="Close" onclick="CloseUpload()">
            </form>
        </div>
        <div id="ShareDialog">
            <p>Copy Link</p>
            <input type="text" name="ShareLink" id="ShareLink" size="48">
            <br>
            <br>
            <a id="ShareButton">
                <input type="button" value="Open URL" onclick="CloseShare()">
            </a>
            <input type="button" value="Close" onclick="CloseShare()">
            </form>
        </div>
        <div id="EditDialog">
            <form method="post" enctype="multipart/form-data" action="update_file.php">
                <p>Rename File</p>
                <input type="text" name="file_id" id="EditId" size="5" readonly>
                <input type="text" name="filename" id="EditBox" size="48">
                <br>
                <br>
                <a id="RenameButton">
                    <input type="submit" value="Rename">
                </a>
                <input type="button" value="Close" onclick="CloseEdit()">
            </form>
        </div>