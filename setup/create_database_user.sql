CREATE USER 'raspi_surveillance'@'localhost';

-- Only used during initial setup, not needed during normal operation
GRANT CREATE ON raspi_surveillance.* TO 'raspi_surveillance'@'localhost';
GRANT ALTER  ON raspi_surveillance.* TO 'raspi_surveillance'@'localhost';

-- Used during normal operation
GRANT INSERT ON raspi_surveillance.* TO 'raspi_surveillance'@'localhost';
GRANT SELECT ON raspi_surveillance.* TO 'raspi_surveillance'@'localhost';
GRANT UPDATE ON raspi_surveillance.* TO 'raspi_surveillance'@'localhost';
GRANT DELETE ON raspi_surveillance.* TO 'raspi_surveillance'@'localhost';
