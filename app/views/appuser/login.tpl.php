<div class="container my-4">
    <h2>Connexion au back office de Oshoe</h2>


    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email de l'utilisateur" value="">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="mot de passe de l'utilisateur" aria-describedby="passwordBlock" value="">
            <small id="passwordBlock" class="form-text text-muted">
                Le mot de passe doit avoir minimum 12 caractères, un chiffre, une majuscule, une minuscule et un caractère spécial (&é"'(-è_çà)')
            </small>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>