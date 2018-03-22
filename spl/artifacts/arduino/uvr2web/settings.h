/**
 * uvr2web (www.uvr2web.de)
 * =======
 *
 * Benutzerdefinierte Einstellungen
 * Elias Kuiter (2018)
 */

// -------- Einstellungen --------

// Hier wird der Typ deiner UVR-Regelung eingetragen.

#define {{device}}

// Wenn WEB definiert ist, wird der Webupload (web.h/web.ino) kompiliert und mit
// den unten angegebenen Einstellungen eingeschaltet. Ansonsten werden die
// ausgelesenen Informationen auf der seriellen Schnittstelle ausgegeben.

{{web}}

// wenn USINGPC definiert ist, werden Ausgaben auf der Konsole getätigt.
// Sollte dann eingeschaltet werden, wenn man das Arduino vom PC betreibt.
// Sobald es "im Einsatz" (am Netzteil) ist, sollte es auskommentiert werden.

{{usingpc}}

// Hier werden die Parameter für den Betrieb von uvr2web festgelegt.

const byte dataPin = {{dataPin}}; // Pin mit Datenstrom
// Interrupt für Daten-Pin, siehe:
// http://arduino.cc/en/Reference/AttachInterrupt
const byte interrupt = {{interrupt}};

// Nur anpassen, wenn der DL-Bus von anderer Hardware mitbenutzt wird.
// Wenn nur die UVR-Regelung den DL-Bus benutzt, den Wert nicht verändern.
// Wenn noch andere Hardware den Bus benutzt, Werte wie 100, 200, 500, 1000
// benutzen (viel mehr sollte es nicht werden) und sich die Konsole anschauen.
const int additionalBits = {{additionalBits}};

#ifdef WEB

// MAC-Adresse des Ethernet-Boards
byte mac[] = { {{mac}} };
char server[] = "{{server}}"; // Adresse des Servers (nur IP-Adresse bzw. Hostname)
char script[] = "{{script}}"; // Upload-Skript (http://<host>/.../upload.php)

// Das Upload-Passwort - muss identisch zu dem in der PHP-App sein.
char pass[] = "{{pass}}";

// Wartezeit zwischen zwei Uploads.
// Im Beispiel 7000 ms, also alle 10 Sekunden ein Upload.
// Den gleichen Wert wie in der PHP-App benutzen.
int upload_interval = {{uploadInterval}};

#endif

// -------- Einstellungen Ende --------

#ifdef USINGPC

#define PRINT(...) Serial.print(__VA_ARGS__)
#define PRINTLN(...) Serial.println(__VA_ARGS__)

#else

#define PRINT(...)
#define PRINTLN(...)

#endif

#ifdef WEB

#define CONNECT(...) client.connect(__VA_ARGS__)
#define CPRINTLN(...) client.println(__VA_ARGS__)
#define CPRINT(...) client.print(__VA_ARGS__)
#define WORKING working()

#else

#define CONNECT(...) true
#define CPRINTLN(...) PRINTLN(__VA_ARGS__)
#define CPRINT(...) PRINT(__VA_ARGS__)
#define WORKING false

// Dummy-Werte, falls Web-Upload nicht eingeschaltet
byte mac[] = {};
char server[] = "";
char script[] = "";
char pass[] = "";
int upload_interval = 0;

#endif

// Definiere Konstanten, abhängig von der UVR-Regelung:

#ifdef UVR1611

// Pulsweite bei 488hz: 1000ms/488 = 2,048ms = 2048µs
// 2048µs / 2 = 1024µs (2 Pulse für ein Bit)
const unsigned long pulse_width = 1024; // µs

// % Toleranz für Abweichungen bei der Pulsweite
const int percentage_variance = 10;

// ein Datenrahmen hat 64 Datenbytes
const int byte_number = 64;

// die Gerätekennung eines Datenrahmens überprüfen
boolean check_device(byte* frame) {
  if (frame[0] == 0x80 && frame[1] == 0x8f) {
    PRINTLN("Die Netzwerkeingänge der UVR1611 werden nicht unterstützt und ignoriert.");
    return false;
  }
  byte checksum = 0;
  for (int i = 0; i < 63; i++)
    checksum += frame[i];
  return frame[0] == 0x80 && frame[1] == 0x7f && // Gerätekennung
    frame[63] == checksum; // Prüfsumme
}

#else

#error "kein Regelungstyp definiert, überprüfe Einstellungen oben!"

#endif

// 8 Datenbits, jeweils 1 Start-/Stopbit, 16 Bit SYNC, byte_number Datenbytes
// von der UVR (siehe "DL-Bus.pdf")
// (das Doppelte eines Datenrahmens wird gespeichert, so dass definitiv
// ein ganzer Datenrahmen da ist)
const int bit_number = (byte_number * (8 + 1 + 1) + 16) * 2 + additionalBits;
