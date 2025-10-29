/*
  ===============================================================================
  PROJECT: Fingerprint-Based Access Control & Presence Logger
  ===============================================================================
  
  DESCRIPTION:
    A comprehensive access control system using fingerprint authentication.
    Features two modes: Enrollment (register new fingerprints) and 
    Identification (verify and grant access). Logs presence data to MySQL
    database and validates user subscriptions.
  
  HARDWARE:
    Board:       ESP8266 NodeMCU
    Sensor:      Adafruit Optical Fingerprint Sensor (UART, 57600 baud)
    Display:     I2C 16x2 LCD (address 0x27)
    Actuator:    Servo motor for door/turnstile control
    Input:       Push button for mode switching (Enroll ↔ Identify)
    Indicator:   Status LED
  
  PIN CONFIGURATION (NodeMCU):
    GPIO13 (D7)  → Fingerprint Sensor RX (green wire)
    GPIO15 (D8)  → Fingerprint Sensor TX (white wire)
    GPIO4  (D2)  → I2C SDA
    GPIO5  (D1)  → I2C SCL
    GPIO16 (D0)  → Servo signal
    GPIO12 (D6)  → Mode button (with INPUT_PULLUP)
    GPIO14 (D5)  → Status LED
  
  DATABASE:
    - Stored procedure: managym.CheckSubscriptionAndFetchFullName(id)
      Returns: (is_valid, first_name, last_name)
    - Table: managym.presences
      Fields: id, personnel_id, created_at, updated_at
  
  MODES:
    LED OFF → Identification mode (verify fingerprints, grant access)
    LED ON  → Enrollment mode (register new fingerprints)
  
  AUTHOR: Enhanced version with improved error handling and documentation
  DATE: 2025
  ===============================================================================
*/

// ============================================================================
// LIBRARY INCLUDES
// ============================================================================
#include <SoftwareSerial.h>
#include <Servo.h>
#include <Wire.h>
#include <Adafruit_Fingerprint.h>
#include <LiquidCrystal_I2C.h>
#include <EEPROM.h>
#include <ESP8266WiFi.h>
#include <MySQL_Connection.h>
#include <MySQL_Cursor.h>

// ============================================================================
// CONFIGURATION CONSTANTS
// ============================================================================

// Network Configuration
const char WIFI_SSID[] = "1.618";
const char WIFI_PASS[] = "45878923";

// Database Configuration
IPAddress DB_SERVER(192, 168, 8, 118);
const char DB_USER[] = "arduino_user";
const char DB_PASS[] = "secret";
const uint16_t DB_PORT = 3306;

// Hardware Pin Definitions
const uint8_t PIN_LED = 14;           // D5 - Status LED
const uint8_t PIN_BUTTON = 12;        // D6 - Mode button
const uint8_t PIN_SERVO = 16;         // D0 - Servo control
const uint8_t PIN_FINGER_RX = 13;     // D7 - Fingerprint RX
const uint8_t PIN_FINGER_TX = 15;     // D8 - Fingerprint TX
const uint8_t PIN_I2C_SDA = 4;        // D2 - I2C Data
const uint8_t PIN_I2C_SCL = 5;        // D1 - I2C Clock

// Timing Constants
const uint16_t DEBOUNCE_MS = 200;
const uint16_t SERVO_OPEN_ANGLE = 170;
const uint16_t SERVO_CLOSE_ANGLE = 0;
const uint32_t ACCESS_DURATION_MS = 2000;
const uint32_t BAUD_SERIAL = 115200;
const uint32_t BAUD_FINGERPRINT = 57600;

// EEPROM Addresses
const uint8_t EEPROM_ID_ADDRESS = 0;
const uint16_t EEPROM_SIZE = 512;

// Admin Configuration
const uint8_t ADMIN_FINGERPRINT_ID = 1;

// ============================================================================
// GLOBAL OBJECTS
// ============================================================================
LiquidCrystal_I2C lcd(0x27, 16, 2);
Servo doorServo;
SoftwareSerial fingerprintSerial(PIN_FINGER_RX, PIN_FINGER_TX);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&fingerprintSerial);

WiFiClient wifiClient;
MySQL_Connection dbConnection(&wifiClient);

// ============================================================================
// GLOBAL VARIABLES
// ============================================================================
uint8_t currentFingerprintID = 1;
bool isEnrollMode = false;  // false = Identify, true = Enroll
int lastButtonState = HIGH;
unsigned long lastDebounceTime = 0;

// ============================================================================
// EEPROM FUNCTIONS
// ============================================================================

/**
 * Read a byte value from flash memory (EEPROM)
 * @param address Memory address to read from
 * @return Byte value stored at address
 */
uint8_t readFromFlash(uint16_t address) {
  EEPROM.begin(EEPROM_SIZE);
  uint8_t value = EEPROM.read(address);
  EEPROM.end();
  return value;
}

/**
 * Write a byte value to flash memory (EEPROM)
 * Only writes if value has changed to preserve flash lifespan
 * @param address Memory address to write to
 * @param value Byte value to store
 */
void writeToFlash(uint16_t address, uint8_t value) {
  EEPROM.begin(EEPROM_SIZE);
  uint8_t storedValue = EEPROM.read(address);
  
  if (storedValue != value) {
    EEPROM.write(address, value);
    EEPROM.commit();
    Serial.printf("EEPROM: Wrote %d to address %d\n", value, address);
  }
  
  EEPROM.end();
}

// ============================================================================
// DATABASE FUNCTIONS
// ============================================================================

/**
 * Insert a presence record into the database
 * @param personnelID The fingerprint ID of the person
 * @return true if successful, false otherwise
 */
bool insertPresence(uint8_t personnelID) {
  char query[256];
  snprintf(query, sizeof(query), 
           "INSERT INTO managym.presences(id, personnel_id, created_at, updated_at) "
           "VALUES (NULL, %d, NOW(), NOW());", 
           personnelID);
  
  Serial.print("Connecting to database... ");
  if (!dbConnection.connect(DB_SERVER, DB_PORT, DB_USER, DB_PASS)) {
    Serial.println("FAILED!");
    return false;
  }
  Serial.println("OK");
  
  MySQL_Cursor* cursor = new MySQL_Cursor(&dbConnection);
  cursor->execute(query);
  delete cursor;
  
  if (dbConnection.connected()) {
    dbConnection.close();
  }
  
  Serial.println("Presence logged successfully");
  return true;
}

/**
 * Check subscription status and fetch user's full name
 * @param personnelID The fingerprint ID of the person
 * @return String in format "V FirstName LastName" where V is 1 (valid) or 0 (expired)
 */
String checkSubscriptionAndGetName(uint8_t personnelID) {
  char query[128];
  snprintf(query, sizeof(query), 
           "CALL managym.CheckSubscriptionAndFetchFullName(%d);", 
           personnelID);
  
  Serial.print("Connecting to database... ");
  if (!dbConnection.connect(DB_SERVER, DB_PORT, DB_USER, DB_PASS)) {
    Serial.println("FAILED!");
    return "0 Unknown User";
  }
  Serial.println("OK");
  
  MySQL_Cursor* cursor = new MySQL_Cursor(&dbConnection);
  cursor->execute(query);
  
  // Fetch columns (required by library)
  column_names* columns = cursor->get_columns();
  
  // Read the result row
  row_values* row = cursor->get_next_row();
  String result = "0 Unknown User";
  
  if (row != NULL && row->values[0] != NULL) {
    char fullName[100];
    strcpy(fullName, row->values[0]);  // Validity flag
    strcat(fullName, " ");
    
    if (row->values[1] != NULL) {
      strcat(fullName, row->values[1]);  // First name
    }
    
    strcat(fullName, " ");
    
    if (row->values[2] != NULL) {
      strcat(fullName, row->values[2]);  // Last name
    }
    
    result = String(fullName);
  }
  
  delete cursor;
  
  if (dbConnection.connected()) {
    dbConnection.close();
  }
  
  return result;
}

// ============================================================================
// LCD HELPER FUNCTIONS
// ============================================================================

/**
 * Display a centered message on LCD
 * @param line LCD line (0 or 1)
 * @param message Text to display
 */
void lcdPrintCentered(uint8_t line, const char* message) {
  lcd.setCursor(0, line);
  lcd.print("                ");  // Clear line
  
  uint8_t len = strlen(message);
  uint8_t pos = (len < 16) ? (16 - len) / 2 : 0;
  lcd.setCursor(pos, line);
  lcd.print(message);
}

/**
 * Display a two-line message on LCD
 * @param line1 First line text
 * @param line2 Second line text
 */
void lcdShowMessage(const char* line1, const char* line2) {
  lcd.clear();
  lcdPrintCentered(0, line1);
  lcdPrintCentered(1, line2);
}

// ============================================================================
// SERVO CONTROL FUNCTIONS
// ============================================================================

/**
 * Open door/turnstile and close after delay
 */
void grantAccess() {
  doorServo.write(SERVO_OPEN_ANGLE);
  delay(ACCESS_DURATION_MS);
  doorServo.write(SERVO_CLOSE_ANGLE);
}

// ============================================================================
// FINGERPRINT ENROLLMENT FUNCTIONS
// ============================================================================

/**
 * Enroll a new fingerprint into the system
 * @return true if enrollment successful, false otherwise
 */
bool enrollFingerprint() {
  int p = -1;
  
  // Read current ID from EEPROM
  currentFingerprintID = readFromFlash(EEPROM_ID_ADDRESS);
  if (currentFingerprintID == 0) {
    currentFingerprintID = 1;  // Start from ID 1 if EEPROM is empty
  }
  
  Serial.printf("Enrolling fingerprint ID #%d\n", currentFingerprintID);
  
  // === STEP 1: Capture first image ===
  lcdShowMessage("Ready to enroll", "fingerprint");
  delay(2000);
  
  lcd.clear();
  lcd.setCursor(2, 0);
  lcd.print("Current ID:");
  lcd.setCursor(7, 1);
  lcd.printf("#%d", currentFingerprintID);
  delay(2000);
  
  lcdShowMessage("Place finger on", "sensor");
  
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image captured");
        lcdShowMessage("Image taken", "");
        delay(1000);
        break;
        
      case FINGERPRINT_NOFINGER:
        checkModeButton();  // Allow mode switching during wait
        break;
        
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        lcdShowMessage("Comm Error", "Try again");
        delay(2000);
        return false;
        
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        lcdShowMessage("Image Error", "Try again");
        delay(2000);
        return false;
        
      default:
        Serial.println("Unknown error");
        break;
    }
  }
  
  // Convert image to template
  p = finger.image2Tz(1);
  if (p != FINGERPRINT_OK) {
    lcdShowMessage("Image too messy", "Try again");
    delay(2000);
    return false;
  }
  
  lcdShowMessage("Image converted", "");
  delay(1000);
  
  // === STEP 2: Remove finger ===
  lcdShowMessage("Remove finger", "");
  delay(2000);
  
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  
  // === STEP 3: Capture second image ===
  lcdShowMessage("Place same", "finger again");
  p = -1;
  
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Second image captured");
        lcdShowMessage("Image taken", "");
        delay(1000);
        break;
        
      case FINGERPRINT_NOFINGER:
        // Wait for finger
        break;
        
      default:
        Serial.println("Error capturing second image");
        break;
    }
  }
  
  // Convert second image
  p = finger.image2Tz(2);
  if (p != FINGERPRINT_OK) {
    lcdShowMessage("Image too messy", "Try again");
    delay(2000);
    return false;
  }
  
  lcdShowMessage("Image converted", "");
  delay(1000);
  
  // === STEP 4: Create model ===
  Serial.println("Creating fingerprint model...");
  p = finger.createModel();
  
  if (p == FINGERPRINT_OK) {
    Serial.println("Prints matched!");
    lcdShowMessage("Prints matched!", "");
    delay(1500);
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Fingerprints did not match");
    lcdShowMessage("Prints don't", "match");
    delay(2000);
    return false;
  } else {
    Serial.println("Error creating model");
    lcdShowMessage("Error", "Try again");
    delay(2000);
    return false;
  }
  
  // === STEP 5: Store model ===
  Serial.printf("Storing model at ID #%d\n", currentFingerprintID);
  p = finger.storeModel(currentFingerprintID);
  
  if (p == FINGERPRINT_OK) {
    Serial.println("Fingerprint stored successfully!");
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Stored in ID:");
    lcd.setCursor(6, 1);
    lcd.printf("#%d", currentFingerprintID);
    delay(3000);
    
    // Increment ID for next enrollment
    currentFingerprintID++;
    writeToFlash(EEPROM_ID_ADDRESS, currentFingerprintID);
    
    return true;
  } else {
    Serial.printf("Error storing fingerprint: %d\n", p);
    lcdShowMessage("Storage Error", "Try again");
    delay(2000);
    return false;
  }
}

// ============================================================================
// FINGERPRINT IDENTIFICATION FUNCTIONS
// ============================================================================

/**
 * Identify fingerprint and grant access if valid
 * @return Fingerprint ID if found, -1 otherwise
 */
int identifyFingerprint() {
  lcdShowMessage("Insert your", "finger");
  
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK) return -1;
  
  p = finger.image2Tz();
  if (p != FINGERPRINT_OK) return -1;
  
  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK) return -1;
  
  uint8_t foundID = finger.fingerID;
  uint8_t confidence = finger.confidence;
  
  Serial.printf("Found ID #%d with confidence %d\n", foundID, confidence);
  
  // Check if admin
  if (foundID == ADMIN_FINGERPRINT_ID) {
    lcdShowMessage("Admin", "Access Granted!");
    grantAccess();
    delay(1000);
    lcd.clear();
    return foundID;
  }
  
  // Check subscription and get name
  String userData = checkSubscriptionAndGetName(foundID);
  char validityFlag = userData.charAt(0);
  String fullName = userData.substring(2);  // Skip "V " prefix
  
  Serial.printf("User: %s, Valid: %c\n", fullName.c_str(), validityFlag);
  
  if (validityFlag == '1') {
    // Valid subscription - grant access
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Welcome");
    lcd.setCursor(0, 1);
    lcd.print(fullName.substring(0, 16));  // Limit to LCD width
    
    grantAccess();
    insertPresence(foundID);
    
    delay(1000);
    lcd.clear();
  } else {
    // Expired subscription - deny access
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Hello");
    lcd.setCursor(0, 1);
    lcd.print(fullName.substring(0, 16));
    delay(2000);
    
    lcdShowMessage("Subscription", "Expired!");
    
    // Flash LED as warning
    for (int i = 0; i < 7; i++) {
      digitalWrite(PIN_LED, LOW);
      delay(250);
      digitalWrite(PIN_LED, HIGH);
      delay(250);
    }
    digitalWrite(PIN_LED, LOW);
    
    delay(1000);
    lcd.clear();
  }
  
  return foundID;
}

// ============================================================================
// MODE SWITCHING FUNCTION
// ============================================================================

/**
 * Check mode button with debouncing
 * Toggles between Enroll and Identify modes
 */
void checkModeButton() {
  int reading = digitalRead(PIN_BUTTON);
  unsigned long currentTime = millis();
  
  // Check if button state changed and debounce period has passed
  if (reading != lastButtonState && 
      (currentTime - lastDebounceTime) > DEBOUNCE_MS) {
    
    lastDebounceTime = currentTime;
    
    if (reading == LOW) {  // Button pressed (INPUT_PULLUP inverts logic)
      // Toggle mode
      isEnrollMode = !isEnrollMode;
      digitalWrite(PIN_LED, isEnrollMode ? HIGH : LOW);
      
      Serial.printf("Mode changed to: %s\n", 
                    isEnrollMode ? "ENROLL" : "IDENTIFY");
      
      lcd.clear();
      if (isEnrollMode) {
        lcdShowMessage("Mode: ENROLL", "");
      } else {
        lcdShowMessage("Mode: IDENTIFY", "");
      }
      delay(1500);
      lcd.clear();
    }
  }
  
  lastButtonState = reading;
}

// ============================================================================
// SETUP FUNCTION
// ============================================================================

void setup() {
  // Initialize Serial for debugging
  Serial.begin(BAUD_SERIAL);
  while (!Serial) delay(10);  // Wait for Serial on some boards
  
  Serial.println("\n\n===========================================");
  Serial.println("Fingerprint Access Control System");
  Serial.println("===========================================\n");
  
  // Initialize GPIO pins
  pinMode(PIN_LED, OUTPUT);
  pinMode(PIN_BUTTON, INPUT_PULLUP);
  digitalWrite(PIN_LED, LOW);
  
  // Initialize I2C for LCD
  Wire.begin(PIN_I2C_SDA, PIN_I2C_SCL);
  lcd.init();
  lcd.backlight();
  lcdShowMessage("System", "Initializing...");
  
  // Initialize WiFi
  Serial.printf("Connecting to WiFi: %s\n", WIFI_SSID);
  WiFi.begin(WIFI_SSID, WIFI_PASS);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  
  Serial.println("\nWiFi connected!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
  
  // Initialize fingerprint sensor
  fingerprintSerial.begin(BAUD_FINGERPRINT);
  finger.begin(BAUD_FINGERPRINT);
  
  if (finger.verifyPassword()) {
    Serial.println("Fingerprint sensor found!");
  } else {
    Serial.println("ERROR: Fingerprint sensor not found!");
    lcdShowMessage("Sensor Error!", "Check wiring");
    while (1) delay(1000);  // Halt
  }
  
  // Print sensor parameters
  finger.getParameters();
  Serial.println("\n--- Sensor Info ---");
  Serial.printf("Capacity: %d\n", finger.capacity);
  Serial.printf("Security Level: %d\n", finger.security_level);
  Serial.printf("Packet Length: %d\n", finger.packet_len);
  Serial.printf("Baud Rate: %d\n", finger.baud_rate);
  Serial.println("-------------------\n");
  
  // Initialize servo
  doorServo.attach(PIN_SERVO);
  doorServo.write(SERVO_CLOSE_ANGLE);
  
  // Load last fingerprint ID from EEPROM
  currentFingerprintID = readFromFlash(EEPROM_ID_ADDRESS);
  if (currentFingerprintID == 0 || currentFingerprintID == 255) {
    currentFingerprintID = 2;  // Start at 2 (1 is reserved for admin)
    writeToFlash(EEPROM_ID_ADDRESS, currentFingerprintID);
  }
  Serial.printf("Next enrollment ID: %d\n", currentFingerprintID);
  
  // System ready
  lcdShowMessage("System Ready", "");
  delay(2000);
  lcd.clear();
  
  Serial.println("System initialized successfully!");
  Serial.println("Default mode: IDENTIFY");
  Serial.println("Press button to switch modes\n");
}

// ============================================================================
// MAIN LOOP
// ============================================================================

void loop() {
  // Always check for mode button press
  checkModeButton();
  
  if (isEnrollMode) {
    // === ENROLLMENT MODE ===
    enrollFingerprint();
    delay(1000);  // Brief pause between enrollments
  } else {
    // === IDENTIFICATION MODE ===
    identifyFingerprint();
    delay(50);  // Small delay to prevent excessive sensor polling
  }
}