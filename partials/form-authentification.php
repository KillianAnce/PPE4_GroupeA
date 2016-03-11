<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-   Formulaire de d'authentification
-       => @include : "/grpa2/index.php"
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<form method="post" action="" class="col-lg-6 col-lg-offset-3">
    <h1 class="text-center">Connexion</h1>
    <hr>

    <!-- Numéro d'identification du gendarme -->
    <div class="row">
        <div class="form-group col-lg">
            <label for="champ-nigend">Identifiant du gendarme</label>
            <input type="text" class="form-control" name="champ-nigend" id="champ-nigend" placeholder="Nigend">
        </div>
    </div>

    <!-- Mot de passe du gendarme -->
    <div class="row">
        <div class="form-group col-lg">
            <label for="champ-motdepasse">Mot de passe</label>
            <input type="password" class="form-control" name="champ-motdepasse" id="champ-motdepasse" placeholder="Mot de passe">
            <p class="text-right"><a class="text-right" href="#">Mot de passe oublié ?</a></p>
        </div>
    </div>

    <!-- Bouton de connexion -->
    <div class="row">
        <div class="form-group col-lg text-right">
            <button type="submit" class="btn btn-primary">Connexion</button>
        </div>
    </div>

</form>
