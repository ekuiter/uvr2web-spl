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

// Arten von Messgeräten bei dieser Regelung
const int sensor_number = 16;
const int sensor_offset = 9;
#define SENSOR_WITH_TYPE
const int output_number = 13;
const int output_offset = 41;
const int output_bit_offset = 0;
const int heat_meter_number = 2;
const int speed_step_number = 4;
const char speed_step_outputs[speed_step_number] = { 1, 2, 6, 7 };

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

#elif defined(UVR16x2)

// Diese Regelung scheint mehr oder weniger mit der UVR1611
// kompatibel zu sein. Die Unterstützung ist aber experimentell.
// Falls jemand nähere Informationen zu dieser Regelung hat,
// teile es mir gerne mit: info@elias-kuiter.de

const unsigned long pulse_width = 980; // Pulsweite scheint leicht abzuweichen
const int percentage_variance = 10;
const int byte_number = 64; // ?
const int sensor_number = 16;
const int sensor_offset = 9;
#define SENSOR_WITH_TYPE
const int output_number = 13;
const int output_offset = 41;
const int output_bit_offset = 0;
const int heat_meter_number = 2;
const int speed_step_number = 4;
const char speed_step_outputs[speed_step_number] = { 1, 2, 6, 7 };

boolean check_device(byte* frame) {
  // ?
}

#elif defined(UVR31)

const unsigned long pulse_width = 10000;
const int percentage_variance = 10;
const int byte_number = 8;
const int sensor_number = 3;
const int sensor_offset = 2;
#define SENSOR_WITHOUT_TYPE
const int output_number = 1;
const int output_offset = 8;
const int output_bit_offset = 5;
const int heat_meter_number = 0;
const int speed_step_number = 0;
const char speed_step_outputs[0];

boolean check_device(byte* frame) {
  return frame[0] == 0x30;
}

#elif defined(UVR42)

const unsigned long pulse_width = 10000;
const int percentage_variance = 10;
const int byte_number = 10;
const int sensor_number = 4;
const int sensor_offset = 2;
#define SENSOR_WITHOUT_TYPE
const int output_number = 2;
const int output_offset = 10;
const int output_bit_offset = 5;
const int heat_meter_number = 0;
const int speed_step_number = 0;
const char speed_step_outputs[0];

boolean check_device(byte* frame) {
  return frame[0] == 0x10;
}

#elif defined(UVR64)

const unsigned long pulse_width = 10000;
const int percentage_variance = 10;
const int byte_number = 14;
const int sensor_number = 6;
const int sensor_offset = 2;
#define SENSOR_WITHOUT_TYPE
const int output_number = 4;
const int output_offset = 14;
const int output_bit_offset = 4;
const int heat_meter_number = 0;
const int speed_step_number = 0;
const char speed_step_outputs[0];

boolean check_device(byte* frame) {
  return frame[0] == 0x20;
}

#elif defined(HZR65)

const unsigned long pulse_width = 10000;
const int percentage_variance = 10;
const int byte_number = 14;
const int sensor_number = 6;
const int sensor_offset = 2;
#define SENSOR_WITHOUT_TYPE
const int output_number = 5;
const int output_offset = 14;
const int output_bit_offset = 3;
const int heat_meter_number = 0;
const int speed_step_number = 0;
const char speed_step_outputs[0];

boolean check_device(byte* frame) {
  return frame[0] == 0x60;
}

#elif defined(TFM66)

const unsigned long pulse_width = 10000;
const int percentage_variance = 10;
const int byte_number = 14;
const int sensor_number = 6;
const int sensor_offset = 2;
#define SENSOR_WITHOUT_TYPE
const int output_number = 4;
const int output_offset = 14;
const int output_bit_offset = 4;
const int heat_meter_number = 0;
const int speed_step_number = 0;
const char speed_step_outputs[0];

boolean check_device(byte* frame) {
  return frame[0] == 0x40;
}

#else

#error "kein Regelungstyp definiert, überprüfe Einstellungen oben!"

#endif

// 8 Datenbits, jeweils 1 Start-/Stopbit, 16 Bit SYNC, byte_number Datenbytes
// von der UVR (siehe "DL-Bus.pdf")
// (das Doppelte eines Datenrahmens wird gespeichert, so dass definitiv
// ein ganzer Datenrahmen da ist)
const int bit_number = (byte_number * (8 + 1 + 1) + 16) * 2 + additionalBits;
