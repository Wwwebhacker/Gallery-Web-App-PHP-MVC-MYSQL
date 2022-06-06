<?php




function get_db()
{
    return new PDO('mysql:hos=localhost;dbname=my_images','root');
}

function add_user($user){


    $login=$user['login'];
    $mail=$user['mail'];
    $pwd=$user['pwd'];
    $db = get_db();

    $query="SELECT * FROM users WHERE login="."'$login'";
    $stmt=$db->query($query);

    $result=$stmt->fetchAll();
    if ($result==null){
        $db->query("INSERT INTO users (login, mail, pwd)
VALUES ('$login', '$mail', '$pwd')");
    }else{
        return false;
    }



    return true;
}
function find_user($login){

    $db = get_db();
    $query="SELECT * FROM users WHERE login="."'$login'";
    $stmt=$db->query($query);
    $result=$stmt->fetch();
    var_dump($result);
    $user = [
        'login' => $result['login'],
        'mail' => $result['mail'],
        'pwd'=>$result['pwd'],

    ];
    var_dump($user);
    return $user;
}
function get_images()
{

    $db = get_db();

    $query='SELECT * FROM images';
    $stmt=$db->query($query);

    return $stmt->fetchAll();

}



function get_image($id)
{
    $db=get_db();
    return $db->query("SELECT * FROM images WHERE _id=$id")->fetch();
}

function save_image($id, $image)
{

    $name=$image['name'];
    $author=$image['author'];
    $im_path=$image['im_path'];
    $min_path=$image['min_path'];

    $db=get_db();
    if ($id == null) {
        $query="INSERT INTO images (name, author, im_path,min_path)
VALUES ('$name', '$author', '$im_path', '$min_path')";

        $db->query($query);
    } else {
        return false;
    }


    return true;
}

function delete_image($id)
{
    $db = get_db();
    $db->query("DELETE FROM images WHERE _id="."'$id'");

//    $db->images->deleteOne(['_id' => new ObjectID($id)]);
}
