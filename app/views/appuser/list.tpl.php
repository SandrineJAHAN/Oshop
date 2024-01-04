<div class="container my-4">
        <a href="<?= $router->generate('appuser-add') ?>" class="btn btn-success float-end">Ajouter</a>
        <h2>Liste des utilisateurs</h2>
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">email</th>
                    <th scope="col">firstname</th>
                    <th scope="col">lastname</th>
                    <th scope="col">role</th>
                    <th scope="col">status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) : ?>
                <tr>
                    <th scope="row"><?= $user->getId() ?></th>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $user->getFirstname() ?></td>
                    <td><?= $user->getLastname() ?></td>
                    <td><?= $user->getRole() ?></td>
                    <td><?= $user->getStatus() ?></td>
                    <td class="text-end">
                        <a href="<?= $router->generate('appuser-edit', ['id' => $user->getId()]) ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= $router->generate('appuser-delete', ['id' => $user->getId()]) ?>">Oui, je veux supprimer</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
