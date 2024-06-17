-- Insertion des données dans la table personne
INSERT INTO personne (id, nom, prenom, num_bureau, mail, img) VALUES
('550e8400-e29b-41d4-a716-446655440000', 'Dupont', 'Jean', 101, 'jean.dupont@example.com', 'img1.jpg'),
('550e8400-e29b-41d4-a716-446655440001', 'Martin', 'Alice', 102, 'alice.martin@example.com', 'img2.jpg');

-- Insertion des données dans la table numero
INSERT INTO numero (id, id_perso, numero, libelle) VALUES
('650e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440000', 1234567890, 'Mobile'),
('650e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440001', 9876543210, 'Fixe');

-- Insertion des données dans la table service
INSERT INTO service (id, libelle, description) VALUES
('750e8400-e29b-41d4-a716-446655440000', 'Informatique', 'Gestion des systèmes informatiques'),
('750e8400-e29b-41d4-a716-446655440001', 'Ressources Humaines', 'Gestion du personnel');

-- Insertion des données dans la table departement
INSERT INTO departement (id, libelle, description, etage) VALUES
('850e8400-e29b-41d4-a716-446655440000', 'Développement', 'Département de développement logiciel',2),
('850e8400-e29b-41d4-a716-446655440001', 'Support', 'Département de support technique',5);

-- Insertion des données dans la table perso2dept
INSERT INTO perso2dept (id_perso, id_dept) VALUES
('550e8400-e29b-41d4-a716-446655440000', '850e8400-e29b-41d4-a716-446655440000'),
('550e8400-e29b-41d4-a716-446655440001', '850e8400-e29b-41d4-a716-446655440001');

-- Insertion des données dans la table fonction
INSERT INTO fonction (id, id_service, libelle, description) VALUES
('950e8400-e29b-41d4-a716-446655440000', '750e8400-e29b-41d4-a716-446655440000', 'Développeur', 'Développeur de logiciels'),
('950e8400-e29b-41d4-a716-446655440001', '750e8400-e29b-41d4-a716-446655440001', 'RH Manager', 'Manager des ressources humaines');

-- Insertion des données dans la table perso2service
INSERT INTO perso2service (id_perso, id_service) VALUES
('550e8400-e29b-41d4-a716-446655440000', '750e8400-e29b-41d4-a716-446655440000'),
('550e8400-e29b-41d4-a716-446655440001', '750e8400-e29b-41d4-a716-446655440001');
