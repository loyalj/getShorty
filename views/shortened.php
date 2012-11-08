<?= "<strong>Created on: </strong><br>" . date("F j, Y, g:i a", $created); ?><br><br>
<strong>Original URL:</strong><br> <a href="<?= $longURL; ?>" target="_blank"><?= $longURL; ?></a><br><br>
<strong>Short URL:</strong><br> <a href="<?= $shortURL; ?>" target="_blank"><?= $shortURL; ?></a><br><br>
<hr width="60%">
<a href="/">Shorten Another</a><br><br>
