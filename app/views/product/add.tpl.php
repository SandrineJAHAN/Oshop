<div class="container my-4">
    <a href="<?= $router->generate('main-home')?>" class="btn btn-success float-end">Retour</a>
    <h2>Ajouter un produit</h2>

    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie" value="">
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="description" aria-describedby="subtitleHelpBlock" value="">
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Description du produit
            </small>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" value="">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="price" aria-describedby="pictureHelpBlock" value="">
        </div>
        <div class="mb-3">
            <label for="rate" class="form-label">Rate</label>
            <input type="number" class="form-control" id="rate" name="rate" placeholder="rate" aria-describedby="pictureHelpBlock" value="">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="number" class="form-control" id="status" name="status" placeholder="status" aria-describedby="pictureHelpBlock" value="">
        </div>
        <label for="brand-id-select">Choose a Brand_Id:</label>
        <select name="brand_id" id="brand_id">
       
            <?php foreach ($produitIdBrand as $IdBrand) : ?>
                <option value="brand_id">--Please choose an option--</option>
                <option value="brand_id"><?= $IdBrand->getBrandId()?></option>
            <?php endforeach ?>
        </select>

        <label for="category-id-select">Choose a Category_Id:</label>
        <select name="category_id" id="category_id">
       
            <?php foreach ($produitIdCategory as $IdCategory) : ?>
                <option value="category_id">--Please choose an option--</option>
                <option value="category_id"><?= $IdCategory->getCategoryId()?></option>
            <?php endforeach ?>
        </select>

        <label for="type-id-select">Choose a Type_Id:</label>
        <select name="type_id" id="type_id">
       
            <?php foreach ($produitIdType as $IdType) : ?>
                <option value="type_id">--Please choose an option--</option>
                <option value="type_id"><?= $IdType->getTypeId()?></option>
            <?php endforeach ?>
        </select>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>