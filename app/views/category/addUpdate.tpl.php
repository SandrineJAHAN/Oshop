<div class="container my-4">
        <a href="<?= $router->generate('category-list') ?>" class="btn btn-success float-end">Retour</a>
        <h2><?= (empty($category->getId()))?'Ajouter':'Modifier' ?> une catégorie</h2>
        
        <form action="" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie" value="<?= $category->getName() ?>">
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Sous-titre</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Sous-titre" aria-describedby="subtitleHelpBlock" value ="<?= $category->getSubtitle() ?>">
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page d'accueil comme bouton devant l'image
                </small>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" value ="<?= $category->getPicture() ?>">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            
            <!-- tokencsrf en hidden pour le renvoyer et le comparer à celui stocké en $_SESSION -->
            <input type="hidden" name="tokenCSRF" id="tokenCSRF" value="<?= $tokenCSRF ?>">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>