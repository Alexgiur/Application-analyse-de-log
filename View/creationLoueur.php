<div class="page-wrapper d-flex flex-column min-vh-100">
    <div class="container-fluid flex-grow-1">
        <div class="row">
            <div id="side-bar" class="col-12 col-md-3 col-xl-2 bg-dark text-white p-0 d-flex flex-column">
                <nav class="navbar bg-dark border-bottom border-white">
                    <div class="container-fluid">
                        <a id="deco" class="navbar-brand text-white" href="index.php?deco">
                            <i  class="bi bi-power"></i>
                            <span id="boutondeco" class="ms-2"><strong>Déconnexion</strong></span>
                        </a>
                    </div>
                </nav>
                <nav class="nav flex-column p-2">
                    <a class="nav-link text-white" href="index.php?historiqueAdmin">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-2">Historique</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?derniereStatsAdmin">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-2">Dernière stats des loueurs</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?statsParLoueur">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-2">Stats par loueur</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?creerLoueur">
                        <i class="bi bi-person-circle"></i>
                        <span class="ms-2">Création d'un loueur</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?modifierLoueur">
                        <i class="bi bi-person-circle"></i>
                        <span class="ms-2">Modification d'un loueur</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?supprimerLoueur">
                        <i class="bi bi-person-circle"></i>
                        <span class="ms-2">Suppression d'un loueur</span>
                    </a>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-xl-10 bg-white">
                <header id="head">
                    <h2 class="alert alert-warning"><?php echo htmlspecialchars($_SESSION['loueur_nom']) ?></h2>
                </header>
                <?php if($message_valider != '')
                    echo "<div class=\"text-center alert alert-warning errorMessage\">$message_valider</div>";
                ?>
                <h4 id="center">Créer votre loueur</h4>
                <form method="post" action="index.php?creerLoueur">
                    <table>
                        <tr>
                            <td colspan="3"><input type="number" name="id" min="0" placeholder="Id" /></td>
                        </tr>

                        <tr>
                            <td colspan="3"><input type="text" name="nom" placeholder="Nom" /></td>
                        </tr>

                        <tr>
                            <td colspan="3"><input type="password" name="motdepasse" placeholder="Mot de passe" /></td>
                        </tr>

                        <tr>
                            <td colspan="3"><input type="text" name="pays" placeholder="Pays" /></td>
                        </tr>

                        <tr>
                            <td colspan="3"><input type="text" name="email" placeholder="Email" /></td>
                        </tr>

                        <tr>
                            <td colspan="3"><input type="text" name="numTel" placeholder="Téléphone" /></td>
                        </tr>

                        <tr>
                            <td><br><input class="btn btn-warning" name="btnErase" type="reset" value="Effacer" /></td>
                            <td><br><input class="btn btn-primary" name="btnValider" type="submit" value="Ajouter" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>