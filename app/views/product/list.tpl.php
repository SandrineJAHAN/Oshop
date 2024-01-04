<div class="container my-4">
    <a href="<?= $router->generate('product-add') ?>" class="btn btn-success float-end">Ajouter</a>
    <h2>Liste des produits</h2>

    
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Prix</th>
                <th scope="col">Avis</th>
                <th scope="col">Disponibilité</th>
                <th scope="col">Marque</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Type</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product) : ?>
            <tr>
                <th scope="row"><?= $product->getId() ?></th>
                <td><?= $product->getName() ?></td>
                <td><?= $product->getDescription() ?></td>
                <td><?= $product->getPrice() ?></td>
                <td><?= $product->getRate() ?>/5</td>
                <td><?= $product->getStatus()==1 ? "Dispo" : "Indispo" ?></td>
                <td><?= $product->getBrandId() ?></td>
                <td><?= $product->getCategoryId() ?></td>
                <td><?= $product->getTypeId() ?></td>
                <td class="text-end">
                    <a  href="<?= $router->generate('product-update',[ 'id'=>$product->getId()] ) ?>" 
                        class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('product-delete',[ 'id'=>$product->getId()] ) ?>">
                                Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>