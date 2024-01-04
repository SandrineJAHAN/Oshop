    <?php if (!empty($errorList)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errorList as $error) : ?>
                <div><?= $error ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>