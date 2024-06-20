CREATE TABLE personne (
    id CHAR(36),
    nom VARCHAR(20),
    prenom VARCHAR(20),
    num_bureau VARCHAR(5),
    mail VARCHAR(50),
    img VARCHAR(200),
    statut INT,
    PRIMARY KEY (id)
);

CREATE TABLE administrator (
    id CHAR(36),
    mdp VARCHAR(80),
    mail VARCHAR(50),
    role INT,
    PRIMARY KEY (id)
);

CREATE TABLE numero (
    id CHAR(36),
    id_perso CHAR(36),
    numero VARCHAR(10),
    libelle VARCHAR(30),
    PRIMARY KEY (id),
    FOREIGN KEY (id_perso) REFERENCES personne(id)
);

CREATE TABLE service (
    id CHAR(36),
    libelle VARCHAR(30),
    description VARCHAR(50),
    PRIMARY KEY (id)
);

CREATE TABLE departement (
    id CHAR(36),
    libelle VARCHAR(30),
    description VARCHAR(50),
    etage INT,
    PRIMARY KEY (id)
);

CREATE TABLE perso2dept (
    id_perso CHAR(36),
    id_dept CHAR(36),
    PRIMARY KEY (id_perso, id_dept),
    FOREIGN KEY (id_perso) REFERENCES personne(id),
    FOREIGN KEY (id_dept) REFERENCES departement(id)
);

CREATE TABLE fonction (
    id CHAR(36),
    id_service CHAR(36),
    libelle VARCHAR(30),
    description VARCHAR(50),
    PRIMARY KEY (id),
    FOREIGN KEY (id_service) REFERENCES service(id)
);

CREATE TABLE perso2service (
    id_perso CHAR(36),
    id_service CHAR(36),
    PRIMARY KEY (id_perso, id_service),
    FOREIGN KEY (id_perso) REFERENCES personne(id),
    FOREIGN KEY (id_service) REFERENCES service(id)
);

