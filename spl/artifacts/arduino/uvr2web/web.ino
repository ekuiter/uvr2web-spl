/**
 * uvr2web (www.uvr2web.de)
 * =======
 *
 * Hochladen der Datenrahmen ins Internet via Ethernet
 * Elias Kuiter (2018)
 */

namespace Web {

  void start() {
    PRINTLN("Initialisiere ...");
    if (Ethernet.begin(mac) == 0) {
      PRINTLN("DHCP fehlgeschlagen.");
      Receive::stop();
      while(1);
    }
  }

  void upload() {
    while (millis() - upload_finished < upload_interval)
      wdt_reset();
    if (CONNECT(server, 80)) {
      PRINTLN("\nUpload ...");
      request = "GET ";
      request += script;
      request += "?pass=";
      request += pass;
      request += "&frame={";
      
      if (sensor_number > 0) {
        request += "\"sensors\":[";
        sensors();
        remove_comma();
        request += "],";
      }

      if (heat_meter_number > 0) {
        request += "\"heat_meters\":[";
        heat_meters();
        remove_comma();
        request += "],";
      }

      if (output_number > 0) {
        request += "\"outputs\":[";
        outputs();
        remove_comma();
        request += "],";
      }

      if (speed_step_number > 0) {
        request += "\"speed_steps\":[";
        speed_steps();
        remove_comma();
        request += "],";
      }

      remove_comma();
      request += "} HTTP/1.0";
      CPRINTLN(request);
      CPRINTLN();
      while (WORKING);
      upload_finished = millis();
    } 
    else {
      PRINTLN("Server-Verbindung fehlgeschlagen.");
      while (1);
    }
  }

  void remove_comma() {
    if (request.length() == 0)
      return;
    int lastChar = request.length() - 1;
    if (request.charAt(lastChar) == ',')
      request.remove(lastChar);
  }

  void add_float(int value, int digits) {
    if (digits != 2 && digits != 3)
      return;
    if (value < 0) {
      request += "-";
      value *= -1;
    }
    int div = (digits == 2 ? 10 : 100);
    request += value / div;
    request += ".";
    if (digits == 3 && value % 100 < 10)
      request += "0";
    request += value % div;
  }

  boolean working() {
    while (client.available())
      client.read();
    if (!client.connected()) {
      PRINTLN("Upload abgeschlossen.");
      client.stop();
      return false;
    }
    return true;
  }

  void flush() {
    CPRINT(request);
    request = "";
  }

  void sensors() {
    for (int i = 1; i <= sensor_number; i++) {
      Process::fetch_sensor(i);
      if (sensor())
        request += ",";
    }
  }

  bool sensor() {
    if (Process::sensor.invalid)
      return false;
    
    request += "{\"number\":";
    request += Process::sensor.number;
    request += ",\"value\":";
    add_float(Process::sensor.value, 2);
    request += ",\"type\":\"";

    byte type = Process::sensor.type;
    if (type == UNUSED)
      request += "unused";
    else if (type == DIGITAL)
      request += "digital";
    else if (type == TEMP)
      request += "temperature";
    else if (type == VOLUME_FLOW)
      request += "volume%20flow";
    else if (type == RAYS)
      request += "rays";
    else if (type == ROOM)
      request += "room%20temperature";
    
    if (Process::sensor.type == ROOM) {
      byte mode = Process::sensor.mode;
      request += "\",\"mode\":\"";
      if (mode == AUTO)
        request += "auto";
      else if (mode == NORMAL)
        request += "normal";
      else if (mode == LOWER)
        request += "lower";
      else if (mode == STANDBY)
        request += "standby";
    }
    
    request += "\"}";
    flush();
    return true;
  }

  void heat_meters() {
    for (int i = 1; i <= heat_meter_number; i++) {
      Process::fetch_heat_meter(i);
      if (heat_meter())
        request += ",";
    }
  }

  bool heat_meter() {
    if (Process::heat_meter.invalid)
      return false;
    request += "{\"number\":";
    request += Process::heat_meter.number;
    request += ",\"current_power\":";
    add_float(Process::heat_meter.current_power, 3);
    request += ",\"kwh\":";
    add_float(Process::heat_meter.kwh, 2);
    request += ",\"mwh\":";
    request += Process::heat_meter.mwh;
    request += "}";
    flush();
    return true;
  }

  void outputs() {
    for (int i = 1; i <= output_number; i++) {
      request += "{\"number\":";
      request += i;
      request += ",\"value\":";
      request += Process::fetch_output(i);
      request += "}";
      flush();
      request += ",";
    }
  }

  void speed_steps() {
    for (int i = 1; i <= speed_step_number; i++) {
      if (speed_step(i))
        request += ",";
    }
  }

  bool speed_step(int i) {
    int output = speed_step_outputs[i - 1];
    int speed_step = Process::fetch_speed_step(output);
    if (speed_step == -2 || speed_step == -1)
      return false;    
    request += "{\"output\":";
    request += output;
    request += ",\"value\":";
    request += speed_step;
    request += "}";
    flush();
    return true;
  }

}