<?= "<strong>Created on: </strong><br>" . date("F j, Y, g:i a", $created); ?><br><br>
<strong>Original URL:</strong><br> <a href="<?= $longURL; ?>" target="_blank"><?= $longURL; ?></a><br><br>
<strong>Original Short URL:</strong><br> <a href="<?= $shortURL; ?>" target="_blank"><?= $shortURL; ?></a><br><br>
<strong>Local Short URL:</strong><br> <a href="<?= $baseURL . $hash; ?>" target="_blank"><?= $baseURL . $hash; ?></a><br><br>
<hr width="60%">
<a href="/">Shorten Another</a><br><br>
