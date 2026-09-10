-- =========================================================
-- Health Monitoring System — Database Schema
-- Import this first:  mysql -u root -p < schema.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS health_monitor;
USE health_monitor;

-- ---------------------------------------------------------
-- Users (login / registration / profile)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,      -- password_hash() output
    full_name   VARCHAR(100) DEFAULT NULL,
    phone       VARCHAR(20)  DEFAULT NULL,
    age         INT          DEFAULT NULL,
    height_cm   DECIMAL(5,2) DEFAULT NULL,
    weight_kg   DECIMAL(5,2) DEFAULT NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Health readings (replaces the ESP32 feed).
-- One row per reading. Populate manually, via CSV import,
-- or with the built-in "Generate demo data" button.
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS health_data (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    recorded_at DATETIME NOT NULL,
    bpm         INT NOT NULL,
    spo2        INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_health_user_date ON health_data (user_id, recorded_at);
