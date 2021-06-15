<?php include_once("core/database.php");?>
<?php include_once("session.php");?>
<?php include_once ("core/header.php");?>
<?php if (!isset($_POST['title'])):?>
    <link rel="stylesheet" href="static/css/add.css">
<div class="main">
    <form method="POST" enctype="multipart/form-data">
        <div class="input-item">
            <label for="title">Title</label>
            <input type="text" id="title" required name="title">
        </div>
        <div class="input-item">
            <label for="content">Content</label>
            <textarea  id="content" name="content" placeholder="Enter the blog content here or select the file below">
            </textarea>
        </div>
        <div class="input-item">
            <label for="content2"> OR select File</label>
            <input type="file" name="contentfile" id="content2">
        </div>
        <div class="input-item">
            <label for="summary">Summary</label>
            <textarea  id="summary" name="summary" placeholder="Enter the summary of the blog here">
            </textarea>
        </div>
        <div class="input-item">
            <label for="cat">Category</label>
            <select id='cat' name="cat" required>
                <?php
                global $categories;
                foreach(array_keys($categories) as $cat) {
                    echo '<option value="'.$cat.'">'.$cat.'</option>';
                }
                ?>
            </select>
        </div>
        <div class="input-item">
            <label for="tag">Tag</label>
            <input type="text" id="tag" name="tag">
        </div>
        <div class="input-item">
            <label for="slug">Slug</label>
            <input id='slug' type="text" name="slug">
        </div>

        <div class="input-item">
            <label for="pub">Publish</label>
            <input type="checkbox" name="pub" id="pub">
        </div>

        <input type="submit" value="Submit">
    </form>
</div>
<?php else:?>
    <?php
    include_once("core/utilities.php");
    $title=strip_tags($_POST['title']);
    if(isset($_POST['content']) && isset($_POST['contentfile']) && $_POST['content']!=="" && $_POST['contentfile']['name']!=="")
    {
        http_response_code(400);
        echo "Either the content or the File must be submitted not both";
        die();
    }
    if((!isset($_POST['content']) || trim($_POST['content'])=="") && (!isset($_FILES['contentfile'])||$_FILES['contentfile']['size']===0)) {
        http_response_code(400);
         echo "Either the content or the Non empty File must be submitted";
         die();
     }
    $file_mode=false;
    $content="";
    if(isset($_POST['content']) && trim($_POST['content'])!=="")
    {
        $content=$_POST['content'];
    }
    else
    {
        $file_mode=true;
        $content=$_FILES['contentfile']['tmp_name'];
    }
    global $categories;
    if(!in_array($_POST['cat'],array_keys($categories)))
    {
        http_response_code(400);
        echo "unknown category ;<br> are you trying to hack me??<br> <strong><h1>stop!!</h1> your next attempt will be logged and reported to FBI.</strong>";
        die();
    }
    $cat=$_POST['cat'];
    $slug=trim($_POST['slug']);
    if($slug==="")
    {
        if ($file_mode) {
            $slug = md5_file($content);
            $slug = md5($slug . "GremlinDiaries_" . random_bytes(32));
        }
        else
        {
            $slug=md5($content."GremlinDiaries_" . random_bytes(32));
        }
    }
    $publish=false;
    if(isset($_POST['pub'])&&$_POST['pub']==='on')
    {
        $publish=true;
    }
    $fname="";

    if ($file_mode) {
        $fname = sha1_file($content);
        $fname = sha1($fname . "GremlinDiaries_" . random_bytes(32));
        if(!file_exists('contents/'.$fname))
        move_uploaded_file($content,'contents/'.$fname);
        else{
            http_response_code(400);
            echo "filename clash found. file with same content exists";
            die();
        }
    }
    else
    {
        $fname=sha1($content."GremlinDiaries_" . random_bytes(32));
        if(!file_exists('contents/'.$fname))
        file_put_contents('contents/'.$fname,$content);
        else{
            http_response_code(400);
            echo "filename clash found. file with same content exists";
            die();
        }
    }
    $summary=$_POST['summary'];
    $tags=$_POST['tag'];
    $author=$_SESSION['id'];
    addPost($title,$cat,$summary,$tags,$slug,$fname,$publish,$author);
    ?>
<div class="main" style="width:90%;min-height=90vh;display:flex;text-align:center;justify-content: center;margin:auto;">
    <h2>Blog added Successfully</h2>
</div>
<?php endif;?>
<?php include_once ("core/footer.php");?>
