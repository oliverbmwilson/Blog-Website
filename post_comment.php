<html>
<body>

<?php 

    if (isset($_POST['submit']))
    {
        $username = "<name style='font-size: 20px;color: FireBrick;'>".$_POST["comment_author"]."</name><br>\n";
        $date = "<date style='font-size: 10px;color: FireBrick'>"."  ".date('jS F Y')."</date><br>\n";
        $commentsfilename = $_POST["comment_file_name"];
        $time = "<time style='font-size: 10px;color: FireBrick'>"."  ".date('h:i:s A')."</time><br>\n";
        $usercomment = "<comment style='font-size: 15px; font-style: italic;'>".$_POST["comment"]."</comment>";
        
        $commentsfilecontent = "\n<table style='background: white; width: 100%; border-spacing: 20px; border-collapse: separate;text-align: justify; text-justify: inter-word;'> 
        <tr> 
        <td style='width:20%;'> \n". $username. $date. $time. "
        </td> \n 
        <td >".$usercomment. 
        "</td> 
        </tr>
        </table>\n<br>\n\n";
        file_put_contents($commentsfilename, $commentsfilecontent, FILE_APPEND | LOCK_EX);        
        header("Location:blog_post_index.php");
    }
    
  ?>  

</body>
</html>