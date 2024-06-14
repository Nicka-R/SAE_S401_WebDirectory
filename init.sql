CREATE TABLE personne (
    id CHAR(36),
    nom VARCHAR(20),
    prenom VARCHAR(20),
    num_bureau INT,
    mail VARCHAR(30),
    img VARCHAR(20),
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

CREATE TABLE perso2fonction (
    id_perso CHAR(36),
    id_fonction CHAR(36),
    PRIMARY KEY (id_perso, id_fonction),
    FOREIGN KEY (id_perso) REFERENCES personne(id),
    FOREIGN KEY (id_fonction) REFERENCES fonction(id)
);
