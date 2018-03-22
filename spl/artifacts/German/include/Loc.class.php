<?php

class Loc {
    protected function get_default_language() {
        return "de";
    }

    public function get_language_options() {
        return parent::get_language_options()
            . "<option value=\"de\" " . (Loc::get_language() == 'de' ? ' selected' : '') . ">" . Loc::t('german') . "</option>";
    }
    
    protected function get_translations() {
        return array_merge(parent::get_translations(), array(
            "de" => array(
                'status' => 'Status',
                'sensor' => 'Sensor',
                'sensors' => 'Sensoren',
                'outputs' => 'Ausgänge',
                'output' => 'Ausgang',
                'heat meter' => 'Wärmemengenzähler',
                'heat meters' => 'Wärmemengenzähler',
                'speed step' => 'Drehzahlstufe',
                'speed steps' => 'Drehzahlstufen',
                'admin' => 'Admin',
                'logout' => 'Abmelden',
                'about' => 'Über '.$GLOBALS['brand'],
                'docs' => 'Dokumentation',
                'imprint' => 'Impressum',
                'user' => 'Benutzer',
                'users' => 'Benutzer',
                'overview' => 'Übersicht',
                'admin body' => 'Auf der linken Seite kannst du weitere Einstellungen abrufen.',
                'change aliases' => 'Bezeichnungen ändern',
                'change order' => 'Reihenfolge ändern',
                'here you can' => 'Hier kanst du die Bezeichnungen für die Elemente in der',
                'specified order' => 'angegebenen Reihenfolge',
                'here you can 2' => ' ändern',
                'here you can heat meters' => 'Hier kannst du die Bezeichnungen für die aktiven Wärmemengenzähler ändern.',
                'save' => 'Speichern',
                'cancel' => 'Abbrechen',
                'all aliases' => 'Alle Bezeichnungen wurden gespeichert.',
                'drag to' => 'Um Elemente neu anzuordnen, kannst du sie mit der Maus verschieben. Die Änderungen werden automatisch gespeichert.',
                'add separator' => 'Trenner hinzufügen',
                'name separators' => 'Du kannst die Trenner',
                'here' => 'hier',
                'name separators 2' => ' benennen',
                'group' => 'Gruppe',
                'add user' => 'Benutzer hinzufügen',
                'username' => 'Benutzername',
                'password hash' => 'Passwort-Hash',
                'role' => 'Berechtigungen',
                'password' => 'Passwort',
                'password confirmation' => 'Passwort bestätigen',
                'edit' => 'Bearbeiten',
                'remove' => 'Löschen',
                'language' => 'Sprache',
                'english' => 'Englisch',
                'german' => 'Deutsch',
                'french' => 'Französisch',
                'admin deleted' => 'Admin erfolgreich gelöscht.',
                'user deleted' => 'Benutzer erfolgreich gelöscht.',
                'last admin' => 'Der letzte Admin kann nicht gelöscht werden.',
                'remove 1' => 'Willst du ',
                'remove 2' => ' wirklich löschen?',
                'remove 3' => 'Dies kannst du nicht rückgängig machen.',
                'remove 4' => '',
                'remove 5' => ' löschen',
                'sure' => 'Löschen',
                'passwords dont match' => 'Die Passwörter stimmen nicht überein.',
                'edit 1' => '',
                'edit 2' => ' erfolgreich gespeichert.',
                'edit 3' => '',
                'edit 4' => ' bearbeiten',
                'add 1' => 'Neuer Benutzer <em>dummy</em> wurde erstellt. Bitte ändere Benutzernamen und Passwort.',
                'add 2' => 'Benutzer hinzufügen fehlgeschlagen. Gibt es den Benutzer <em>dummy</em> schon?',
                'current power' => 'Momentanleistung',
                'kwh' => 'kWh',
                'mwh' => 'MWh',
                'log in' => 'Anmelden',
                'login incorrect' => 'Falsche Zugangsdaten.',
                'smallest value' => 'Kleinster Messwert',
                'highest value' => 'Größter Messwert',
                'notifications' => 'Benachrichtigungen',
                'email' => 'E-Mail-Adresse',
                'emails' => 'E-Mail-Adressen',
                'comma-separated' => '(kommagetrennt)',
                'notifications body' => 'Benachrichtigungen werden an deine E-Mail-Adressen versendet. Sie enthalten Statusinformationen oder mögliche Probleme.',
                'notifications body 2' => 'Benachrichtigen, wenn seit ',
                'notifications body 3' => ' Minuten keine Daten mehr hochgeladen wurden.',
                'notifications body 4' => 'Alle ',
                'notifications body 5' => ' Tage erinnern, dass eine Sicherung erstellt werden sollte.',
                'data record' => 'Neuer Datensatz gespeichert!',
                'md5 hash' => 'MD5-Prüfsumme',
                'frames uploaded' => 'Datenrahmen hochgeladen',
                'frames until' => 'Datenrahmen bis zum nächsten Datensatz (~',
                'frames until 2' => ' Minuten)',
                'current data frame' => 'Aktueller Datenrahmen',
                'last data record' => 'Letzter Datensatz vom ',
                'last data record 2' => ' um ',
                'last data record 3' => ' Uhr',
                'upload issues' => 'Upload-Probleme',
                'notification' => ''.$GLOBALS['brand'].' Benachrichtigung',
                'no upload notification body' => 'Anscheinend gibt es Upload-Probleme mit deiner '.$GLOBALS['brand'].'-Installation.',
                'no upload notification body 2' => 'Der letzte Datenrahmen wurde vor mehr als',
                'no upload notification body 3' => 'Minuten hochgeladen (am',
                'no upload notification body 4' => 'um',
                'no upload notification body 5' => 'Wenn du nicht eingreifst, werden <strong>keine neuen Daten mehr zu '.$GLOBALS['brand'].' hochgeladen</strong>.<br />
    Gehe bitte sicher, dass das Gerät korrekt verbunden ist.',
                'notification footer' => 'Du hast diese E-Mail erhalten, weil du die entsprechende Option',
                'notification footer 2' => 'hier',
                'notification footer 3' => ' aktiviert hast.',
                'notification footer 4' => 'Bitte antworte nicht auf diese E-Mail. Sie wurde automatisch generiert.',
                'backup notification' => 'Sicherung',
                'backup notification body' => 'Die letzte Sicherung von '.$GLOBALS['brand'].' ist',
                'backup notification body 2' => 'Tage her.',
                'backup notification body 3' => 'Hier',
                'backup notification body 4' => 'kannst du die neueste Sicherung herunterladen.',
                'backup' => 'Sicherung',
                'do backup' => 'Sicherung erstellen',
                'backup body' => 'Die Sicherung umfasst alle Datenbanktabellen von '.$GLOBALS['brand'].'.
    <ul>
    <li>Einstellungen</li>
    <li>Datenrahmen</li>
    <li>Benutzer</li>
    </ul>
    Sie kann während der Installation von '.$GLOBALS['brand'].' wieder eingespielt werden.',
                'uninstall' => 'Deinstallieren',
                'uninstall uvr2web' => ''.$GLOBALS['brand'].' deinstallieren',
                'uninstall body' => '<p><strong>Schade, dass du '.$GLOBALS['brand'].' deinstallieren willst :(</strong></p>
    <p>Teile mir <a href="mailto:info@elias-kuiter.de">hier</a> doch bitte mit, warum, damit ich das Programm verbessern kann.</a></p>
    <p>Die Deinstallation besteht aus zwei Schritten:</p>
    <ol>
    <li>Löschen der Datenbanktabellen</li>
    <li>Löschen der Dateien</li>
    </ol>
    <p>
    Schritt 1 kann '.$GLOBALS['brand'].' für dich erledigen.<br />
    Das Löschen der Dateien auf dem FTP-Server musst du danach hingegen selbst durchführen.
    <p>Es wird empfohlen, vor der Deinstallation eine <a href="index.php?p=admin&sub=backup">Sicherung</a> zu erstellen.</p>',
                'uninstall backup' => 'Willst du vor der Deinstallation noch eine Sicherung erstellen?\nWenn du dies bereits getan hast, klicke auf Abbrechen.',
                'uninstall sure' => 'Bist du WIRKLICH SICHER, dass du '.$GLOBALS['brand'].' deinstallieren willst?',
                'uninstall body 2' => 'Die Datenbanktabellen wurden gelöscht.<br />
    '.$GLOBALS['brand'].' ist nun deaktiviert.</p>
    <p>Lösche jetzt bitte die Dateien auf dem FTP-Server:</p>
    <ol>
    <li>Öffne deinen FTP-Client (z.B. <a href="http://sourceforge.net/projects/filezilla/" target="_blank">Filezilla</a>).</li>
    <li>Verbinde dich auf diesen Server.</li>
    <li>Lösche den '.$GLOBALS['brand'].'-Ordner.</li>',
                'no data frames' => '<h4>Keine Datenrahmen!</h4>
    Es sind keine Datenrahmen in der Datenbank.<br />
    Sorge dafür, dass das Gerät richtig verbunden ist.<br />
    Wenn alles funktioniert, sollte diese Warnung verschwinden, sobald du die Seite in ~',
                'no data frames 2' => 'Sekunden neu lädst.',
                'months' => array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'),
                'object removed' => 'Objekt erfolgreich entfernt.',
                'object enabled' => 'Objekt erfolgreich aktiviert.',
                'disabled' => 'ist deaktiviert',
                'enable' => 'aktivieren',
                'status ok' => 'Alles in Ordnung!',
                'status failed' => 'Upload-Probleme!',
                'no data' => 'Keine Daten für diesen Monat!',
                'day' => 'Tag',
                'week' => 'Woche',
                'month' => 'Monat',
                'all' => 'Alles',
            )));
    }
}

?>