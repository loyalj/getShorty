<div id="divForm">
    <? if(isset($flashMessage)) { ?>
        <div id="divFlashMessage">
            <?= $flashMessage;?>
        </div>
    <? } ?>
    <form action="/" method="post">
        <input type="text" name="longURL" id="longURL" autofocus="autofocus" <? if(isset($lastInput)) { ?> value="<?= $lastInput;?>" <? } ?>>
        <input type="submit" value="Shorten">
    </form>
</div>
