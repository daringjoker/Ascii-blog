
<?php
include("session.php");
include_once ("core/database.php");
global $accesslevel;
if(isset($_REQUEST['action']) and isset($_POST['slug'])) {
    $slug=$_POST['slug'];
    if($accesslevel!='admin'&&$_REQUEST['action']!=='add'&& getFieldBySlug($slug,'author_id')!==$_SESSION['id'])
        error("access forbidden probably not yours to change");
    switch ($_REQUEST['action']) {
        case "add":
        {
            include_once("core/utilities.php");
            $title = strip_tags($_POST['title']);
            if (isset($_POST['content']) && isset($_POST['contentfile']) && $_POST['content'] !== "" && $_POST['contentfile']['name'] !== "") {
                http_response_code(400);
                echo "Either the content or the File must be submitted not both";
                die();
            }
            if ((!isset($_POST['content']) || trim($_POST['content']) == "") && (!isset($_FILES['contentfile']) || $_FILES['contentfile']['size'] === 0)) {
                http_response_code(400);
                echo "Either the content or the Non empty File must be submitted";
                die();
            }
            $file_mode = false;
            $content = "";
            if (isset($_POST['content']) && trim($_POST['content']) !== "") {
                $content = $_POST['content'];
            } else {
                $file_mode = true;
                $content = $_FILES['contentfile']['tmp_name'];
            }
            global $categories;
            if (!in_array($_POST['cat'], array_keys($categories))) {
                http_response_code(400);
                echo "unknown category ;<br> are you trying to hack me??<br> <strong><h1>stop!!</h1> your next attempt will be logged and reported to FBI.</strong>";
                die();
            }
            $cat = $_POST['cat'];
            $slug = trim($_POST['slug']);
            if ($slug === "") {
                if ($file_mode) {
                    $slug = md5_file($content);
                    $slug = md5($slug . "GremlinDiaries_" . random_bytes(32));
                } else {
                    $slug = md5($content . "GremlinDiaries_" . random_bytes(32));
                }
            }
            $publish = false;
            if (isset($_POST['pub']) && $_POST['pub'] === 'on') {
                $publish = true;
            }
            $fname = "";

            if ($file_mode) {
                $fname = sha1_file($content);
                $fname = sha1($fname . "GremlinDiaries_" . random_bytes(32));
                if (!file_exists('contents/' . $fname))
                    move_uploaded_file($content, 'contents/' . $fname);
                else {
                    http_response_code(400);
                    echo "filename clash found. file with same content exists";
                    die();
                }
            } else {
                $fname = sha1($content . "GremlinDiaries_" . random_bytes(32));
                if (!file_exists('contents/' . $fname))
                    file_put_contents('contents/' . $fname, $content);
                else {
                    http_response_code(400);
                    echo "filename clash found. file with same content exists";
                    die();
                }
            }
            $summary = $_POST['summary'];
            $tags = $_POST['tag'];
            $author=$_SESSION['id'];
            addPost($title, $cat, $summary, $tags, $slug, $fname, $publish,$author);
            break;
        }
        case "publish":
        {
            updateFieldBySlug($slug,"published",1,"i");
            echo "success";
            break;
        }
        case "hide":
        {
            updateFieldBySlug($slug,"hidden",1,"i");
            echo"success";
            break;
        }
        case "show":
        {
            updateFieldBySlug($_POST['slug'],"hidden",0,"i");
            echo"success";
            break;
        }
        case "delete":
        {
            deletePostBySlug($slug);
            echo"success";
            break;
        }
        case "updateTitle":
        {
            $title=strip_tags($_POST['title']);
            updateFieldBySlug($_POST['slug'],"title",$title);
            echo "success";
            break;
        }
        case "updateSummary":
        {
            $summary=$_POST['summary'];
            updateFieldBySlug($_POST['slug'],"summary",$summary);
            echo "success";
            break;
        }
        case "updateCategory":
        {
            global $categories;
            $category=$categories[$_POST['category']];
            updateFieldBySlug($slug,'category',$category,'i');
            echo"success";
            break;
        }
        case "updateContent":
        {
            $content=$_POST['content'];
            $filename="contents/".getFieldBySlug($slug,"path");
            file_put_contents($filename,$content);
            echo "success";
            break;
        }
        default:
        {
            http_response_code(400);
            echo "Invalid Action cannot full fill the request";
            break;
        }
    }
}
elseif(isset($_REQUEST['action']))
{
    switch($_REQUEST['action'])
    {
        case 'login':
        {
            $user=$_POST['username'];
            $password=$_POST['password'];
            $userdata=verifyUser($user,$password);
            if($userdata===false)
            {
                echo"{
        'message': 'Username/Password did not match.',
        'status':-1;
        }";
            }
            else{
                session_start();
                foreach($userdata as $key=>$value){
                    $_SESSION[$key]=$value;
                }
                $_SESSION['loggedin']=true;
                header("location: panel.php");
            }

        }
    }
}