<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Importation produits OuiEatFrench</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
</head>
    <body>
        <span>
                <a href="drop.php">Drop DB</a>
            </span>
        <form method="post" action="import.php" enctype="multipart/form-data" id="form-import">
                <input type="file" name="import-file" id="button-import" required>
                <input type="submit" value="Importer produits" id="button-submit" class="btn btn-large">
        </form>
    </body>
</html>