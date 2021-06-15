
<?php
include_once ("database.php");
function headerify($text,$attributes="")
{
    $hdr="<div ".$attributes." style='line-height:70%'>".strtoupper($text)."<br>";
    for($i=0;$i<strlen($text);$i++)
        $hdr.="-";
        $hdr.="</div>";
    return $hdr;
}
function populateHighlights()
{
    echo "<ul>";
    foreach(getHighlights() as $post)
    {
        echo"<li><a href='blog.php?slug=".$post["slug"]."'>".$post["title"]."</a>";
    }
    echo"</ul>";
}
function populateCatUi($category)
{
    echo "<ul>";
    foreach(getPostsByCategory($category) as $post)
    {
        echo"<li><a href='blog.php?slug=".$post["slug"]."'>".$post["title"]."</a>";
    }
    echo"</ul>";
}

function getSummary($post)
{
    if(trim($post['summary'])!="")
    {
        return $post['summary'];
    }
    else
    {
        $content=file_get_contents("contents/".$post['path'],false,null,0,200);
        return $content;
    }
}
function error($errorstr,$status=400)
{
    http_response_code($status);
    echo"{
        'message': '$errorstr',
        'status':-1;
        }";
    die();
}