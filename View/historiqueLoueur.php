<div class="page-wrapper d-flex flex-column min-vh-100">
    <div class="container-fluid flex-grow-1">
        <div class="row">
            <!-- Sidebar -->
            <div id="side-bar" class="col-12 col-md-3 col-xl-2 bg-dark text-white p-0 d-flex flex-column">
                <nav class="navbar bg-dark border-bottom border-white">
                    <div class="container-fluid">
                        <a id="deco" class="navbar-brand text-white" href="index.php?deco">
                            <i class="bi bi-house-door"></i>
                            <span class="ms-2"><strong>Déconnexion</strong></span>
                        </a>
                    </div>
                </nav>
                <nav class="nav flex-column p-2">
                    <a class="nav-link text-white" href="index.php?historiqueLoueur">
                        <i class="bi bi-speedometer2"></i><span class="ms-2">Historique</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?derniereStatsLoueur">
                        <i class="bi bi-speedometer2"></i><span class="ms-2">Dernière statistiques</span>
                    </a>
                    <a class="nav-link text-white" href="index.php?mesInformations">
                        <i class="bi bi-person-circle"></i><span class="ms-2">Mes informations</span>
                    </a>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-xl-10 bg-white">
                <header>
                    <h2 class="alert alert-warning"><?= htmlspecialchars($_SESSION['loueur_nom']) ?></h2>
                </header>
                <h4 class="text-center mt-4">Historique</h4>
                <?php $logsParDate = [];
                if (!empty($logs)) {
                    foreach ($logs as $log) {
                        $date = date('Y-m-d', strtotime($log['date']));
                        if (!isset($logsParDate[$date])) {
                            $logsParDate[$date] = [
                                'date' => $date,
                                'id' => $log['id'],
                                'nom' => $log['nom'],
                                'appelsKO' => $log['appelsKO'],
                                'timeouts' => $log['timeouts'],
                            ];
                        } else {
                            $logsParDate[$date]['appelsKO'] += $log['appelsKO'];
                            $logsParDate[$date]['timeouts'] += $log['timeouts'];
                        }
                    }
                }
                ?>
                <?php if (!empty($logsParDate)): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Date</th>
                                <th>Erreur KO</th>
                                <th>Erreur Timeouts</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logsParDate as $date => $log): ?>
                                <?php $matchingStat = $statsParDate[$date]?? null; ?>
                                <tr>
                                    <td><?= htmlspecialchars((string) $log['id']) ?></td>
                                    <td><?= htmlspecialchars((string) $log['nom']) ?></td>
                                    <td><?= htmlspecialchars($log['date']) ?></td>
                                    <td><?= htmlspecialchars((string) $log['appelsKO']) ?></td>
                                    <td><?= htmlspecialchars((string) $log['timeouts']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-center">Aucune donnée à afficher.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
