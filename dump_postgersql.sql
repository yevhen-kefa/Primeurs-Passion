CREATE TABLE SAE_Anomalies (
    Id_Anomalie SERIAL PRIMARY KEY,
    Id_Commandes INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    date_facture TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    solution VARCHAR(255)
);

INSERT INTO SAE_Anomalies (Id_Anomalie, Id_Commandes, description, date_facture, solution) VALUES
(1, 1, 'Erreur de poids pour le produit Golden', '2025-01-05 21:20:38', 'Recalcul du prix effectué'),
(2, 3, 'Produit Fraise hors saison', '2025-01-05 21:20:38', 'Remplacement par Fraise congelée');

CREATE TABLE SAE_Article (
    Id_Article SERIAL PRIMARY KEY,
    categorie VARCHAR(50) NOT NULL,
    code_article INT NOT NULL
);

INSERT INTO SAE_Article (Id_Article, categorie, code_article) VALUES
(1, 'Fruits', 1),
(2, 'Légumes', 2),
(3, 'Fruits exotiques', 3),
(4, 'Fruits secs', 4);

CREATE TABLE SAE_Categorie_article (
    code_article INT PRIMARY KEY
);

INSERT INTO SAE_Categorie_article (code_article) VALUES
(1),
(2),
(3),
(4);

CREATE TABLE SAE_Categorie_client (
    code_Client INT PRIMARY KEY,
    nomTarif VARCHAR(50) NOT NULL
);

INSERT INTO SAE_Categorie_client (code_Client, nomTarif) VALUES
(1, 'Personnel'),
(2, 'Boulangerie'),
(3, 'Traiteur'),
(4, 'Collectivités'),
(5, 'Restauration1'),
(6, 'Restauration2'),
(7, 'Restauration3');

CREATE TABLE SAE_Client (
    Id_Client SERIAL PRIMARY KEY,
    code_Client VARCHAR(7) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse VARCHAR(100) NOT NULL,
    tel VARCHAR(20),
    categorie_client INT NOT NULL
);

INSERT INTO SAE_Client (Id_Client, code_Client, nom, prenom, adresse, tel, categorie_client) VALUES
(1, 'CABEROY', 'Abeille Royale', '', '123 Rue des Abeilles', '0102030405', 3),
(2, 'CAUMOAR', 'Au Mont d’Arbois', '', '456 Rue des Sommets', '0203040506', 4),
(3, 'CSAPERL', 'Saperlipopette', '', '789 Rue de la Fantaisie', '0304050607', 2);


-- Structure du tableau `SAE_Colis`
CREATE TABLE SAE_Colis (
  Id_Colis SERIAL PRIMARY KEY,
  Id_Commandes INT NOT NULL,
  numero_tournee INT NOT NULL,
  Id_Preparateur INT NOT NULL,
  total_colis INT NOT NULL
);

-- Dump les données de la table `SAE_Colis`
INSERT INTO SAE_Colis (Id_Commandes, numero_tournee, Id_Preparateur, total_colis) VALUES
(1, 3, 1, 2),
(2, 5, 2, 1),
(3, 1, 3, 1);

-- Structure du tableau `SAE_Commandes`
CREATE TABLE SAE_Commandes (
  Id_Commandes SERIAL PRIMARY KEY,
  quantite INT NOT NULL,
  date_livraison DATE NOT NULL,
  date_enregistrement TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Id_Preparateur INT NOT NULL,
  numero_tournee INT NOT NULL,
  saisie_par INT NOT NULL
);

-- Dump les données de la table `SAE_Commandes`
INSERT INTO SAE_Commandes (quantite, date_livraison, date_enregistrement, Id_Preparateur, numero_tournee, saisie_par) VALUES
(5, '2024-01-05', '2025-01-05 21:09:44', 1, 3, 4),
(10, '2024-01-06', '2025-01-05 21:09:44', 2, 5, 4),
(2, '2024-01-07', '2025-01-05 21:09:44', 3, 1, 4);

-- Structure du tableau `SAE_Employes`
CREATE TABLE SAE_Employes (
  Id_Employe SERIAL PRIMARY KEY,
  prenom VARCHAR(50) NOT NULL,
  nom VARCHAR(50) NOT NULL,
  date_naissance DATE NOT NULL,
  date_embauche DATE NOT NULL,
  type_contrat VARCHAR(20) NOT NULL,
  fonction VARCHAR(50) NOT NULL
);

-- Dump les données de la table `SAE_Employes`
INSERT INTO SAE_Employes (prenom, nom, date_naissance, date_embauche, type_contrat, fonction) VALUES
('Jean', 'Dupont', '1985-06-15', '2010-03-01', 'CDI', 'Préparateur'),
('Marie', 'Curie', '1990-11-23', '2015-08-12', 'CDI', 'Préparateur'),
('Albert', 'Einstein', '1975-03-14', '2000-05-10', 'CDI', 'Préparateur'),
('Elisa', 'Lambert', '1992-09-12', '2020-07-05', 'CDD', 'Saisie des commandes');

-- Structure du tableau `SAE_Factures`
CREATE TABLE SAE_Factures (
  Id_Facture SERIAL PRIMARY KEY,
  Id_Commandes INT NOT NULL,
  montant_total DECIMAL(10,2) NOT NULL,
  remise DECIMAL(10,2) DEFAULT 0.00,
  montant_final DECIMAL(10,2) GENERATED ALWAYS AS (montant_total - remise) STORED,
  date_facture TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  type VARCHAR(20) NOT NULL
);

-- Dump les données de la table `SAE_Factures`
INSERT INTO SAE_Factures (Id_Commandes, montant_total, remise, date_facture, type) VALUES
(1, 500.00, 10.00, '2025-01-05 21:20:38', 'Standard'),
(2, 950.00, 20.00, '2025-01-05 21:20:38', 'Express'),
(3, 400.00, 5.00, '2025-01-05 21:20:38', 'Standard');

-- Structure du tableau `SAE_Historique_prix`
CREATE TABLE SAE_Historique_prix (
  Id_Variete INT NOT NULL,
  code_Client INT NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  prix INT NOT NULL
);

-- Dump les données de la table `SAE_Historique_prix`
INSERT INTO SAE_Historique_prix (Id_Variete, code_Client, date_debut, date_fin, prix) VALUES
(1, 3, '2024-01-01', '2024-03-31', 140),
(2, 4, '2024-01-01', '2024-03-31', 175),
(6, 2, '2024-01-01', '2024-03-31', 240);

-- Structure du tableau `SAE_Produits_commandes`
CREATE TABLE SAE_Produits_commandes (
  Id_Commandes INT NOT NULL,
  Id_Variete INT NOT NULL,
  quantite INT NOT NULL,
  poids_reel REAL DEFAULT NULL
);

-- Dump les données de la table `SAE_Produits_commandes`
INSERT INTO SAE_Produits_commandes (Id_Commandes, Id_Variete, quantite, poids_reel) VALUES
(1, 1, 3, 2.8),
(1, 4, 2, 1.9),
(2, 2, 10, 9.8),
(3, 6, 2, 1.95);

-- Structure du tableau `SAE_Variete`
CREATE TABLE SAE_Variete (
  Id_Variete SERIAL PRIMARY KEY,
  code_variete VARCHAR(20) NOT NULL,
  nom VARCHAR(50) NOT NULL,
  calibre VARCHAR(50) NOT NULL,
  prix INT DEFAULT NULL
);

-- Dump les données de la table `SAE_Variete`
INSERT INTO SAE_Variete (code_variete, nom, calibre, prix) VALUES
('PMGO7001', 'Golden', '70', 150),
('PMFU8002', 'Fuji', '80', 180),
('PEFL6001', 'Flamingo', '60', 200),
('CBAN9001', 'Banane', '90', 120),
('CORA7001', 'Orange', '70', NULL),
('CFRA5002', 'Fraise', '50', 250);


-- Indices de la table `SAE_Anomalies`
ALTER TABLE SAE_Anomalies
  ADD PRIMARY KEY (Id_Anomalie),
  ADD INDEX Id_Commandes_idx (Id_Commandes);

-- Indices de la table `SAE_Article`
ALTER TABLE SAE_Article
  ADD PRIMARY KEY (Id_Article),
  ADD INDEX code_article_idx (code_article);

-- Indices de la table `SAE_Categorie_article`
ALTER TABLE SAE_Categorie_article
  ADD PRIMARY KEY (code_article);

-- Indices de la table `SAE_Categorie_client`
ALTER TABLE SAE_Categorie_client
  ADD PRIMARY KEY (code_Client);

-- Indices de la table `SAE_Client`
ALTER TABLE SAE_Client
  ADD PRIMARY KEY (Id_Client),
  ADD CONSTRAINT code_Client_unique UNIQUE (code_Client),
  ADD INDEX categorie_client_idx (categorie_client);

-- Indices de la table `SAE_Colis`
ALTER TABLE SAE_Colis
  ADD PRIMARY KEY (Id_Colis),
  ADD INDEX Id_Commandes_idx (Id_Commandes),
  ADD INDEX Id_Preparateur_idx (Id_Preparateur);

-- Indices de la table `SAE_Commandes`
ALTER TABLE SAE_Commandes
  ADD PRIMARY KEY (Id_Commandes),
  ADD INDEX Id_Preparateur_idx (Id_Preparateur),
  ADD INDEX saisie_par_idx (saisie_par);

-- Indices de la table `SAE_Employes`
ALTER TABLE SAE_Employes
  ADD PRIMARY KEY (Id_Employe);

-- Indices de la table `SAE_Factures`
ALTER TABLE SAE_Factures
  ADD PRIMARY KEY (Id_Facture),
  ADD INDEX Id_Commandes_idx (Id_Commandes);

-- Indices de la table `SAE_Historique_prix`
ALTER TABLE SAE_Historique_prix
  ADD PRIMARY KEY (Id_Variete, code_Client, date_debut),
  ADD INDEX code_Client_idx (code_Client);

-- Indices de la table `SAE_Produits_commandes`
ALTER TABLE SAE_Produits_commandes
  ADD PRIMARY KEY (Id_Commandes, Id_Variete),
  ADD INDEX Id_Variete_idx (Id_Variete);

-- Indices de la table `SAE_Variete`.
ALTER TABLE SAE_Variete
  ADD PRIMARY KEY (Id_Variete);


-- AUTO_INCREMENT pour la table `SAE_Anomalies`
ALTER TABLE "SAE_Anomalies"
  ALTER COLUMN "Id_Anomalie" SET DEFAULT nextval('SAE_Anomalie_Id_Anomalie_seq');

-- AUTO_INCREMENT pour la table `SAE_Article`
ALTER TABLE "SAE_Article"
  ALTER COLUMN "Id_Article" SET DEFAULT nextval('SAE_Article_Id_Article_seq');

-- AUTO_INCREMENT pour la table `SAE_Categorie_article`
ALTER TABLE "SAE_Categorie_article"
  ALTER COLUMN "code_article" SET DEFAULT nextval('SAE_Categorie_article_code_article_seq');

-- AUTO_INCREMENT pour la table `SAE_Categorie_client`
ALTER TABLE "SAE_Categorie_client"
  ALTER COLUMN "code_Client" SET DEFAULT nextval('SAE_Categorie_client_code_Client_seq');

-- AUTO_INCREMENT pour la table `SAE_Client`
ALTER TABLE "SAE_Client"
  ALTER COLUMN "Id_Client" SET DEFAULT nextval('SAE_Client_Id_Client_seq');

-- AUTO_INCREMENT pour la table `SAE_Colis`
ALTER TABLE "SAE_Colis"
  ALTER COLUMN "Id_Colis" SET DEFAULT nextval('SAE_Colis_Id_Colis_seq');

-- AUTO_INCREMENT pour la table `SAE_Commandes`
ALTER TABLE "SAE_Commandes"
  ALTER COLUMN "Id_Commandes" SET DEFAULT nextval('SAE_Commandes_Id_Commandes_seq');

-- AUTO_INCREMENT pour la table `SAE_Employes`
ALTER TABLE "SAE_Employes"
  ALTER COLUMN "Id_Employe" SET DEFAULT nextval('SAE_Employes_Id_Employe_seq');

-- AUTO_INCREMENT pour la table `SAE_Factures`
ALTER TABLE "SAE_Factures"
  ALTER COLUMN "Id_Facture" SET DEFAULT nextval('SAE_Factures_Id_Facture_seq');

-- AUTO_INCREMENT pour la table `SAE_Variete`
ALTER TABLE "SAE_Variete"
  ALTER COLUMN "Id_Variete" SET DEFAULT nextval('SAE_Variete_Id_Variete_seq');


-- Créer des séquences pour les incréments automatiques
CREATE SEQUENCE SAE_Anomalie_Id_Anomalie_seq START 3;
CREATE SEQUENCE SAE_Article_Id_Article_seq START 5;
CREATE SEQUENCE SAE_Categorie_article_code_article_seq START 5;
CREATE SEQUENCE SAE_Categorie_client_code_Client_seq START 8;
CREATE SEQUENCE SAE_Client_Id_Client_seq START 4;
CREATE SEQUENCE SAE_Colis_Id_Colis_seq START 4;
CREATE SEQUENCE SAE_Commandes_Id_Commandes_seq START 7;
CREATE SEQUENCE SAE_Employes_Id_Employe_seq START 5;
CREATE SEQUENCE SAE_Factures_Id_Facture_seq START 4;
CREATE SEQUENCE SAE_Variete_Id_Variete_seq START 7;


-- Restreindre la clé étrangère d'une table `SAE_Anomalies`
ALTER TABLE "SAE_Anomalies"
  ADD CONSTRAINT "SAE_Anomalies_ibfk_1" FOREIGN KEY ("Id_Commandes") REFERENCES "SAE_Commandes" ("Id_Commandes");

-- Restreindre la clé étrangère d'une table `SAE_Article`
ALTER TABLE "SAE_Article"
  ADD CONSTRAINT "SAE_Article_ibfk_1" FOREIGN KEY ("code_article") REFERENCES "SAE_Categorie_article" ("code_article");

-- Restreindre la clé étrangère d'une table `SAE_Client`
ALTER TABLE "SAE_Client"
  ADD CONSTRAINT "SAE_Client_ibfk_1" FOREIGN KEY ("categorie_client") REFERENCES "SAE_Categorie_client" ("code_Client");

-- Restreindre la clé étrangère d'une table `SAE_Colis`
ALTER TABLE "SAE_Colis"
  ADD CONSTRAINT "SAE_Colis_ibfk_1" FOREIGN KEY ("Id_Commandes") REFERENCES "SAE_Commandes" ("Id_Commandes"),
  ADD CONSTRAINT "SAE_Colis_ibfk_2" FOREIGN KEY ("Id_Preparateur") REFERENCES "SAE_Employes" ("Id_Employe");

-- Restreindre la clé étrangère d'une table `SAE_Commandes`
ALTER TABLE "SAE_Commandes"
  ADD CONSTRAINT "SAE_Commandes_ibfk_1" FOREIGN KEY ("Id_Preparateur") REFERENCES "SAE_Employes" ("Id_Employe"),
  ADD CONSTRAINT "SAE_Commandes_ibfk_2" FOREIGN KEY ("saisie_par") REFERENCES "SAE_Employes" ("Id_Employe");

-- Restreindre la clé étrangère d'une table `SAE_Factures`
ALTER TABLE "SAE_Factures"
  ADD CONSTRAINT "SAE_Factures_ibfk_1" FOREIGN KEY ("Id_Commandes") REFERENCES "SAE_Commandes" ("Id_Commandes");

-- Restreindre la clé étrangère d'une table `SAE_Historique_prix`
ALTER TABLE "SAE_Historique_prix"
  ADD CONSTRAINT "SAE_Historique_prix_ibfk_1" FOREIGN KEY ("Id_Variete") REFERENCES "SAE_Variete" ("Id_Variete"),
  ADD CONSTRAINT "SAE_Historique_prix_ibfk_2" FOREIGN KEY ("code_Client") REFERENCES "SAE_Categorie_client" ("code_Client");

-- Restreindre la clé étrangère d'une table `SAE_Produits_commandes`
ALTER TABLE "SAE_Produits_commandes"
  ADD CONSTRAINT "SAE_Produits_commandes_ibfk_1" FOREIGN KEY ("Id_Commandes") REFERENCES "SAE_Commandes" ("Id_Commandes"),
  ADD CONSTRAINT "SAE_Produits_commandes_ibfk_2" FOREIGN KEY ("Id_Variete") REFERENCES "SAE_Variete" ("Id_Variete");
