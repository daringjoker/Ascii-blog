<?php include_once("core/utilities.php");
include("session.php");
include_once("core/database.php");
include_once("core/header.php");
?>
<link rel="stylesheet" href="static/css/panel.css">
<div class="panel-area">
    <h2> <?php echo headerify("Admin Panel")?></h2>
    <div class="bloglist">
        <?php
        if($_SESSION['privilege']==='admin')
            $allPosts= getAllPosts();
        else
            $allPosts=getAllPosts($_SESSION['id']);
        ?>
        <?php foreach( $allPosts as $post):?>
        <div class="post-item">
            <input type="checkbox" title="Toggle Visiblity/Hidden" class="visibility" data-post-id="<?php echo $post['slug'];?>" <?php if (!$post['hidden'])echo "checked";?>/>
            <h3 class="post-title" title="Double click to edit" data-post-id="<?php echo $post['slug'];?>"><?php echo $post["title"]?></h3>
            <?php if(!$post['published']) :?>
               <button class="publish" title="Publish" data-post-id="<?php echo $post['slug'];?>">&#x27A4;</button>
            <?php endif;?>
            <select class ="cat" data-post-id="<?php echo $post['slug'];?>" >
                <?php
                global $categories;
                foreach(array_keys($categories) as $cat) {
                    echo '<option value="'.$cat.'" '.(($cat===array_keys($categories)[$post['category']-1])?"selected":"").' >'.$cat.'</option>';
                }
                ?>
            </select>
            <a class="edit" title="Edit Post Content or/and Summary" href="<?php echo "edit.php?slug=".$post['slug'];?>">&#x270e;</a>
            <button class="delete" title="Delete this Post" data-post-id="<?php echo $post['slug'];?>">&#128465;</button>
        </div>
        <?php endforeach;?>
        <div class="add-new">
            <a href="add.php">+</a>
        </div>
    </div>
</div>
<script src="static/js/panel.js"></script>
<?php include_once("core/footer.php") ?>

