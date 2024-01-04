<div class="container my-4">
    <form action="" method="POST" class="mt-5">
        <div class="row">
            <?php for ($index = 1; $index <= 5; $index++) : ?>
                <div class="col">
                    <div class="form-group">
                        <label for="emplacement<?= $index ?>">Emplacement #<?= $index ?></label>
                        <select class="form-control" id="emplacement<?= $index ?>" name="emplacement[]">
                            <option value="">choisissez :</option>
                            <?php foreach($categories as $category) : ?>
                            <option value="<?= $category->getId() ?>"
                                <?= ($category->getHomeOrder() == $index) ? 'selected' : '' ?>
                            ><?= $category->getName() ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>