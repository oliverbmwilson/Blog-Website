 
<?php
    session_start();
?>

<!DOCTYPE html>
<html>

    <head>
    
        <title>The Best Blog In The World</title>
        <link rel="stylesheet" type="text/css" href="index_stylesheet.css" />
        
    </head>
    
    <body>
    
    <?php

                
            if (file_exists('BlogFolder/blog_post.txt')) {
                include "BlogFolder/blog_post.txt";
            }
        

    
            $correctName = "admin";
            $correctPassword = "admin";
            $name = "";
            $password = "";
            $nameErr = "";
            $passwordErr = "";
            
            if(isset($_POST['read_more'])) {
                $_SESSION['blog'] = $_POST['file_location'];
                header('LOCATION:blog_post_index.php');
            }

            if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['login'])) {
                if (empty($_POST["user_name"]) || empty($_POST["user_password"])) {
                    if (empty($_POST["user_name"])) {
                        $nameErr = "Username required";
                    }
                    if (empty($_POST["user_password"])) {
                        $passwordErr = "Password required";
                    }
                } else {
                    $name = trim_input($_POST["user_name"]);
                    $password = trim_input($_POST["user_password"]);
                    
                    if($name != $correctName) {
                        $nameErr = "Incorrect username";
                    }
                    
                    if($password != $correctPassword) {
                        $passwordErr = "Incorrect password";
                    }
                    
                    if(($name == $correctName) && ($password == $correctPassword)) {
                        $_SESSION['valid'] = true;
                        header('LOCATION:index_admin.php'); 
                        die();
                    }
                }
                
                if(($nameErr != "") || ($passwordErr != "")) {
                echo '<style type="text/css">
                    #login_popup {
                        visibility: visible;
                    }
                    </style>';
                }
            }

            function trim_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
    
        <div id="top_bar">
        
            <header id="main_header"> 
                <h1>The Best Blog In The World<h1>
            </header>
            
            <div id="white_space"></div>
            
            <button type="button" onClick="showLogin(true)" id="log_in">Admin login</button>
            
        </div>
        
        <div id="main_wrapper">
        
            <section id="main_section">
            
                <?php
                    foreach (glob("BlogFolder/*.txt") as $filename){
                    
                        include $filename;
                        
                        $author = $blog_name;
                        $title = $blog_title;
                        $date = $blog_date;
                        $content = $blog_content;
                        $fileLocation = $blog_file_name;
                        
                        echo "<article>";
                            echo "<header>";
                                    
                                    echo "<h2 id='title'>".$title."</h2>";
                                    echo "<h3 id='date'>".$date."</h3>";
                            echo "</header>";
                            
                        echo "<p>".$content."</P>";
                        
                            echo "<footer>";
                                echo "<p>- Written by <span id='author'>".$author."</span><p>";
                            echo "</footer>";
                            
                            echo "<form method='post' action=''>";
                                echo "<input class='read_more' type='submit' value='Read more...' name='read_more' />";
                                echo "<input type='hidden' value='".$fileLocation."' name='file_location' />";
                            echo "</form>";
                            
                        echo "</article>";
                        
                        
                    }
                    
                    
                ?>
        
            </section>

        </div>
        
        <div id="login_popup">
             <form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <center>Username:</center>
                <center><input name="user_name" value="<?php echo $name;?>" size=14 /><span class="required_field">*<span></center>
                <center class="error"><?php echo $nameErr;?></center>
                <center>Password:</center>
                <center><input name="user_password" type="password" value="<?php echo $password;?>" size=14 /><span class="required_field">*<span></center>
                <center class="error"><?php echo $passwordErr;?></center>
                <center id="login_buttons">
                    <input name="login" type="submit" value="Login" />
                    <button type="button" onClick="showLogin(false)" id="close">Close</button>
                </center>
            </form>
        </div>
        
        <footer id="main_footer">
            <p>Copyright 2016</P>
        </footer>
        
        <script src="index_script.js"></script>
        
    </body>
    
</html> 