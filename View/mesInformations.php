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
                    <a class="nav-link text-white" href="index.php?historiqueLoueur">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-2">Historique</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?derniereStatsLoueur">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-2">Dernière statistiques</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?mesInformations">
                        <i class="bi bi-person-circle"></i>
                        <span class="ms-2">Mes informations</span>
                    </a>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-xl-10 bg-white">
                <header id="head">
                    <h2 class="alert alert-warning"><?php echo htmlspecialchars($_SESSION['loueur_nom']) ?></h2>
                </header>
                <h4 id="center">Mes informations</h4>
                <?php if (isset($_SESSION) && !empty($_SESSION)): ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pays</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= htmlspecialchars((string) $_SESSION['id']) ?></td>
                                <td><?= htmlspecialchars((string) $_SESSION['pays']) ?></td>
                                <td><?= htmlspecialchars((string) $_SESSION['email']) ?></td>
                                <td><?= htmlspecialchars((string) $_SESSION['telephone']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Aucune information à afficher.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>