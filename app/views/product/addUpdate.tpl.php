<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-right">Retour</a>
<h2><?= (empty($product->getId())) ? 'Ajouter' : 'Modifier' ?> un produit</h2>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit" value="<?= $product->getName() ?>">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?= $product->getDescription() ?>" aria-describedby="descriptionHelpBlock">
        <small id="subtitleHelpBlock" class="form-text text-muted">
            La description du produit
        </small>
    </div>
    <div class="form-group">
        <label for="picture">Image</label>
        <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" value="<?= $product->getPicture() ?>" aria-describedby="pictureHelpBlock">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur
            <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <div class="form-group">
        <label for="price">Prix</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?= $product->getPrice() ?>" aria-describedby="priceHelpBlock">
        <small id="priceHelpBlock" class="form-text text-muted">
            Le prix du produit
        </small>
    </div>

    <div class="form-group">
        <label for="rate" class="form-label">Avis</label>
        <select class="custom-select" name="rate" id="rate" aria-describedby="rateHelpBlock">
            <option value="1" <?php if ($product->getRate() == 1) echo " selected"; ?>>Médiocre</option>
            <option value="2" <?php if ($product->getRate() == 2) echo " selected"; ?>>Passable</option>
            <option value="3" <?php if ($product->getRate() == 3) echo " selected"; ?>>Décent</option>
            <option value="4" <?php if ($product->getRate() == 4) echo " selected"; ?>>Remarquable</option>
            <option value="5" <?php if ($product->getRate() == 5) echo " selected"; ?>>Excellent</option>
        </select>
        <small id="rateHelpBlock" class="form-text text-muted">
            Le statut du produit
        </small>
    </div>

    <div class="form-group">
        <label for="status" class="form-label">Disponibilité</label>
        <select class="custom-select" name="status" id="status" aria-describedby="statusHelpBlock">
            <option value="0" <?php if ($product->getStatus() == 0) echo " selected"; ?>>Non renseigné</option>
            <option value="1" <?php if ($product->getStatus() == 1) echo " selected"; ?>>Disponible</option>
            <option value="2" <?php if ($product->getStatus() == 2) echo " selected"; ?>>Indisponible</option>
        </select>
        <small id="statusHelpBlock" class="form-text text-muted">
            Le statut du produit
        </small>
    </div>

    <div class="form-group">
        <label for="category" class="form-label">Catégorie</label>
        <select class="custom-select" id="category" name="category_id" aria-describedby="categoryHelpBlock" ?>">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category->getId() ?>" <?php if ($product->getCategoryId() == $category->getId()) echo " selected"; ?>><?= $category->getName() ?> </option>
            <?php endforeach ?>
        </select>
        <small id="categoryHelpBlock" class="form-text text-muted">
            La catégorie du produit
        </small>
    </div>

    <div class="form-group">
        <label for="brand" class="form-label">Marque</label>
        <select class="custom-select" id="brand" name="brand_id" aria-describedby="brandHelpBlock" value="<?= $product->getBrandId() ?>">
            <?php foreach ($brands as $brand) : ?>
                <option value="<?= $brand->getId() ?>" <?php if ($product->getBrandId() == $brand->getId()) echo " selected"; ?>><?= $brand->getName() ?> </option>
            <?php endforeach ?>
        </select>
        <small id="brandHelpBlock" class="form-text text-muted">
            La marque du produit
        </small>
    </div>

    <div class="form-group">
        <label for="type" class="form-label"> Type</label>
        <select class="custom-select" id="type" name="type_id" aria-describedby="typeHelpBlock" value="<?= $product->getTypeId() ?>">
            <?php foreach ($types as $type) : ?>
                <option value="<?= $type->getId() ?>" <?php if ($product->getTypeId() == $type->getId()) echo " selected"; ?>><?= $type->getName() ?> </option>
            <?php endforeach ?>
        </select>
        <small id="typeHelpBlock" class="form-text text-muted">
            Le type de produit
        </small>
    </div>

    <?php foreach ($tags as $tag) : ?>
        <label for="tags<?= $tag->getId() ?>"><?= $tag->getName() ?></label>
        <input type="checkbox" 
        id="tags<?= $tag->getId() ?>" 
        name="tags[]" 
        value="<?= $tag->getId() ?>"
        <?= (in_array($tag, $productTags)) ? 'checked' : '' ?>
        >
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>

