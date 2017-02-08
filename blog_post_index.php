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

                
            if (file_exists($_SESSION['blog'])) {
                include $_SESSION['blog'];
            }
        
            $author = $blog_name;
            $title = $blog_title;
            $date = $blog_date;
            $content = $blog_content;
            $fileName = $blog_file_name;
            $commentfileName = $blog_comment_file;
            
    
            $correctName = "admin";
            $correctPassword = "admin";
            $name = "";
            $password = "";
            $nameErr = "";
            $passwordErr = "";

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
            
            <a href="index.php"><button type='button' id='back'>Back</button></a>";
            
            <button type="button" onClick="showLogin(true)" id="log_in">Admin login</button>
            
        </div>
        
        <div id="main_wrapper">
        
            <section id="main_section">
            
                <article>
                    <header>
                            
                            <h2 id="title"><?php echo $title; ?></h2>
                            <h3 id="date"><?php echo $date; ?></h3>
                    </header>
                    
                   <p><?php echo $content; ?></P>
                   
                    <footer>
                        <p>- Written by <span id="author"><?php echo $author; ?></span><p>
                    </footer>
                </article>
                
            </section>
            
            <section id="comments">
                
                <h3> Comments </h3> <br>           
                
                <?php
                    if (trim(file_get_contents($commentfileName)) == false) {
                        echo "Be the first one to comment";
                    } else {
                        include $commentfileName; 
                    }    
                ?>
                
                
                <div id="respond">

                    <h3>Leave a Comment</h3>

                    <form action="post_comment.php" method="post" id="commentform">

                        <label for="comment_author" class="required">Your name </label>
                        <input type="text" name="comment_author" id="comment_author" value="" tabindex="1" required="required">

                        <label for="email" class="required">Your email </label>
                        <input type="email" name="email" id="email" value="" tabindex="2" required="required">

                        <label for="comment" class="required">Your messages </label>
                        <textarea name="comment" id="comment" rows="10" tabindex="4"  required="required"></textarea>
                        
                        <input type="hidden" name="comment_file_name" value="<?php echo $commentfileName ?>">
                    
                        <input name="submit" type="submit" value="Submit comment" />
                        
                        <br> <br>* required

                    </form>

                </div>
                
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
