/**
 * uvr2web (www.uvr2web.de)
 * =======
 *
 * Empfangen und Speichern von Datenrahmen der Regelung
 * Elias Kuiter (2018)
 */

namespace Receive {

  void start() {
    pulse_count = got_first = last_bit_change = 0;
    receiving = true;
    PRINT("\nEmpfange ... ");
    // bei einem CHANGE am Daten-Pin wird pin_changed aufgerufen
    attachInterrupt(interrupt, pin_changed, CHANGE);
  }

  void stop() {
    detachInterrupt(interrupt);
    PRINT("\nEmpfangen. ");
    receiving = false;
  }

  void pin_changed() {
    byte val = digitalRead(dataPin); // Zustand einlesen
    unsigned long time_diff = micros() - last_bit_change;
    last_bit_change = micros();
    // einfache Pulsweite?
    if (time_diff >= low_width && time_diff <= high_width) {
      process_bit(val);
      return;   
    }
    // doppelte Pulsweite?
    if (time_diff >= double_low_width && time_diff <= double_high_width) {
      process_bit(!val);
      process_bit(val);
      return;   
    } 
  }

  void process_bit(byte b) {
    // den ersten Impuls ignorieren
    pulse_count++;
    if (pulse_count % 2)
      return;

    if (b)
      Process::data_bits[BIT_COUNT / 8] |= 1 << BIT_COUNT % 8; // Bit setzen
    else
      Process::data_bits[BIT_COUNT / 8] &= ~(1 << BIT_COUNT % 8); // Bit löschen

    if (BIT_COUNT == bit_number)
      stop(); // beende Übertragung, wenn Datenrahmen vollständig
  }

}
