<?php
    require_once '../lib/core.php'; 
   
    if(isset($_POST['deleteImage']))
    {
        $imageId = $conn->real_escape_string($_POST['id']); 
        $imagePath = 'uploads/'.end(explode('/',$conn->real_escape_string($_POST['image'])));
        $sql="update  testimonials set image='' where id = $imageId";
        if($conn->query($sql))
        {
            unlink($imagePath);
            echo "ok";
        } 
        else
        {
            echo $conn->error;
        }
    }
?>