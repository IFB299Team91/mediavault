<script>
    function a<?php echo trim($file['file_id']) ?>() {

        var strAudio = "<?php echo $file['filename'] ?>";
        var resAudio = strAudio.match(/(.ogg|.mp3)/g);

        if (strAudio.match(resAudio)) {
            // There was a match.		
            document.getElementById("player").style.display = "block";
            document.getElementById("vidplayer").pause();
            document.getElementById("vidplayerwrap").style.display = "none";
            document.getElementById("player").src = "<?php echo $file['dir'] ?>";
            document.getElementById("player").load();
            document.getElementById("player").play();
        } else {
            // No match.
        }

        var strImage = "<?php echo $file['filename'] ?>";
        var resImage = strImage.match(/(.gif|.jpg|.png)/g);

        if (strImage.match(resImage)) {
            // There was a match.
            document.getElementById("vidplayer").pause();
            document.getElementById("player").pause();
            document.getElementById("player").style.display = "none";
            document.getElementById("vidplayerwrap").style.display = "none";
            document.getElementById("imagebox").style.display = "block";
            document.getElementById("imageholder").src = "<?php echo $file['dir'] ?>";

        } else {
            // No match.
        }

        var strVideo = "<?php echo $file['filename'] ?>";
        var resVideo = strVideo.match(/(.ogv|.mov|.avi|.mkv)/g);

        if (strVideo.match(resVideo)) {
            // There was a match.
            document.getElementById("player").pause();
            document.getElementById("player").style.display = "none";
            document.getElementById("vidplayerwrap").style.display = "block";
            document.getElementById("vidplayer").style.display = "block";
            document.getElementById("vidplayer").src = "<?php echo $file['dir'] ?>";
            document.getElementById("vidplayer").load();
            document.getElementById("vidplayer").play();

        } else {
            // No match.
        }

        var strText = "<?php echo $file['filename'] ?>";
        var resText = strText.match(/(.pdf|.doc|.docx|.txt)/g);

        if (strText.match(resText)) {
            // There was a match.

            window.open("<?php echo $file['dir'] ?>");
            document.getElementById("vidplayer").pause();
            document.getElementById("player").pause();

        } else {
            // No match.
        }

    }

    function c<?php echo trim($file['file_id']) ?>() {
        document.getElementById("ShareLink").value = "localhost/mediavault/<?php echo trim($file['dir']) ?>";
        document.getElementById("ShareButton").href = "<?php echo trim($file['dir']) ?>";
    }

    function d<?php echo trim($file['file_id']) ?>() {
        document.getElementById("EditId").value = "<?php echo $file['file_id'] ?>";
    }
</script>