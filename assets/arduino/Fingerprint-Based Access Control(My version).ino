#include <SoftwareSerial.h>
#include<Servo.h>
#include <Wire.h> 
#include <Adafruit_Fingerprint.h>
#include <LiquidCrystal_I2C.h>
#include <EEPROM.h>
//==================================================================DATABASE_STUFF
  #include <ESP8266WiFi.h>
  #include <MySQL_Connection.h>
  #include <MySQL_Cursor.h>
  IPAddress server_addr(192, 168, 8, 118); // IP of the MySQL server
  char user[] = "arduino_user";            // MySQL user login username
  char password[] = "secret";  

  // presence
  //int variable = 3;
  char INSERT_SQL[1000];
  // full_name
  char query[100];
  char resultx[100];
  
  // WiFi card example
  char ssid[] = "1.618";         // 1.618
  char pass[] = "45878923";     // 45878923
  
  WiFiClient client;                 // Use this for WiFi instead of EthernetClient
  MySQL_Connection conn(&client);
  MySQL_Cursor *cursor;
  MySQL_Cursor cur = MySQL_Cursor(&conn);
  

 void InsertPrence(int id){
    snprintf(INSERT_SQL, sizeof(INSERT_SQL), "INSERT INTO managym.presences(id, personnel_id, created_at, updated_at) VALUES (null,%d,NOW(),NOW());", id);
  Serial.print("Connecting to SQL...  ");
  if (conn.connect(server_addr, 3306, user, password))
    Serial.println("OK.");
  else
    Serial.println("FAILED.");

  //create MySQL cursor object
  cursor = new MySQL_Cursor(&conn);
    if (conn.connected())
    cursor->execute(INSERT_SQL);
 }
 String Mainx(int id){
    snprintf(query, sizeof(query), "CALL managym.CheckSubscriptionAndFetchFullName(%d);", id);
      Serial.print("Connecting to SQL...  ");
  if (conn.connect(server_addr, 3306, user, password))
    Serial.println("OK.");
  else
    Serial.println("FAILED.");
  ///////////////////////////////////////////////////////////////////////////////////////
  row_values *row = NULL;
  char head_count[100];
  // Initiate the query class instance
  MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
  // Execute the query
  cur_mem->execute(query);
  // Fetch the columns (required) but we don't use them.
  column_names *columns = cur_mem->get_columns();
  // Read the row (we are only expecting the one)
    row = cur_mem->get_next_row();
    if (row != NULL) {
      //head_count = row->values[0];
      //strcpy(head_count, row->values[0]);
    strcpy(head_count, row->values[0]);
    strcat(head_count, " ");
    strcat(head_count, row->values[1]);
    }
  // Deleting the cursor also frees up memory used
  delete cur_mem;
  //Serial.println(head_count);
  //delay(2000);
   return head_count;
 }



//==================================================================DATABASE_STUFF
LiquidCrystal_I2C lcd(0x27,16,2);
Servo servo;
uint8_t ID = 1;
#if (defined(__AVR__) || defined(ESP8266)) && !defined(__AVR_ATmega2560__)
// For UNO and others without hardware serial, we must use software serial...
// pin #2 is IN from sensor (GREEN wire)
// pin #3 is OUT from arduino  (WHITE wire)
// Set up the serial port to use softwareserial..
SoftwareSerial mySerial(13, 15);

#else
// On Leonardo/M0/etc, others with hardware serial, use hardware serial!
// #0 is green wire, #1 is white
#define mySerial Serial1

#endif


Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

uint8_t id;

int LEDState = 0;
int LEDPin = 14;
int buttonPin = 12;
int buttonNew;
int buttonOld = 1;
int dt = 250;
//---------------------------------------------------emprommstuff
// Function to read a value from the flash memory
int readFromFlash(int address) {
  int value = -1; // Default value if reading fails
  
  EEPROM.begin(512); // Initialize EEPROM with a size (in bytes)
  
  // Read the value at the specified address
  value = EEPROM.read(address);
  
  EEPROM.end(); // Release the EEPROM
  
  return value;
}
void writeToFlash(int address, byte value) {
  EEPROM.begin(512); // Initialize EEPROM with a size (in bytes)
  
  byte storedValue = EEPROM.read(address);
  if (storedValue != value) {
    EEPROM.write(address, value);
    EEPROM.commit(); // Save the updated value to the flash memory
  }
  
  EEPROM.end(); // Release the EEPROM
}




//---------------------------------------------------emprommstuff
void setup()
{
  
//==================================================================DATABASE_STUFF

Serial.begin(115200);
  while (!Serial)
    ; // wait for serial port to connect. Needed for Leonardo only

  // Begin WiFi section
  Serial.printf("\nConnecting to %s", ssid);
  WiFi.begin(ssid, pass);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }

  // print out info about the connection:
  Serial.println("\nConnected to network");
  Serial.print("My IP address is: ");
  Serial.println(WiFi.localIP());
//==================================================================DATABASE_STUFF
  
  //*************************************************+setup switch button
  Serial.begin(9600);
  pinMode(LEDPin, OUTPUT);
  pinMode(buttonPin, INPUT);
  Wire.begin(2,0);
  if (LEDState == 1){
        //*************************************************setup insert mode
        //*************************************************For lcd i2c   
        
        lcd.init();
        // Print a message to the LCD.
        lcd.backlight();
        Serial.begin(9600);
        while (!Serial);  // For Yun/Leo/Micro/Zero/...
        delay(100);
        Serial.println("\n\nAdafruit Fingerprint sensor enrollment");

        // set the data rate for the sensor serial port
        finger.begin(57600);

        if (finger.verifyPassword()) {
          Serial.println("Found fingerprint sensor!"); //**//
          Serial.println("Did not find fingerprint sensor :("); 
          while (1) { delay(1); }        } else {

        }

        Serial.println(F("Reading sensor parameters"));
        finger.getParameters();
        Serial.print(F("Status: 0x")); Serial.println(finger.status_reg, HEX);
        Serial.print(F("Sys ID: 0x")); Serial.println(finger.system_id, HEX);
        Serial.print(F("Capacity: ")); Serial.println(finger.capacity);
        Serial.print(F("Security level: ")); Serial.println(finger.security_level);
        Serial.print(F("Device address: ")); Serial.println(finger.device_addr, HEX);
        Serial.print(F("Packet len: ")); Serial.println(finger.packet_len);
        Serial.print(F("Baud rate: ")); Serial.println(finger.baud_rate);
  } else {
  //*************************************************setup check mode
        Serial.begin(9600);
        lcd.begin(16,2);                      // initialize the lcd 
        lcd.init();
        // Print a message to the LCD.
        lcd.backlight();
        lcd.setCursor(3,0);
        lcd.print("Insert your "); //**
        lcd.setCursor(5,1);   //**
        lcd.print("finger ");  //**
        finger.begin(57600);
        servo.attach(16);
        pinMode(4,OUTPUT);    //**
        pinMode(5,OUTPUT);    //**
        servo.write(0);
  }

}

uint8_t readnumber(void) {
  uint8_t num = 0;

  while (num == 0) {
    while (! Serial.available());
    num = Serial.parseInt();
  }
  return num;
}

void loop()                     // run over and over again
{
  //*************************************************** loop switch button
  if (LEDState == 1){
          //*************************************************** loop insert mode  
          Serial.println("Ready to enroll a fingerprint!"); 
          ///1***///
          lcd.clear();
          lcd.setCursor(0,0);
          lcd.print("Ready to enroll ");
          lcd.setCursor(0,1);
          lcd.print("your fingerprint");
          delay(3000);
          ///***1///
          Serial.println("curent id #"); 
          Serial.print(ID); 
          ///2***///
          lcd.clear();
          lcd.setCursor(2,0);
          lcd.print("current id :");
          lcd.setCursor(7,1);
          lcd.print("#");
          lcd.setCursor(8,1);
          lcd.print(ID);
          delay(2000);
          ///***2///
          if (ID == 0) {// ID #0 not allowed, try again!
            return;
          }
          Serial.print("Enrolling ID #");
          Serial.println(ID);

          while (!  getFingerprintEnroll() );

  } else {
          //*************************************************loop check mode
          while (true) {
            getFingerprintIDez();
            delay(50);            //don't ned to run this at full speed.
            digitalWrite(4,HIGH);
            digitalWrite(5,LOW);
            check_switch();
          }
  }
}

uint8_t getFingerprintEnroll() {
  int p = -1;
  //________________________________________--READ from the eepprom
  ID = readFromFlash(0);
  Serial.print("Waiting for valid finger to enroll as #"); Serial.println(ID); ///4***///
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Ready to enroll ");
  lcd.setCursor(0,1);
  lcd.print("your fingerprint");
  delay(3000);
  lcd.clear();
  lcd.setCursor(2,0);
  lcd.print("current id :");
  lcd.setCursor(7,1);
  lcd.print("#");
  lcd.setCursor(8,1);
  lcd.print(ID);
  delay(2000);
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image taken");
      ///4***///
      lcd.clear();
      lcd.setCursor(3, 0);
      lcd.printstr("Image taken");
      delay(1000);
      ///***4///
      break;
    case FINGERPRINT_NOFINGER:
      Serial.println(".");
      ///3***///
      lcd.setCursor(0,0);
      lcd.print("keep your finger");
      lcd.setCursor(1,1);
      lcd.print("on fingerprint");
      ///***3///
      check_switch();
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      break;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Imaging error");
      break;
    default:
      Serial.println("Unknown error");
      break;
    }
  }

  // OK success!

  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      ///5***///
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.printstr("Image converted");
      delay(1000);
      ///***5///
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  Serial.println("Remove finger");
  ///6***///
  lcd.clear();
  lcd.setCursor(1, 0);
  lcd.printstr("Remove finger");
  delay(1000);
  ///***6///
  delay(2000);
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  Serial.print("ID "); Serial.println(ID);
  p = -1;
  Serial.println("Place same finger again");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image taken");
        ///6***///
        lcd.clear();
        lcd.setCursor(3, 0);
        lcd.printstr("Image taken");
        delay(1000);
        ///***6///
      break;
    case FINGERPRINT_NOFINGER:
      Serial.print(".");
      ///7***///
      lcd.setCursor(0,0);
      lcd.print("Place your same");
      lcd.setCursor(2,1);
      lcd.print("finger again");
      ///***7///
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      break;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Imaging error");
      break;
    default:
      Serial.println("Unknown error");
      break;
    }
  }

  // OK success!

  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      ///8***///
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.printstr("Image converted");
      delay(1000);
      ///***8///
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK converted!
  Serial.print("Creating model for #");  Serial.println(ID);

  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    Serial.println("Prints matched!");
     ///8***///
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.printstr("Prints matched!");
    delay(1500);
    ///***8///
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Fingerprints did not match");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  Serial.print("ID "); Serial.println(ID);
  p = finger.storeModel(ID);
  if (p == FINGERPRINT_OK) {
    Serial.println("Stored!");
    ///8***///
    lcd.clear();
    lcd.setCursor(1, 0);
    lcd.printstr("Stored in Id :");
    lcd.setCursor(7, 1);
    lcd.print("#");
    lcd.setCursor(8, 1);
    lcd.print(ID);
    delay(5000);
    ///***8///
    ID++;
    check_switch();
    digitalWrite(LEDPin, LOW);
    lcd.clear();
    //__________________________________-----------eprom update
    writeToFlash(0, ID);  //1 to reset the flash memory
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not store in that location");
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  return true;
}


int getFingerprintIDez() {
  lcd.setCursor(3,0);
  lcd.print("Insert your "); //**
  lcd.setCursor(5,1);   //**
  lcd.print("finger ");   //**
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK)  return -1;

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK)  return -1;

  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK)  return -1;
  

  Serial.print("Found ID #"); Serial.print(finger.fingerID); 
  Serial.print(" with confidence of "); Serial.println(finger.confidence);
  int kda = finger.fingerID;
if(finger.fingerID=2){
    String fname = Mainx(kda);
    char valid = fname[0];
    Serial.println(valid);
    Serial.println(fname.substring(2));
    if(valid == '1' || kda ==  1){
      servo.write(170);
      digitalWrite(5,HIGH);
      digitalWrite(4,LOW);
      if(kda ==  1){
        lcd.clear();
        lcd.setCursor(4,0);   
        lcd.print(" Admin ");  //**
        lcd.setCursor(6,1);      //**
        lcd.print("Access !");   //**
        delay(2000);
        servo.write(0);
        lcd.clear();
       }else{ 
        lcd.clear();
        lcd.setCursor(4,0);   
        lcd.print(" Welcome ");  //**
        lcd.setCursor(0,1);      //**
        lcd.print(fname.substring(2));   //**
        delay(2000);
        servo.write(0);
        InsertPrence(kda);
        lcd.clear();  
      }
    }else{
      lcd.clear();
      lcd.setCursor(5,0);
      lcd.print("Hello :");
      lcd.setCursor(0,1);
      lcd.print(fname.substring(2));
      for( int i = 0 ; i < 7 ; i++ ){
          digitalWrite(4,LOW);
          delay(250);
          digitalWrite(4,HIGH);
          delay(250);
      }
      lcd.clear();
      lcd.setCursor(2,0);
      lcd.print("subscription");
      lcd.setCursor(4,1);
      lcd.print("expired !");
      delay(1000);
      lcd.clear();
    }
}
  
  return finger.fingerID; 
}



void check_switch(){
    // put your main code here, to run repeatedly:
  bool change_mode = false;
  buttonNew = digitalRead(buttonPin);
  if (buttonOld == 0 && buttonNew == 1){
    if (LEDState == 0){
      digitalWrite(LEDPin, HIGH);
      LEDState = 1;
    } else {
      digitalWrite(LEDPin, LOW);
      LEDState = 0;
    }
    change_mode = true;
  }

  buttonOld = buttonNew;
  if (change_mode == true){
    if (LEDState == 0) {
        getFingerprintIDez();
    } else {
        getFingerprintEnroll();
    }
  }
}
