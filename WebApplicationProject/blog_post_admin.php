<?php
    session_start();
?>

<!DOCTYPE html>
<html>

    <head>
        
        <title>The Best Blog In The World</title>
        <link rel="stylesheet" type="text/css" href="index_admin_stylesheet.css" />
        
    </head>
    
    <body>
    
        <?php
        
            if (file_exists($_SESSION['blog'])) {
                include $_SESSION['blog'];
            }
        
            $name = $blog_name;
            $title = $blog_title;
            $date = $blog_date;
            $content = $blog_content;
            $fileName = $blog_file_name;
            $commentfileName = $blog_comment_file;
                        
            $nameErr = "";
            $contentErr = "";
            $titleErr = "";
            
            if($_SESSION['valid'] != true) {
                header('LOCATION:index.php'); 
                die();
            }
            
            if(isset($_POST['logout'])) {
                session_destroy();
                header('LOCATION:index.php'); 
                die();
            }

            if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['commit_post'])) {
                if (empty($_POST["author_name"]) || empty($_POST["blog_post"]) || empty($_POST["blog_title"])) {
                    if (empty($_POST["author_name"])) {
                        $nameErr = "Author name required";
                    }
                    if (empty($_POST["blog_post"])) {
                        $contentErr = "Content required";
                    }
                    if (empty($_POST["blog_title"])) {
                        $titleErr = "Title required";
                    }
                    
                } else {
                    $name = $_POST["author_name"];
                    $content = $_POST["blog_post"];
                    $title = $_POST["blog_title"];
                    
                    $file_contents = '<?php'."\n".'$blog_name="'.$name.'";'."\n".'$blog_comment_file="'.$commentFile.'";'."\n".'$blog_title="'.$title.'";'."\n".'$blog_date="'.$date.'";'."\n".'$blog_content="'.$content.'";'."\n".'$blog_file_name="'.$fileName.'";'."\n".'?>';
                    file_put_contents($fileName, $file_contents, LOCK_EX) or die('fwrite failed');
                }
                
                if(($nameErr != "") || ($contentErr != "") || ($titleErr != "")) {
                echo '<style type="text/css">
                    #edit_post_popup {
                        visibility: visible;
                    }
                    </style>';
                }
            }
        ?>
    
        <div id="top_bar">
        
            <header id="main_header"> 
                <h1>The Best Blog In The World<h1>
            </header>
            
            <a href="index_admin.php"><button type='button' id='back'>Back</button></a>";
            
            <button type="button" onClick="showEditPost(true)" id="edit_post_button">Edit Post</button>
            
            <form id="logout" name="logout" method="post" action="">
                <input id="logout_button" type="submit" value="Logout" name="logout" />
            </form>
            
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
                        <p>- Written by <span id="author"><?php echo $name; ?></span><p>
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
        
        <div id="edit_post_popup">
            <div id="edit_post_ui">
                <h3>Edit post</h3>
                
                <form name="edit_post" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                    
                    <div id="author_field">
                        <label for="author_name" class="block">Author<span class="required_field">*<span> </label>
                        <input name="author_name" value="<?php $name; ?>" size=14 class="block" />
                        <span class="error block"><?php echo $nameErr;?></span>
                    </div>
                    
                    <div id="title_field">
                        <label for="blog_title" class="block">Title<span class="required_field">*<span> </label>
                        <input name="blog_title" value="<?php echo $title; ?>" size=14 class="block" />
                        <span class="error block"><?php echo $titleErr;?></span>
                    </div>
                    
                    <div id="blog_post_field">
                        <label for="blog_post" class="block">Blog<span class="required_field">*<span> </label>
                        <textarea name="blog_post" id="blog_post" size=14 class="block"><?php echo $content; ?></textarea>
                        <span class="error block"><?php echo $contentErr;?></span>
                    </div>
                    
                    <div id="edit_post_buttons">
                        <input name="commit_post" type="submit" value="Post" />
                        <button type="button" onClick="showEditPost(false)" id="close">Cancel</button>
                    </div>
                    
                </form>
            </div>
        </div>
        
        <footer id="main_footer">
            <p>Copyright 2016</P>
        </footer>
        
        <script src="index_admin_script.js"></script>
        
    </body>
    
</html> 
