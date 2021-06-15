<?php
include_once("core/database.php");
include("session.php");
function renderBlogPage()
{
    echo "This will be the future Blog page !!!";
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
        $summary = getFieldBySlug($_GET['slug'],"summary");
        include("core/header.php");
        echo"<link rel=\"stylesheet\" href=\"static/css/blog.css\">";
        echo"<h2 style='text-align:center;width:90%;margin:auto;'>Blog Content</h2>";
        echo"<div class='main-area' > <pre class='main' id='content' data-post-id=\"{$_GET['slug']}\" contenteditable>$content</pre></div>";
        echo"<h3 style='text-align:center;width:90%;margin:auto;' > summary</h3>";
        echo"<div class='main-area' > <pre class='main' id='summary' data-post-id=\"{$_GET['slug']}\" contenteditable>$summary</pre></div>";
        echo "<script src='static/js/edit.js' defer></script>";
        include_once ("core/footer.php");
    }

}


