<?php
$categories=[ "programming"=>1,"security"=>2,"electronics"=>3,"project"=>4,"general"=>5];
$sqlUrl="localhost";
$password="wakejarvis";
$user="root";
$dbname="asciiblog";
if (!isset($conn))
    $conn= new mysqli($sqlUrl,$user,$password,$dbname);
if (!isset($insrt_qry))
    $insrt_qry = $conn->prepare("INSERT INTO `posts` (`id`, `title`, `summary`, `slug`, `path`, `category`, `published_on`, `published`, `hidden`, `tags`, `author_id`) VALUES (NULL,?, ?,?,?,?,CURRENT_TIMESTAMP,?, '0',?,?);");
function getPostsByCategory($cat)
{
    global $categories,$conn;
    $cat=$categories[$cat];
    $qry="SELECT * from posts where category = '".$conn->escape_string($cat)."' and published = true and hidden=false order by published_on desc;";
    $result=$conn->query($qry);
    if($result===false) echo "something is wrong with the qwery";
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getAllPosts($author=-1)
{
    global $conn;
    if($author===-1)
    $qry="SELECT * from posts order by published_on desc ;";
    else
        $qry="SELECT * from posts where  `author_id`={$author} order by published_on desc ;";
    $result=$conn->query($qry);
    if($result===false) echo "something wrong".$conn->error;
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getHighlights()
{
    global $conn;
    $qry="SELECT  * from posts where published = true and hidden=false order by published_on desc limit 10;";
    $result=$conn->query($qry);
    //if($result===false) echo "something is wrong with the qwery";
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getBlogBySlug($slug)
{
    global $conn;
    $qry="SELECT  path from posts where slug='$slug'";
    $result=$conn->query($qry);
//    print_r($result->fetch_all(MYSQLI_ASSOC)[0]['path']);
    if ($result===false)return false;
else return "contents/".$result->fetch_all(MYSQLI_ASSOC)[0]['path'];
}
function addPost($title,$category,$summary,$tags,$slug,$filename,$published,$author=1)
{
    global $insrt_qry,$categories;
//    mysqli_report(MYSQLI_REPORT_ALL);
    $published=$published?1:0;
    $category=$categories[$category];
    $insrt_qry->bind_param('ssssiisi',$title,$summary,$slug,$filename,$category,$published,$tags,$author);
    $rc=$insrt_qry->execute();
    if($rc===false)
    {
        http_response_code(500);
        echo "error";
        die();
    }
//    mysqli_report(MYSQLI_REPORT_ALL);
}
function updateFieldBySlug($slug,$field,$value,$type="s")
{
    global $conn;
    $update_qry= $conn->prepare("update `posts` set $field=? where slug=?");
    $update_qry->bind_Param($type."s",$value,$slug);
    $rc=$update_qry->execute();
    if($rc===false)
    {
        http_response_code(500);
        echo "error";
        die();
    }
}
function getFieldBySlug($slug,$field)
{
    global $conn;
    $update_qry= $conn->prepare("select $field from `posts` where slug=?");
    $update_qry->bind_Param("s",$slug);
    $rc=$update_qry->execute();
    if($rc===false)
    {
        http_response_code(500);
        echo "error";
        die();
    }
    else{
        return $update_qry->get_result()->fetch_all(MYSQLI_ASSOC)[0][$field];
    }
}

function deletePostBySlug($slug)
{
    global $conn;
    $update_qry= $conn->prepare("delete from `posts` where slug=?");
    $update_qry->bind_Param("s",$slug);
    $rc=$update_qry->execute();
    if($rc===false)
    {
        http_response_code(500);
        echo "error";
        die();
    }

}
function addUser($fname,$lname,$email,$username,$password)
{
    global $conn;
    $fname=$conn->real_escape_string($fname);
    $lname=$conn->real_escape_string($lname);
    $email=$conn->real_escape_string($email);
    $username=$conn->real_escape_string($username);
    $password=$conn->real_escape_string($password);
    $password=sha1($password);
    $user_qry= $conn->prepare("INSERT INTO `users` (`id`, `username`, `password`, `avatar`, `bio`, `firstname`, `lastname`, `email`, `lastlogin`, `activesessid`, `active`, `loggedin`, `privilege`) VALUES (NULL, ?, ?, NULL, NULL, ?, ?, ?, CURRENT_TIMESTAMP, NULL, '1', '0', 'user');");
    $user_qry->bind_param('sssss',$username,$password,$fname,$lname,$email);
    $rc=$user_qry->execute();
    if($rc===false)
    {
        http_response_code(500);
        echo"{
        'message': 'Error could  not process the request',
        'status':-1;
        }";
        die();
    }else{
        $result=$user_qry->get_result();
        $numrows=$result->num_rows;
        if($numrows===1)
        {
            http_response_code(500);
            echo"{
        'message': 'Signup successful',
        'status':0;
        }";
            die();
        }
        else
        {
            return false;
        }
    }
}
function verifyUser($user,$pass)
{
    global $conn;
    $user=$conn->real_escape_string($user);
    $pass=$conn->real_escape_string($pass);
    $pass=sha1($pass);
    $user_qry= $conn->prepare("select * from  `users` where username=? and password=?;");
    $user_qry->bind_Param("ss",$user,$pass);
    $rc=$user_qry->execute();
    if($rc===false)
    {
        http_response_code(500);
        echo"{
        'message': 'Error could not process the request',
        'status':-1;
        }";
        die();
    }else{
        $result=$user_qry->get_result();
        $numrows=$result->num_rows;
        if($numrows===1)
        {
            return $result->fetch_assoc();
        }
        else
        {
            return false;
        }
    }
}
