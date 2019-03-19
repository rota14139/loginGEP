<!doctype html>
<br>
    <body>
    <link rel="stylesheet" href="fileCSS/aboutPage.css" type="text/css">
    <?php
        session_start();

        if (isset($_SESSION['in_username']) && isset($_SESSION['in_password']))
        {
            $in_username = $_SESSION['in_username'];
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
    </div>
    
    <?php
    
    ?>
    </body>
</html>