<div id="topPage"class="d-flex flex-column min-vh-200">
    <div class="container-fluid flex-grow-1">
        <div class="row">
            <div id="side-bar" class="col-12 col-md-3 col-xl-2 bg-dark text-white p-0 d-flex flex-column">
                <nav class="navbar bg-dark border-bottom border-white">
                    <div class="container-fluid">
                        <a id="deco" class="navbar-brand text-white" href="index.php?deco">
                            <i class="bi bi-house-door"></i>
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
                <h4 id="center">Dernières statistiques</h4>
                <?php if (!empty($log)): ?>
                    <table id="derniereStatsLoueur">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>nom</th>
                            <th>Date</th>
                            <th>Erreur KO</th>
                            <th>Erreur Timeout</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($log as $log): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $log['idLoueur']) ?></td>
                                <td><?= htmlspecialchars((string) $log['nom']) ?></td>
                                <td><?= htmlspecialchars((string) $log['date']) ?></td>
                                <td><?= htmlspecialchars((string) $log['erreurKO']) ?></td>
                                <td><?= htmlspecialchars((string) $log['erreurTimeouts']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucune donnée à afficher.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <footer class="text-center">
        <h2 id="footer" class="alert alert-warning">Giurgiuman Alexandre, Barthelemy Maxence, Gamet Dylan</h2>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
