<?php require_once "includes/header_register.php"; ?>
<?php

if (isset($_POST['inscription'])) {
    if (empty($_POST['prenom']) || !ctype_alpha($_POST['prenom'])) {
        $message = " Votre prénom doit être une chaine de caractères alphabetiques !";
    }elseif(empty($_POST['nom']) || !ctype_alpha($_POST['nom'])) {
        $message = " Votre nom doit être une chaine de caractères alphabetiques !";
    }elseif(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $message = " Rentrer une adresse email valide !";
    }elseif(empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']) {
        $message = " Rentrer un mot de passe valide !";
    }elseif(empty($_POST['username']) || !ctype_alnum($_POST['username'])) {
        $message = " Votre username doit être une chaine de caractères alphanumerique !";
    }else {
        require_once "includes/bdd.php";
        $requete = $bdd->prepare('INSERT INTO utilisateurs(nom_utilisateur,prenom_utilisateur,
        username,email_utilisateur,
        password_utilisateur,token_utilisateur,photo_utilisateur)
        VALUES (:nom, :prenom, :username, :email, :password, :token, :photo_profil)');
        $requete->bindValue(':nom', $_POST['nom']);
        $requete->bindValue(':prenom', $_POST['prenom']);
        $requete->bindValue(':username', $_POST['username']);
        $requete->bindValue(':email', $_POST['email']);
        $requete->bindValue(':password', $_POST['password']);
        $requete->bindValue(':token', "aaa");
    
        if (empty($_FILES['photo_profil']['name'])) {
            $photo_profil = '';
            $requete->bindValue(':photo_profil', $photo_profil);
        }else {
            if (preg_match("#jpeg|png|jpg#", $_FILES['photo_profil']['type'])) {
                $path = "img/photo_profil/";
                $destination = $path . $_FILES['photo_profil']['name'];
                if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $destination)) {
                    $requete->bindValue(':photo_profil', $_FILES['photo_profil']['name']);
                }else {
                    $message = "Erreur lors du déplacement du fichier.";
                }
            }else {
                $message = " La photo de profil doit être de type: jpeg, png ou jpg";
            }
            $requete->execute();
        }
        
    }
}
?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <?php if (isset($message)) echo $message;?>
                                    <h3 class="text-center font-weight-light my-4">Créer un compte</h3>
                                </div>
                                <div class="card-body">
                                    <form action="register.php" method="post" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" type="text" name="prenom" />
                                                    <label for="inputFirstName">Pénom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="text" name="nom" />
                                                    <label for="inputLastName">Nom</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" name="email" />
                                            <label for="inputEmail">Adresse Email</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" type="password" name="password" />
                                                    <label for="inputPassword">Mot de passe</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" type="password" name="confirm_password" />
                                                    <label for="inputPasswordConfirm">Confirmation du mot de passe</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" type="text" name="username" />
                                                    <label for="inputFirstName">Nom d'utilisateur</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div>
                                                    <label for="photo">Photo de profil</label>
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                                    <input id="photo" type="file" name="photo_profil" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><input type="submit" name="inscription" value="Créer un compte" class="btn btn-primary btn-block" href="login.html"></input></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Vous avez un compte? Connectez-vous</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <?php require_once "includes/footer.php"; ?>