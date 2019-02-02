DROP TABLE IF EXISTS Utente;
DROP TABLE IF EXISTS Libri_In_Vendita;
DROP TABLE IF EXISTS Libri_Listati;

CREATE TABLE Utente(
    Codice_identificativo int (6) primary key AUTO_INCREMENT,
    Nome varchar(30) not null,
    Cognome varchar(50)not null,
    Sesso char(1) not null,
    Data_di_nascita date not null,
    Pw_Hash varchar(100)not null,
    Email varchar(50) not null unique,
    Numero varchar(20) not null unique
);
ALTER TABLE Utente AUTO_INCREMENT=100000;

CREATE TABLE Libri_Listati(
    Codice_identificativo int (5) primary key AUTO_INCREMENT,
    Titolo varchar(50) not null,
    Autore varchar(50)not null,
    Casa_Editrice varchar(30)not null,
    Corso varchar(30) not null
);
ALTER TABLE Libri_Listati AUTO_INCREMENT=50000;

CREATE TABLE Libri_In_Vendita(
    Codice_Vendita int (5) primary key AUTO_INCREMENT,

    Titolo varchar(50) not null,
    Autore varchar(50)not null,

    Venditore int (6)not null references Utente(Codice_Identificativo),
    Acquirente int (6) references Utente(Codice_Identificativo),
    Prezzo decimal(5,2) not null,
    Data_Aggiunta date not null,

    ISBN char(13),
    Edizione varchar(20),
    Anno_Pubblicazione int(4),
    Casa_Editrice varchar(30),
    Corso varchar(30),

    Stato varchar(20) not null,
    Tipo varchar(30) not null,
    Codice_identificativo_Libro int (5),

    Descrizione varchar(200),

    md5_Hash char(32) not null unique,
    /*Hash md5 calcolato a partire da valore casuale*/
    CONSTRAINT fk
    FOREIGN KEY (Codice_identificativo_Libro)
    REFERENCES Libri_Listati(Codice_identificativo)
    ON DELETE SET NULL
);
ALTER TABLE Libri_In_Vendita AUTO_INCREMENT=10000;
ALTER TABLE Libri_In_Vendita
ADD CONSTRAINT PrezzoPos CHECK (Prezzo >= 0),
ADD CONSTRAINT StatoVendita CHECK (Stato IN ("Venduto","In Vendita","Prenotato")),
ADD CONSTRAINT TipoArticolo CHECK (Tipo IN ("Libro","Slide","Appunti","Altro","Dispense"));

