CREATE SCHEMA LumBooks;
DROP TABLE IF EXISTS Utente;
DROP TABLE IF EXISTS Libri_Generali;
DROP TABLE IF EXISTS Libri_Listati;


CREATE TABLE Utente(
Codice_identificativo char (6) primary key,
Matricola char (5) not null,
Nome varchar(30) not null,
Cognome varchar(50)not null,
Sesso char(1),
Data_di_nascita date,
Username varchar(30)not null unique,
Pw char(8)not null,
Email varchar(50),

unique (Nome,Cognome,Matricola)
);
ALTER TABLE Utente AUTO_INCREMENT=100000;

CREATE TABLE Libri_In_Vendita(
Codice_Vendita char (5) primary key,

Titolo varchar(50) not null,
Autore varchar(50)not null,

Venditore char (5)not null references Utente(Matricola),
Prezzo int(5) not null,

ISBN char(13),
Edizione varchar(20),
Anno_Pubblicazione int(4),
Casa_Editrice varchar(30),

Stato varchar(20) not null,
Tipo varchar(30) not null,
Codice_identificativo_Libro char(5)
);
ALTER TABLE Libri_In_Vendita AUTO_INCREMENT=10000;



CREATE TABLE Libri_Listati(
Codice_identificativo char (5) primary key REFERENCES Libri_In_Vendita(Codice_identificativo_Libro),
Titolo varchar(50) not null,
Autore varchar(50)not null,

Venditore char (5)not null references Utente(Matricola),
Prezzo int(5) not null,

ISBN char(13) not null,
Edizione varchar(20),
Anno_Pubblicazione int(4),
Casa_Editrice varchar(30) not null,

Stato varchar(20) not null,
Corso varchar(30) not null
);

ALTER TABLE Libri_Listati AUTO_INCREMENT=50000;