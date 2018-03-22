/**
 * uvr2web (www.uvr2web.de)
 * =======
 *
 * Empfangen und Speichern von Datenrahmen der Regelung
 * Elias Kuiter (2018)
 */

namespace Receive {
  
  // Dekodierung des Manchester-Codes

  // 1001 oder 0110 sind zwei aufeinanderfolgende Pulse ohne Übergang
  const unsigned long double_pulse_width = pulse_width * 2;
  // Berechnung der Toleranzgrenzen für Abweichungen
  const unsigned long low_width =
      pulse_width - (pulse_width * percentage_variance / 100);
  const unsigned long high_width =
      pulse_width + (pulse_width * percentage_variance / 100);
  const unsigned long double_low_width =
      double_pulse_width - (pulse_width * percentage_variance / 100);
  const unsigned long double_high_width =
      double_pulse_width + (pulse_width * percentage_variance / 100);

  boolean got_first = 0; // erster oder zweiter Puls für ein Bit?
  unsigned long last_bit_change = 0; // Merken des letzten Übergangs
  int pulse_count; // Anzahl der empfangenen Pulse
#define BIT_COUNT (pulse_count / 2)
  byte receiving; // Übertragungs-Flag
  
  void start(); // Übertragung beginnen
  void stop(); // Übertragung stoppen
  // wird aufgerufen, sobald sich der Zustand am Daten-Pin ändert
  void pin_changed();
  // speichert ein von pin_changed ermitteltes Bit
  void process_bit(unsigned char b);

}
