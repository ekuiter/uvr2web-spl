<?php

class Loc {
    protected function get_default_language() {
        return "fr";
    }

    public function get_language_options() {
        return parent::get_language_options()
            . "<option value=\"fr\" " . (Loc::get_language() == 'fr' ? ' selected' : '') . ">" . Loc::t('french') . "</option>";
    }
    
    protected function get_translations() {
        return array_merge(parent::get_translations(), array(
            "fr" => array(
                'status' => 'Statut',
                'sensor' => 'Capteur',
                'sensors' => 'Capteurs',
                'outputs' => 'Sorties',
                'output' => 'Sortie',
                'heat meter' => 'Compteur de chaleur',
                'heat meters' => 'Compteurs de chaleur',
                'speed step' => 'Palier de vitesse',
                'speed steps' => 'Paliers de vitesse',
                'admin' => 'Admin',
                'logout' => 'Se déconnecter',
                'about' => 'Plus d\'informations sur '.$GLOBALS['brand'].'',
                'docs' => 'Documentation',
                'imprint' => 'Mentions légales',
                'user' => 'Utilisateur',
                'users' => 'Utilisateurs',
                'overview' => 'Vue d\'ensemble',
                'admin body' => 'Sur la gauche tu peux consulter autres paramètres.',
                'change aliases' => 'Changer des désignations',
                'change order' => 'Changer d\'ordre',
                'here you can' => 'Ici tu peux changer les désignations des éléments dans',
                'specified order' => 'l\'ordre indiqué',
                'here you can 2' => '',
                'here you can heat meters' => 'Ici tu peux changer les désignations des compteurs de chaleur actifs.',
                'save' => 'Enregistrer',
                'cancel' => 'Annuler',
                'all aliases' => 'Toutes les désignations étaient enregistrés.',
                'drag to' => 'Pour agencer des éléments tu peux les déplacer avec la souris. Les changements sont enregistrés automatique.',
                'add separator' => 'Ajouter séparateur',
                'name separators' => 'Te peux nommer les séparateurs',
                'here' => 'ici',
                'name separators 2' => '',
                'group' => 'Groupe',
                'add user' => 'Ajouter utilisateur',
                'username' => 'Nom d\'utilisateur',
                'password hash' => 'Mot de passe (hash)',
                'role' => 'Autorisations',
                'password' => 'Mot de passe',
                'password confirmation' => 'Valider mot de passe',
                'edit' => 'Modifier',
                'remove' => 'Effacer',
                'language' => 'Langue',
                'english' => 'Anglais',
                'german' => 'Allemande',
                'french' => 'Français',
                'admin deleted' => 'Admin effacé avec succès.',
                'user deleted' => 'Utlilisateur effacé avec succès.',
                'last admin' => 'Le dernier admin ne peut pas être effacé.',
                'remove 1' => 'Est-ce que tu veux vraiment effacer ',
                'remove 2' => '?',
                'remove 3' => 'Tu ne peut pas rapporter ça.',
                'remove 4' => 'Effacer ',
                'remove 5' => '',
                'sure' => 'Je suis sûr',
                'passwords dont match' => 'Les mots de passe ne corrrespondent pas.',
                'edit 1' => '',
                'edit 2' => ' enregistré avec succès.',
                'edit 3' => 'Modifier',
                'edit 4' => '',
                'add 1' => 'Le nouveau utilisateur <em>dummy</em> était crée. Change le nom d\'utilisateur et le mot de passe.',
                'add 2' => 'Ajouter un utilisateur est échoué. Est-ce que l\'utilisateur <em>dummy</em> existe déjà?',
                'current power' => 'Puissance instantanée',
                'kwh' => 'kWh',
                'mwh' => 'MWh',
                'log in' => 'S\'inscrire',
                'login incorrect' => 'Données d\'accès fausses.',
                'smallest value' => 'Plus petite mesure',
                'highest value' => 'Plus grande mesure',
                'notifications' => 'Notifications',
                'email' => 'Adresse électronique',
                'emails' => 'Adresses électroniques',
                'comma-separated' => '(séparés par des virgules)',
                'notifications body' => 'Des notifications sont envoyées à tes adresses électroniques. Elles contiennent d\'informations d\'état ou des problèmes possibles.',
                'notifications body 2' => 'Informer si aucunes informations n\'étaient téléchargé depuis ',
                'notifications body 3' => ' minutes.',
                'notifications body 4' => 'Rappeler tous les ',
                'notifications body 5' => ' jours qu\'une copie de sauvegarde doit être crée.',
                'data record' => 'Nouveau enregistrement sauvegardé!',
                'md5 hash' => 'Somme de contrôle (MD5)',
                'frames uploaded' => 'cadre d\'informations téléchargé',
                'frames until' => 'cadre d\'informations jusqu\'au prochain cadre d\'informations (~',
                'frames until 2' => ' minutes)',
                'current data frame' => 'Actuel cadre d\'informations',
                'last data record' => 'Dernier cadre d\'informations du ',
                'last data record 2' => ' à ',
                'last data record 3' => '',
                'upload issues' => 'Problèmes à tèlècharger',
                'notification' => ''.$GLOBALS['brand'].' notification',
                'no upload notification body' => 'Apparemment il y a des problèmes à tèlècharger avec ton installation de '.$GLOBALS['brand'].'.',
                'no upload notification body 2' => 'Il y a plus que',
                'no upload notification body 3' => 'minutes que le dernier cadre d\'informations était téléchargé (le ',
                'no upload notification body 4' => 'à',
                'no upload notification body 5' => 'Assure-toi que la carte est raccordé.',
                'notification footer' => 'Tu as reçu cet e-mail parce que tu as activé l\'option correspondante',
                'notification footer 2' => 'ici',
                'notification footer 3' => '.',
                'notification footer 4' => 'Ne réponds pas à cet e-mail. Il était généré automatique.',
                'backup notification' => 'Copie de sauvegarde',
                'backup notification body' => 'La dernière copie de sauvegarde de '.$GLOBALS['brand'].' était il y a',
                'backup notification body 2' => 'jours.',
                'backup notification body 3' => 'Ici',
                'backup notification body 4' => 'tu peux télécharger la plus nouvelle copie de sauvegarde.',
                'backup' => 'Copie de sauvegarde',
                'do backup' => 'Créer une copie de sauvegarde',
                'backup body' => 'La copie de sauvegarde comprend tous les tableaux de la base de données de '.$GLOBALS['brand'].'.
    <ul>
    <li>Paramètres</li>
    <li>Cadres d\'informations</li>
    <li>Utilisateurs</li>
    </ul>
    Elle peut être restauré de nouveau pendant l\'installation de '.$GLOBALS['brand'].'.',
                'uninstall' => 'Désinstaller',
                'uninstall uvr2web' => 'Désinstaller '.$GLOBALS['brand'].'',
                'uninstall body' => '<p><strong>C\'est dommage que tu veux désinstaller '.$GLOBALS['brand'].' :(</strong></p>
    <p>Dis-moi pourquoi <a href="mailto:info@elias-kuiter.de">ici</a> pour que je peux améliorer '.$GLOBALS['brand'].'.</a></p>
      <p>La désinstallation a deux pas:</p>
    <ol>
    <li>Effacer les tableaux de la base de données</li>
    <li>Effacer les fichiers</li>
    </ol>
    <p>
    '.$GLOBALS['brand'].' peut accomplir pas 1 pour toi.<br />
    Mais effacer les fichiers sur le serveur ensuite, c\'est à toi.
    <p>C\'est recommandé de créer une <a href="index.php?p=admin&sub=backup">copie de sauvegarde</a> avant la désinstallation.</p>',
                'uninstall backup' => 'Veux-tu créer une copie de sauvegarde avant la désinstallation?\nSi tu l\'as fait déjà, clique Annuler.',
                'uninstall sure' => 'Es-tu VRAIMENT SÛR que tu veux désinstaller '.$GLOBALS['brand'].'?',
                'uninstall body 2' => 'Les tableaux de la base de données étaient effacés.<br />
    '.$GLOBALS['brand'].' est desactivé.</p>
    <p>Maintenant, efface les fichiers sur le serveur:</p>
    <ol>
    <li>Ouvre ta logiciel de FTP (par exemple <a href="http://sourceforge.net/projects/filezilla/" target="_blank">Filezilla</a>).</li>
    <li>Raccorde à ce serveur.</li>
    <li>Efface le classeur « '.$GLOBALS['brand'].' ».</li>
    </ol>',
                'no data frames' => '<h4>Aucuns cadres d\'informations!</h4>
    Il n\'y a aucuns cadres d\'informations dans la base de données.<br />
    Occupe-toi de la configuration correcte de la carte.<br />
    Si tout fonctionne, cet avertissement disparaîtra si tu actualise la page dans ~',
                'no data frames 2' => ' secondes.',
                'months' => array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'),
                'object removed' => 'Objet effacé avec succès.',
                'object enabled' => 'Objet activé avec succès.',
                'disabled' => 'est desactivé',
                'enable' => 'activer',
                'status ok' => 'Tout est bien!',
                'status failed' => 'Problèmes avec le téléchargement!',
                'no data' => 'Aucune donnée pour ce mois!',
                'day' => 'Jour',
                'week' => 'Semaine',
                'month' => 'Mois',
                'all' => 'Tous',
            )));
    }
}

?>