<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="static/css/style.css" />
    <meta charset="UTF-8"/>
    <title>Cars</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
<div id="wrapper">
    <header>
        <div id="headId" class="head">
            <h1>Cars</h1>
        </div>
    </header>





    <div id="content">
        <?php if (!isset($_SESSION['logged'])): ?>
            <a href="login">Login</a>  <a href="reg">Sign up</a>
        <?php else: ?>
            Successfully logged in
            <a href="logout">Logout</a>
        <?php endif ?>

        <h2> <a href="images">Gallery</a></h2>
        <form method="post" enctype="multipart/form-data">
            <label>
                <span>Name:</span>
                <input type="text" name="name" value="<?= $image['name'] ?>" required/>
            </label>
            <label>
                <span>Author:</span>
                <input type="text" name="author" value="<?= $image['author'] ?>" required/>
            </label>


            <input type="file" name="im_path" required/>
            <input  type="hidden" name="id" value="<?= isset($image['_id'] ) ? $image['_id']  :null;?>"/>

            <div>
                <a href="images" class="cancel">Cancel</a>
                <input type="submit" value="Upload"/>
            </div>
        </form>

        <div id="gal">

        </div>
    </div>




</body>
</html>
