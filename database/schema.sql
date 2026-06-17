CREATE DATABASE pontofacil_db;

USE pontofacil_db;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    cargo VARCHAR(20),
    departamento VARCHAR(20),
    email VARCHAR(70) UNIQUE,
    senha VARCHAR(50) NOT NULL,
    nivel_acesso ENUM('admin', 'func') DEFAULT 'func',
    horario_entrada TIME NOT NULL,
    horario_saida TIME NOT NULL 
);

CREATE TABLE registros(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_registro DATE NOT NULL,
    entrada TIME NOT NULL,
    inicio_intervalo TIME,
    fim_intervalo TIME,
    saida TIME NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE configuracoes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_empresa VARCHAR(50) NOT NULL,
    tolerancia_atraso INT NOT NULL DEFAULT 10,
    intervalo_padrao INT NOT NULL DEFAULT 60 
);

INSERT 
INTO configuracoes (nome_empresa, tolerancia_atraso, intervalo_padrao) 
VALUES ('Padaria da Ponte', 10, 60);

INSERT 
INTO usuarios (nome, cpf, email, senha, nivel_acesso) 
VALUES ('Admin', '000.000.000-00', 'admin@empresa.com', 'senha123', 'admin');