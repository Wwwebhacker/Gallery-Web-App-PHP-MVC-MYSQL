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

        <div id="gal">

    <?php if (count($images)): ?>
        <?php foreach ($images as $image): ?>
            Name: <?= $image['name'] ?>
            <br>
            Author: <?=$image['author'] ?>
            <a href="<?= $image['im_path'] ?>" target="_blank" class="gallery">  <img src="<?= $image['min_path'] ?>">  </a>
                    <a href="delete?id=<?= $image['_id'] ?>">Delete</a>
                <br>
                <br>

        <?php endforeach ?>

    <?php else: ?>
        No photos

    <?php endif ?>
                <br>
                <a href="edit">Upload new photo</a>
        </div>
    </div>

</body>
</html>
