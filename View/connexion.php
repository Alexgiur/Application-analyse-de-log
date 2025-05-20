<div class="page-wrapper d-flex flex-column min-vh-100">
    <header id="head">
        <h2 class="alert alert-warning">Connexion</h2>
    </header>
    <br>
    <?php if($message_erreur != '')
        echo "<div class=\"text-center alert alert-danger errorMessage\">$message_erreur</div>";
    ?>
    <form method="post" action="index.php">
        <table>
            <tr class="input-box">
                <td colspan="3"><input type="text" name="id" min="0" placeholder="Identifiant" /></td>
            </tr>

            <tr class="input-box">
                <td colspan="3"><input type="text" name="nom" placeholder="Nom" /></td>
            </tr>

            <tr class="input-box">
                <td colspan="3"><input type="password" name="motdepasse" placeholder="Mot de passe" /></td>
            </tr>

            <tr>
                <td><br><input class="btn btn-warning" name="btnErase" type="reset" value="Effacer" /></td>
                <td><br><input class="btn btn-primary" name="btnConnexion" type="submit" value="Connexion" /></td>
            </tr>
        </table>
    </form>