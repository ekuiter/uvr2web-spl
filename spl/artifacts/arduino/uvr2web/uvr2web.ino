/**
 * uvr2web (www.uvr2web.de)
 * =======
 *
 * Zustandsmaschine für Empfangen und Verarbeiten
 * Elias Kuiter (2018)
 */

#include <SPI.h>
#include <Ethernet.h>
#include <stdint.h>
#include <avr/wdt.h>

#include "settings.h"
#include "receive.h"
#include "process.h"
#include "web.h"

// Wir benutzen einen "Watchdog", der das Board automatisch
// neu startet, falls es abstürzt (d.h. innerhalb von 8 Sekunden
// den Watchdog-Timer nicht zurücksetzt).
uint8_t mcusr_mirror __attribute__ ((section (".noinit")));
void get_mcusr(void) __attribute__((naked)) __attribute__((section(".init3")));

void get_mcusr(void) {
  mcusr_mirror = MCUSR;
  MCUSR = 0;
  wdt_disable();
}

 void setup() {
  wdt_enable(WDTO_8S);

#ifdef USINGPC
  Serial.begin(115200);
#endif

#ifdef WEB
  Web::start();
#endif

  Receive::start();
}

void loop() {
  wdt_reset();
  
  if (!Receive::receiving) {
    Process::start(); // Daten auswerten
    Receive::start(); // Daten sammeln
  }
}
