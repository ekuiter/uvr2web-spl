/**
 * uvr2web (www.uvr2web.de)
 * =======
 *
 * Hochladen der Datenrahmen ins Internet via Ethernet
 * Elias Kuiter (2018)
 */

namespace Web {

  EthernetClient client;
  String request;
  unsigned long upload_finished = 0;

  void start(); // stellt eine Internetverbindung her
  void upload(); // übertragt einen Datenrahmen zum Server
  boolean working(); // wartet auf Abschluss der Übertragung
  void remove_comma();
  void add_float(int value, int digits);
  void flush();

  void sensors(); // Sensoren
  void heat_meters(); // Wärmemengenzähler
  void outputs(); // Ausgänge
  void speed_steps(); // Drehzahlstufen

  // Ausgabe einzelner Elemente
  bool heat_meter();
  bool sensor();
  bool speed_step(int output);
}
