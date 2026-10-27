-- Exercício PHP + MySQL -- ODAW
-- Alunos: Ana e Mauricio
--
-- Executar com:
--   mysql -u root -p < banco.sql

CREATE DATABASE IF NOT EXISTS exercicio12
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE exercicio12;

CREATE TABLE IF NOT EXISTS cadastros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,          -- hash gerado por password_hash()
    telefone VARCHAR(20),
    data_nascimento DATE NOT NULL,
    curso VARCHAR(100) NOT NULL,
    turno VARCHAR(10) NOT NULL,
    interesses VARCHAR(255) NOT NULL,     -- valores separados por vírgula
    observacoes TEXT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
