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
        <form method="post">
            Do you want to delete: <?= $image['name'] ?>?

            <input type="hidden" name="id" value="<?= $image['_id'] ?>">

            <div>
                <a href="images" class="cancel">No</a>
                <input type="submit" value="Yes"/>
            </div>
        </form>

        <div id="gal">

        </div>
    </div>
</body>
</html>
