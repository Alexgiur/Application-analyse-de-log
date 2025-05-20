<div class="page-wrapper d-flex flex-column min-vh-100">
    <div class="container-fluid flex-grow-1">
        <div class="row">
            <div id="side-bar" class="col-12 col-md-3 col-xl-2 bg-dark text-white p-0 d-flex flex-column">
                <nav class="navbar bg-dark border-bottom border-white">
                    <div class="container-fluid">
                        <a id="deco" class="navbar-brand text-white" href="index.php?deco">
                            <i  class="bi bi-house-door"></i>
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
                <h4 id="center">Statistiques</h4>
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
                    <?php if (isset($logs) && !empty($logs) && isset($stats) && !empty($stats)): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $logs[0]['id']) ?></td>
                            <td><?= htmlspecialchars((string) $logs[0]['nom']) ?></td>
                            <td><?= htmlspecialchars((string) $logs[0]['date']) ?></td>
                            <td><?= htmlspecialchars((string) $logs[0]['appelsKO']) ?></td>
                            <td><?= htmlspecialchars((string) $logs[0]['timeouts']) ?></td>
                            <td><?= htmlspecialchars($stats[0]['stats_totales']['appelsKO'] ?? '0') ?></td>
                            <td><?= htmlspecialchars($stats[0]['stats_totales']['timeouts'] ?? '0') ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Aucune statistique à afficher.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>