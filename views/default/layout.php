<!DOCTYPE html>
<html lang="en-us">

    <head>
        <meta charset="utf-8">
        <title><?= $pageTitle;?></title>
        <link rel="stylesheet" href="/css/<?= $baseHost; ?>/main.css" type="text/css" />
    </head>

    <body>	    	
        <div id="divMain">
            <h1><?= $headerContent; ?></h1>
            <h6><?= $bylineContent; ?></h6>
            <?= $bodyContent; ?>
        </div>
    </body>
</html>
