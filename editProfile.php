<!doctype html>
<br>
    <body>
    <link rel="stylesheet" href="fileCSS/editProfile.css" type="text/css">

    <script type="text/javascript">
        function inserisciDati()
        {
            var inputElement = document.getElementsByClassName("textInputInsertClassPwd");
            var controllo = true;
            for (var i = 0; i < inputElement.length; i++)
            {
                if(inputElement[i].value == "")
                {
                    controllo = false;
                }
            }
            if(!controllo)
            {
                alert("INSERISCI LA PASSWORD CORRENTE");
            }
            else
            {
                document.getElementById("formInsert").submit();
            }
        }
        function mostraPassword()
        {
            var pwd = document.getElementById("pwdId");
            if (pwd.type === "password")
            {
                pwd.type = "text";
                document.getElementById("pwdButtonId").src ="img_system\\hidePasswordIcon.png";
            }
            else
            {
                pwd.type = "password";
                document.getElementById("pwdButtonId").src ="img_system\\showPasswordIcon.png";

            }
        }
        function mostraDati()
        {
            document.getElementById("formMostraDati").submit();
        }
        function aprireDiscoC()//per aprire disco C:\\
        {
            document.getElementById("uploadImgId").click();
        }
        public function delete()
        {
            if(file_exists('file_path')){
                @unlink('file_path');
            }
            parent::delete();
        }
    </script>

    <?php
        session_start();
        $typeAllowed = array('jpg','jpeg','png');
        $cartellaCorrente = getcwd();
        if (isset($_SESSION['in_username']) && isset($_SESSION['in_password']))
        {
            include 'connectToServer.php'; 
            $usernameSearch = $_SESSION['in_username'];
            if(isset($_POST['in_password']))
            {
                $in_password = $_POST['in_password'];

                $controllo = $connectionToServerDB->query("select * from users where username = '$usernameSearch' and password = md5('$in_password')");
                if($controllo->num_rows > 0)
                {
                    if(isset($_POST['in_username']) && $_POST['in_username'] != "")
                    {
                        $in_username = $_POST['in_username'];
                        rename($cartellaCorrente."\img_profile\\".$usernameSearch.".jpg", $cartellaCorrente."\img_profile\\".$in_username.".jpg");
                    }
                    else
                    {
                        $in_username = $_SESSION['in_username'];
                    }
                    if(isset($_POST['in_date']) && $_POST['in_date'] != "" )
                    {
                        $in_date = $_POST['in_date'];
                    }
                    else
                    {
                        $in_date = $_SESSION['in_date'];
                    }

                    $in_date = str_replace("/", "-", $in_date);
                    $in_username = strtolower($in_username);

                    $controllo = $connectionToServerDB->query("update users set username='$in_username',date='$in_date' where username='$usernameSearch';");
                    if($controllo === true)
                    {
                        $_SESSION['in_username'] = $in_username;
                        $_SESSION['in_password'] = $in_password;
                        $_SESSION['in_date'] = $in_date;
                        header("Location: homePage.php");
                    }
                    else
                    {
                        echo '<script language="javascript">alert("LO USERNAME CHE STAI UTILIZZANDO E\' GIA\' UTILIZZATO");</script>';
                    }
                }
                else
                {
                    echo '<script language="javascript">alert("PASSWORD ERRATA");</script>';
                }
            }
        }
        else
        {
            header("Location: login.php");
        }
    ?>

    <div id="divTop">
        <input type="button" id="buttonHomeId" class="buttonHomePlayAbout" onclick="location.href='homePage.php';" value="Home">
        <input type="button" id="buttonPlayId" class="buttonHomePlayAbout" onclick="location.href='playPage.php';" value="Play">
        <input type="button" id="buttonAboutId" class="buttonHomePlayAbout" onclick="location.href='aboutPage.php';" value="About">
        <input type="button" id="buttonEditId" class="buttonEditLogout" onclick="location.href='editProfile.php';" value="Edit">
        <input type="button" id="buttonLogoutId" class="buttonEditLogout" onclick="location.href='logout.php';" value="Logut">
    </div>
    
    <div id="divTopButton"></div>
    
    <div id="divMainPage">
        <h1 style="text-align:center">MODIFICA IL TUO PROFILO</h1>
        
        <form id="formInsert" method="POST"><br>
            <div id="divUserPassword">
                    <div>
                        <h2>username</h2>
                        <input type="text" id="usrId" class="textInputInsertClass" maxlenght="30" name="in_username" placeholder="&#128100 username ...">
                    </div>
                    <div>
                        <h2>password corrente *</h2>
                        <input type="password" id="pwdId" class="textInputInsertClassPwd" name="in_password" placeholder="&#128274 password ...">    <img src="img_system\showPasswordIcon.png" id="pwdButtonId" onclick="mostraPassword()">
                    </div>
                    <div>
                        <h2>data di nascita</h2>
                        <input type="date" id="dateId" class="textInputInsertClass" min="1000-01-01" max="9999-12-31" name="in_date">
                    </div>
            </div>
            <div id="divButtonConferma">
                <input type="button" id="buttonConferma" onclick="inserisciDati()" value="conferma modifiche">
            </div>
        </form>

        <form id="formImg" method="POST" enctype="multipart/form-data">
            <div id="divImg">
                <h2>Immagine di profilo attuale</h2>
                
                <?php
                    $nomeImmagine = "img_profile/".$usernameSearch;
                    $percorsoImmagine;
                    $controllo = false;
                    for( $i = 0 ; $i < count($typeAllowed) && !$controllo; $i++ )
                    {
                        $percorsoImmagine = $nomeImmagine.".".$typeAllowed[$i];
                        if(file_exists($percorsoImmagine))
                        {
                            $controllo = true;
                        }
                    }
                    if($controllo)
                    {
                        echo '<img src="'.$percorsoImmagine.'"><br>';
                    }
                    else
                    {
                        echo '<img src="img_system/defaultProfile.png"><br>';
                    }
                ?>

                <div>
                    <h2>scegli la tua nuova immagine di profilo</h2>

                    <?php
                        if(isset($_FILES['uploadImg']) && is_uploaded_file($_FILES['uploadImg']['tmp_name'])) 
                        {
                            $tipoFile = explode('.', $_FILES['uploadImg']['name']);
                            if(in_array(strtolower(end($tipoFile)),$typeAllowed))
                            {
                                $controllo = false;
                                for( $i = 0 ; $i < count($typeAllowed) && !$controllo; $i++ )
                                {
                                    $nomeImmagine = "img_profile/".$usernameSearch;
                                    $percorsoImmagine = $nomeImmagine.".".$typeAllowed[$i];
                                    if(file_exists($percorsoImmagine))
                                    {
                                        unlink($percorsoImmagine);
                                        $controllo = true;
                                    }
                                }
                                $dest = $cartellaCorrente."\img_profile\\".$usernameSearch.".".strtolower(end($tipoFile));
                                move_uploaded_file ($_FILES['uploadImg']['tmp_name'],$dest);
                            }
                            else
                            {
                                echo '<script language="javascript">alert("IL FORMATO DELL\'IMMAGINE DEVE ESSERE \".jpg\" ");</script>';
                            }
                        }
                    ?>

                    <input type="file" id="uploadImgId" name='uploadImg'>
                    <input type="button" id="buttonApriEsploraRisorse" value="&#128193" onclick="aprireDiscoC()">
                    <input type="submit" id="buttonConfirmImg" value="&#10003">
                    <input type="submit" id="buttonDeleteImg" onclick="<?php unlink($percorsoImmagine)?>" value="&#10003">
                </div>
            </div>
        </form>
    </div>

    </body>
</html>