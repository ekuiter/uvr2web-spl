/**
 * uvr2web (www.uvr2web.de)
 * =======
 *
 * Verarbeitung der gespeicherten Datenrahmen
 * Elias Kuiter (2018)
 */

namespace Process {

  byte data_bits[bit_number / 8 + 1]; // jedes Bit wird in eine Bitmap einsortiert
  int start_bit; // erstes Bit des Datenrahmens
  
  // Sensortypen
#define UNUSED      0b000
#define DIGITAL     0b001
#define TEMP        0b010
#define VOLUME_FLOW 0b011
#define RAYS        0b110
#define ROOM        0b111

  // Modi für Raumsensor
#define AUTO        0b00
#define NORMAL      0b01
#define LOWER       0b10
#define STANDBY     0b11

  // Zeitstempel der Regelung
  typedef struct {
    byte minute;
    byte hour;
    byte day;
    byte month;
    int year;
    boolean summer_time;
  } 
  timestamp_t;
  timestamp_t timestamp;

  // Sensor
  typedef struct {
    byte number;
    byte type;
    byte mode;
    boolean invalid;
    int value;
  }
  sensor_t;
  sensor_t sensor;

  // Wärmemengenzähler
  typedef struct {
    byte number;
    boolean invalid;
    int current_power;
    int kwh;
    int mwh;
  }
  heat_meter_t;
  heat_meter_t heat_meter;

  // Datenrahmen
  void start(); // Datenrahmen auswerten
  void debug(); // Datenrahmen "roh" ausgeben
  boolean prepare(); // Datenrahmen vorbereiten
  int analyze(); // Datenrahmen analysieren
  void invert(); // Datenrahmen invertieren
  byte read_bit(int pos); // aus Bitmap lesen
  void write_bit(int pos, byte set); // Bitmap beschreiben
  void trim(); // Datenrahmen in Bitmap schreiben

  // Informationen auslesen
  void fetch_sensor(int sensor); // Sensor
  void fetch_heat_meter(int heat_meter); // Wärmemengenzähler
  boolean fetch_output(int output); // Ausgang
  int fetch_speed_step(int output); // Drehzahlstufe

}
