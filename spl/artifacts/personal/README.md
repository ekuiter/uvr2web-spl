## uvr2web

**uvr2web ist ein Programm zur Überwachung deiner Heizungsregelung.**

Es kann Temperaturdaten visualisieren, diese auf deinem PC oder Smartphone
darstellen und vieles mehr. Mehr Informationen findest du auf http://uvr2web.de.

Das Programm besteht aus mehreren Teilen:

**Arduino-Sketch**

Der Arduino-Sketch kommuniziert mit der UVR-Regelung. Dafür brauchst du
natürlich ein Arduino-Board. Getestet wurde mit dem Arduino Leonardo und Uno.

Andere Boards wurden nicht getestet, sind aber prinzipiell möglich.

Außerdem musst du ein einfaches Arduino-Shield löten, einen Spannungsteiler (s.
unten).

Die UVR-Regelung gibt ihre Daten mittels eines Manchester-Codes aus. Der Sketch
dekodiert dieses Signal und schickt die Daten dann entweder an einen PC über
eine serielle Verbindung oder über Ethernet an die uvr2web-Datenbank. Die
Web-Anbindung benötigt ein Ethernet-Shield.

**Datenbank**

Falls du die mitgelieferte Datenbank verwenden möchtest, benötigst du einen
PHP-Server mit GD-Library und eine MySQL-Datenbank. Die Datenbank empfängt die
Daten vom Arduino-Board und speichert sie ab. Danach hast du einige
Möglichkeiten: Graphen anzeigen, Daten herunterladen, eine Live-Übersicht
abrufen und vieles mehr.

## Erste Schritte

**Verbindung zur Regelung**

Nachdem du uvr2web heruntergeladen hast, befindet sich im Ordner
`arduino/uvr2web` der Arduino-Sketch und in `database` die Serversoftware.

Zunächst musst du einen Spannungsteiler löten, der die Ausgabespannung der Regelung
auf eine 5V-Spannung reduziert. Wenn du dabei Hilfe brauchst, kontaktiere
mich: http://www.elias-kuiter.de/apps/uvr2web/troubleshooting

Beachte dazu unbedingt Seite 17 in der DL-Bus-Spezifikation
(`arduino/DL-Bus.pdf`), um die richtige Schaltung für deine Regelung
herauszufinden.

Hier ein einfaches Schaltbild von dem Spannungsteiler, den ich an meiner UVR1611
benutze. *Dieses Schaltbild gilt nur für die Reglertypen UVR1611, UVR61-3 und
ESR21. Siehe ggf. in der DL-Bus-Spezifikation nach!*

```
+---------------------+                  
|                     |                  
|       UVR1611       |                  
|                     |                  
|   DL-Bus            |                  
|   12 V        GND   |                  
+-----+----------+----+                  
      |          |                       
   +--+--+       |       +--------------+
   | R1  |       |       | Beispiel für |
   +--+--+       |       | Widerstände: |
      |          |       |              |
      |  +-----+ |       | R1 = 3620 Ω  |
      +--+ R2  +-+       | R2 = 3300 Ω  |
      |  +-----+ |       +--------------+
      |          |                       
      |          |                       
+-----+----------+----+                  
|    Pin        GND   |                  
|    5 V              |                  
|                     |                  
|       Arduino       |                  
|                     |                  
+---------------------+
```

Beachte auch, dass die echte Ausgangsspannung der Regelung auch durchaus von der
Spezifikation abweichen kann, z.B. bei einer langen Datenleitung. Nachmessen mit
einem Multimeter kann da helfen. Lies gegebenenfalls die Hinweise von TA zum
DL-Bus: http://help.ta.co.at/DE/CMIHELP/dl_bus.htm - diese beziehen sich auf
das C.M.I., sind aber auch für uvr2web anwendbar.

**Arduino**

Falls du den Arduino-Sketch noch nicht konfiguriert hast, solltest du das jetzt
tun. In der Datei `arduino/uvr2web/settings.h` gibt es einige
Einstellungsmöglichkeiten, je nachdem, ob du die Daten ins Internet hochladen
möchtest oder nicht. Genaueres findest du in den Kommentaren.

Wenn du bereit bist, lade den Sketch hoch und schließe die Regelung am richtigen
Pin an. Nur wenn die USINGPC-Einstellung aktiviert ist, werden auch Ausgaben auf
dem Serial Monitor getätigt! Im Produktivbetrieb (am Netzteil) solltest du diese
Option durch Einfügen von `//` wieder ausschalten. (Hintergrund ist, dass die
Ausgabe im Serial Monitor den Datenempfang von der Regelung fehlerhafter macht.)

Falls du Ausgaben wie

```
Empfange ... 
Empfangen. 
Upload ...
Upload abgeschlossen.

Empfange ... 
Empfangen. Datenrahmen beschädigt.
Empfange ... 
Empfangen. 
Upload ...
Upload abgeschlossen.
```

erhältst, sehr gut! (Dass ein `Datenrahmen beschädigt` ist, kann schon einmal
vorkommen, ist aber nicht weiter schlimm, da sofort ein neuer Datenrahmen
mitgeschnitten wird.)

Wenn du die Meldung `DHCP fehlgeschlagen.` erhältst, überprüfe deine MAC-Adresse
und ob dein Board korrekt mit dem Internet verbunden ist.

Falls der Datenempfang von der Regelung scheitert, melde dich
(http://www.elias-kuiter.de/apps/uvr2web/troubleshooting) und ich werde
versuchen, dir zu helfen.

**Datenbank**

Als nächstes kannst du die PHP-App auf deinem Server installieren. Lade dazu die
PHP-Dateien im Ordner `database` auf den Server hoch, öffne dann das
`install.php`-Skript in deinem Browser und befolge die Anweisungen.

Achte hier darauf, dass im Arduino-Sketch das gleiche Upload-Passwort und
-Intervall eingestellt sind wie in der PHP-App und dass der Server richtig
eingestellt ist. Nun kann dein Arduino-Board Sensordaten hochladen.

Wenn alles funktioniert hat, solltest du nach dem Login eine Seite namens
`Sensors` sehen, die dir einen Überblick über die Sensordaten gibt.

## Dokumentation

Der Arduino-Sketch und die Datenbank haben Inline-Kommentare, die zur
Dokumentation dienen. Im `arduino`-Ordner findest du die DL-Bus-Spezifikation,
die Grundlage für die Kommunikation mit der Regelung ist.