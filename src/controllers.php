<?php
require_once 'business.php';


function images(&$model)
{
    $images = get_images();
    $model['images'] = $images;

    return 'images_view';
}


function reg(){
    $user = [
        'login' => null,
        'mail' => null,
        'pwd'=>null,

    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['mail'])){

            echo '<script>alert("Nieprawidlowy email")</script>';
            return 'reg_view';
        }
        if ($_POST['pwd']===$_POST['rep_pwd']){
            $hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
            $user = [
                'login' => $_POST['login'],
                'mail' => $_POST['mail'],
                'pwd' => $hash,

            ];
            if (!add_user($user)){
                echo '<script>alert("Podana nazwa użytkownika już istnieje")</script>';
                return 'reg_view';
            }
           // echo '<script>alert("Pomyślnie zalogowano")</script>';
            return 'redirect:images';
        }else{
            echo '<script>alert("Hasła się różnią")</script>';

        }

    }
    return 'reg_view';
}
function login(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user = find_user($_POST['login']);


        if ($user !== null ){
            $pwd=$user['pwd'];
           if( password_verify($_POST['pwd'], $pwd)) {
               $_SESSION['logged']=true;
               return 'redirect:images';


           }else{
               echo '<script>alert("Nieprawidłowe hasło")</script>';
           }



        }else{
            echo '<script>alert("Podana nazwa użytkownika nie istnieje")</script>';
        }
    }
    return 'login_view';
}
function logout(){
    unset($_SESSION['logged']);
    unset($_SESSION['user_id']);
    return 'redirect:images';
}
function image(&$model)
{
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        if ($image = get_image($id)) {
            $model['image'] = $image;
            return 'image_view';
        }
    }

    http_response_code(404);
    exit;
}

function edit(&$model)
{

    $image = [
        'name' => null,
        'author' => null,
        'im_path' => null,
        'min_path'=>null,
        '_id' => null
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!empty($_POST['name']) &&
            !empty($_POST['author'])
        ) {

            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $upload_dir = './uploads/orig/';
            $min_upload_dir = './uploads/min/';


            $file = $_FILES['im_path'];

            $file_name = basename($file['name']);

            $target = $upload_dir . $file_name;
            $min_target=$min_upload_dir . $file_name;


            $tmp_path = $file['tmp_name'];
            $size = basename($file['size']);



            $imageinfo = getimagesize($tmp_path);
            $image = [
                'name' => $_POST['name'],
                'author' => $_POST['author'],
                'im_path' => "./uploads/orig/".basename($file['name']),
                'min_path'=>"./uploads/min/".basename($file['name']),
            ];

            $file_OK=true;
            if($size>10000000){
                $file_OK=false;
                echo '<script>alert("Plik jest za duzy do uploadingu!")</script>';

            }
            if (!($imageinfo['mime'] === 'image/jpeg' || $imageinfo['mime'] === 'image/png')){
                $file_OK=false;
                echo '<script>alert("Niepoprawny format zdjecia!")</script>';

            }
            if($file_OK) {
                if (save_image($id, $image) && move_uploaded_file($tmp_path, $target)&& copy($target, $min_target)) {

                    //return 'redirect:images';
                    if ($imageinfo['mime'] === 'image/jpeg'){

                    $source = imagecreatefromjpeg($min_target);
                    }else{
                        $source = imagecreatefrompng($min_target);
                    }

                    list($width, $height) = getimagesize($min_target);

                    $newWidth = 800;
                    $newHeight = $height/($width/$newWidth);

                    $destination = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                    if ($imageinfo['mime'] === 'image/jpeg'){
                    imagejpeg($destination, $min_target, 100);
                    }else{
                        imagepng($destination, $min_target, 100);
                    }



                    return 'redirect:images';
                }else{

                    echo '<script>alert("Cos poszlo nie tak")</script>';

                }

            }

        }
    } elseif (!empty($_GET['id'])) {
        echo '<script>alert("Edytowanie")</script>';
        $image = get_image($_GET['id']);
    }

    $model['image'] = $image;

    return 'edit_view';
}

function delete(&$model)
{
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            delete_image($id);
            return 'redirect:images';

        } else {
            if ($image = get_image($id)) {
                $model['image'] = $image;
                return 'delete_view';
            }
        }
    }

    http_response_code(404);
    exit;
}


