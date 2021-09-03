<?php
    require_once 'lib/core.php';

    if (isset($_POST['delete_bookmarkTask'])){
        $id = $_POST['id'];
        
        $sql = "delete from bookmarks where id=$id";
        if ($conn->query($sql))
        {
            $qna['msg']='successfully deleted';
            echo json_encode($qna);
        }
    }


?>

<script>
    function deleteBookmarkTask(b_id) {
    $.ajax({
        url: "bookmark_ajax.php",
        type: "post",
        data: {
            delete_bookmarkTask: true,
            id: b_id,
        },
        success: function(data) {
            console.log(data);
        },
        error: function(data) {
            console.log("galti");
        }
    })
}
</script>