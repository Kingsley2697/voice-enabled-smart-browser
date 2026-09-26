CREATE DATABASE IF NOT EXISTS voice_browser CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE voice_browser;

CREATE TABLE IF NOT EXISTS search_history (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  query VARCHAR(500) NOT NULL,
  search_method ENUM('typed', 'voice') NOT NULL DEFAULT 'typed',
  result_title VARCHAR(500) NULL,
  result_text TEXT NULL,
  result_url VARCHAR(1000) NULL,
  ip_address VARCHAR(45) NULL,
  device_name VARCHAR(255) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB;
