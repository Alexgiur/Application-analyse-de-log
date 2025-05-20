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
                <?php if($message_erreur != '')
                    echo "<div class=\"alert alert-danger errorMessage\">$message_erreur</div>";
                ?>
                <h4 id="center">Recherche de statistiques par loueur</h4>

                <form method="post" action="index.php?statsParLoueur">
                    <table id="statsLoueur">
                        <tr>
                            <td colspan="3"><input type="number" name="id" min="0" placeholder="Id du loueur"/></td>
                        </tr>
                        <tr>
                            <td id="date" colspan="3"><input type="date" name="date"></td>
                        </tr>
                        <tr>
                            <td><br><input class="btn btn-warning" name="btnErase" type="reset" value="Effacer" /></td>
                            <td><br><input class="btn btn-primary" name="btnRecherche" type="submit" value="Chercher" /></td>
                        </tr>
                    </table>
                </form>

                <?php if (isset($_POST['btnRecherche'])):
                    if(!empty($logs)) : ?>
                        <h1>Statistique pour le loueur <?= $logs[0]['nom'] ?></h1>
                    <?php endif;
                endif; ?>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Erreur KO</th>
                        <th>Erreur Timeouts</th>
                        <th>Appels KO (Total)</th>
                        <th>Timeouts (Total)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($logs) && !empty($logs) && isset($sum) && !empty($sum) && isset($sumTotal) && !empty($sumTotal) ): ?>
                    <?php $date = date('Y-m-d', strtotime($logs[0]['date'])); ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $logs[0]['idLoueur']) ?></td>
                            <td><?= htmlspecialchars((string) $logs[0]['nom']) ?></td>
                            <td><?= htmlspecialchars((string) $date) ?></td>
                            <td><?= htmlspecialchars((string) $logs[0]['erreurKO']) ?></td>
                            <td><?= htmlspecialchars((string) $logs[0]['erreurTimeouts']) ?></td>
                            <td><?= htmlspecialchars($sumTotal['total_erreur_KO']) ?></td>
                            <td><?= htmlspecialchars($sumTotal['total_erreur_Timeouts']) ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>