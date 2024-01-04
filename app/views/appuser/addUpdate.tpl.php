<div class="container my-4">
    <a href="<?= $router->generate('appuser-list') ?>" class="btn btn-success float-end">Retour</a>
    <h2><?= (empty($user->getId())) ? 'Ajouter' : 'Modifier' ?> un utilisateur</h2>

    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email de l'utilisateur" value="<?= $user->getEmail() ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe de l'utilisateur">
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom de l'utilisateur" value="<?= $user->getFirstname() ?>">
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom de l'utilisateur" value="<?= $user->getLastname() ?>">
        </div>
        <div class="form-group">
            <label for="role" class="form-label">role</label>
            <select class="custom-select" name="role" id="role" aria-describedby="roleHelpBlock">
                <option value="admin" <?php if ($user->getRole() == 'admin') echo " selected"; ?>>admin</option>
                <option value="catalog-manager" <?php if ($user->getRole() == 'catalog-manager') echo " selected"; ?>>catalog-manager</option>
            </select>
            <small id="roleHelpBlock" class="form-text text-muted">
                Le role de l'utilisateur
            </small>
        </div>

        <div class="form-group">
            <label for="status" class="form-label">Disponibilité</label>
            <select class="custom-select" name="status" id="status" aria-describedby="statusHelpBlock">
                <option value="1" <?php if ($user->getStatus() == 1) echo " selected"; ?>>actif</option>
                <option value="2" <?php if ($user->getStatus() == 2) echo " selected"; ?>>inactif</option>
            </select>
            <small id="statusHelpBlock" class="form-text text-muted">
                Le statut de l'utilisateur
            </small>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>

