<?php
include_once("core/database.php");
include_once("core/utilities.php");

function renderBlogPage()
{
    include "core/header.php";
    echo"<link rel='stylesheet' href='static/css/bloglist.css'>";
    echo "<div class='main'>";
    foreach(getAllPosts() as $post) {
        echo "<div class='post'>
<h3 class='post-title'>{$post['title']}</h3>
<pre class='summary'>";
        echo getSummary($post);
        echo "</pre>
<a href=\"blog.php?slug={$post['slug']}\" class='continue'>Continue Reading</a>
</div>";
    }
    echo"</div>";
    include "core/footer.php";
}
if(!isset($_GET['slug'])|| $_GET['slug']===null || $_GET['slug']==="")
{
    renderBlogPage();
}
else{
 $blogpath=getBlogBySlug($_GET['slug']);
 if($blogpath===false)
     renderBlogPage();
 else{
     $content = file_get_contents($blogpath);
//     $content=nl2br($content);
     include("core/header.php");
     echo"<link rel=\"stylesheet\" href=\"static/css/blog.css\">";
     echo"<div class='main-area'> <pre class='main'>$content</pre></div>";
     include_once ("core/footer.php");
 }

}

