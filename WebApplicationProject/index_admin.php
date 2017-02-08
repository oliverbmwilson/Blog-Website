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
        
            if (file_exists('BlogCountFolder/blogCount.txt')) {
                include "BlogCountFolder/blogCount.txt";
            }
        
            $blogCount = $blogCountValue + 1;
            $fileName = "BlogFolder/blog_post_".$blogCount.".txt";
            $commentFile = "CommentsFile/commentsfile_".$blogCount.".txt";
                        
            $nameErr = "";
            $contentErr = "";
            $titleErr = "";
            
            if($_SESSION['valid'] != true) {
                header('LOCATION:index.php'); 
                die();
            }
            
            if(isset($_POST['read_more'])) {
                $_SESSION['blog'] = $_POST['file_location'];
                header('LOCATION:blog_post_admin.php');
            }
            
            if(isset($_POST['logout'])) {
                session_destroy();
                header('LOCATION:index.php'); 
                die();
            }
            
            if(isset($_POST['read_more'])) {
                $_SESSION['blog'] = $_POST['file_location'];
                header('LOCATION:blog_post_admin.php');
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
                    $date = date('jS F Y');
                    
                    $file_contents = '<?php'."\n".'$blog_name="'.$name.'";'."\n".'$blog_comment_file="'.$commentFile.'";'."\n".'$blog_title="'.$title.'";'."\n".'$blog_date="'.$date.'";'."\n".'$blog_content="'.$content.'";'."\n".'$blog_file_name="'.$fileName.'";'."\n".'?>';
                    file_put_contents($fileName, $file_contents, LOCK_EX) or die('fwrite failed');
                    fopen($commentFile, "w") or die("Unable to open file!");
                    
                    $blogCount_contents = '<?php'."\n".'$blogCountValue="'.$blogCount.'";'."\n".'?>';
                    file_put_contents("BlogCountFolder/blogCount.txt", $blogCount_contents, LOCK_EX) or die('fwrite failed');
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
            
            <button type="button" onClick="showEditPost(true)" id="edit_post_button">New Post</button>
            
            <form id="logout" name="logout" method="post" action="">
                <input id="logout_button" type="submit" value="Logout" name="logout" />
            </form>
            
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
                        $commentFile = $blog_comment_file;
                        
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
        
        <div id="edit_post_popup">
            <div id="edit_post_ui">
                <h3>New post</h3>
                
                <form name="edit_post" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                    
                    <div id="author_field">
                        <label for="author_name" class="block">Author<span class="required_field">*<span> </label>
                        <input name="author_name" size=14 class="block" />
                        <span class="error block"><?php echo $nameErr;?></span>
                    </div>
                    
                    <div id="title_field">
                        <label for="blog_title" class="block">Title<span class="required_field">*<span> </label>
                        <input name="blog_title" size=14 class="block" />
                        <span class="error block"><?php echo $titleErr;?></span>
                    </div>
                    
                    <div id="blog_post_field">
                        <label for="blog_post" class="block">Blog<span class="required_field">*<span> </label>
                        <textarea name="blog_post" id="blog_post" size=14 class="block"></textarea>
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
