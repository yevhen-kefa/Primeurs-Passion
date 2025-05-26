-- DROP ALL TABLES IF NEEDED (optional, if re-importing)
-- DO THIS ONLY IF YOU WANT TO CLEAN THE DB:
-- DO $$ DECLARE r RECORD;
-- BEGIN
--   FOR r IN (SELECT tablename FROM pg_tables WHERE schemaname = current_schema()) LOOP
--     EXECUTE 'DROP TABLE IF EXISTS ' || quote_ident(r.tablename) || ' CASCADE';
--   END LOOP;
-- END $$;

-- === Tables ===

CREATE TABLE SAE_Anomalies (
    Id_Anomalie SERIAL PRIMARY KEY,
    Id_Commandes INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    date_facture TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    solution VARCHAR(255)
);

CREATE TABLE SAE_Article (
    Id_Article SERIAL PRIMARY KEY,
    categorie VARCHAR(50) NOT NULL,
    code_article INT NOT NULL
);

CREATE TABLE SAE_Categorie_article (
    code_article INT PRIMARY KEY
);

CREATE TABLE SAE_Categorie_client (
    code_Client INT PRIMARY KEY,
    nomTarif VARCHAR(50) NOT NULL
);

CREATE TABLE SAE_Client (
    Id_Client SERIAL PRIMARY KEY,
    code_Client VARCHAR(7) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse VARCHAR(100) NOT NULL,
    tel VARCHAR(20),
    categorie_client INT NOT NULL
);

CREATE TABLE SAE_Colis (
    Id_Colis SERIAL PRIMARY KEY,
    Id_Commandes INT NOT NULL,
    numero_tournee INT NOT NULL,
    Id_Preparateur INT NOT NULL,
    total_colis INT NOT NULL
);

CREATE TABLE SAE_Commandes (
    Id_Commandes SERIAL PRIMARY KEY,
    quantite INT NOT NULL,
    date_livraison DATE NOT NULL,
    date_enregistrement TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Id_Preparateur INT NOT NULL,
    numero_tournee INT NOT NULL,
    saisie_par INT NOT NULL
);

CREATE TABLE SAE_Employes (
    Id_Employe SERIAL PRIMARY KEY,
    prenom VARCHAR(50) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    date_naissance DATE NOT NULL,
    date_embauche DATE NOT NULL,
    type_contrat VARCHAR(20) NOT NULL,
    fonction VARCHAR(50) NOT NULL
);

CREATE TABLE SAE_Factures (
    Id_Facture SERIAL PRIMARY KEY,
    Id_Commandes INT NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    remise DECIMAL(10,2) DEFAULT 0.00,
    montant_final DECIMAL(10,2) GENERATED ALWAYS AS (montant_total - remise) STORED,
    date_facture TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type VARCHAR(20) NOT NULL
);

CREATE TABLE SAE_Historique_prix (
    Id_Variete INT NOT NULL,
    code_Client INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    prix INT NOT NULL
);

CREATE TABLE SAE_Produits_commandes ( 
    Id_Commandes INT NOT NULL,
    Id_Variete INT NOT NULL,
    quantite INT NOT NULL,
    poids_reel REAL DEFAULT NULL
);

CREATE TABLE SAE_Variete (
    Id_Variete SERIAL PRIMARY KEY,
    code_variete VARCHAR(20) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    calibre VARCHAR(50) NOT NULL,
    prix INT DEFAULT NULL
);

-- === Inserts ===

INSERT INTO SAE_Anomalies (Id_Anomalie, Id_Commandes, description, date_facture, solution) VALUES
(1, 1, 'Erreur de poids pour le produit Golden', '2025-01-05 21:20:38', 'Recalcul du prix effectué'),
(2, 3, 'Produit Fraise hors saison', '2025-01-05 21:20:38', 'Remplacement par Fraise congelée');

INSERT INTO SAE_Article (Id_Article, categorie, code_article) VALUES
(1, 'Fruits', 1),
(2, 'Légumes', 2),
(3, 'Fruits exotiques', 3),
(4, 'Fruits secs', 4);

INSERT INTO SAE_Categorie_article (code_article) VALUES
(1), (2), (3), (4);

INSERT INTO SAE_Categorie_client (code_Client, nomTarif) VALUES
(1, 'Personnel'),
(2, 'Boulangerie'),
(3, 'Traiteur'),
(4, 'Collectivités'),
(5, 'Restauration1'),
(6, 'Restauration2'),
(7, 'Restauration3');

INSERT INTO SAE_Client (Id_Client, code_Client, nom, prenom, adresse, tel, categorie_client) VALUES
(1, 'CABEROY', 'Abeille Royale', '', '123 Rue des Abeilles', '0102030405', 3),
(2, 'CAUMOAR', 'Au Mont d’Arbois', '', '456 Rue des Sommets', '0203040506', 4),
(3, 'CSAPERL', 'Saperlipopette', '', '789 Rue de la Fantaisie', '0304050607', 2);

INSERT INTO SAE_Colis (Id_Commandes, numero_tournee, Id_Preparateur, total_colis) VALUES
(1, 3, 1, 2),
(2, 5, 2, 1),
(3, 1, 3, 1);

INSERT INTO SAE_Commandes (quantite, date_livraison, date_enregistrement, Id_Preparateur, numero_tournee, saisie_par) VALUES
(5, '2024-01-05', '2025-01-05 21:09:44', 1, 3, 4),
(10, '2024-01-06', '2025-01-05 21:09:44', 2, 5, 4),
(2, '2024-01-07', '2025-01-05 21:09:44', 3, 1, 4);

INSERT INTO SAE_Employes (prenom, nom, date_naissance, date_embauche, type_contrat, fonction) VALUES
('Jean', 'Dupont', '1985-06-15', '2010-03-01', 'CDI', 'Préparateur'),
('Marie', 'Curie', '1990-11-23', '2015-08-12', 'CDI', 'Préparateur'),
('Albert', 'Einstein', '1975-03-14', '2000-05-10', 'CDI', 'Préparateur'),
('Elisa', 'Lambert', '1992-09-12', '2020-07-05', 'CDD', 'Saisie des commandes');

INSERT INTO SAE_Factures (Id_Commandes, montant_total, remise, date_facture, type) VALUES
(1, 500.00, 10.00, '2025-01-05 21:20:38', 'Standard'),
(2, 950.00, 20.00, '2025-01-05 21:20:38', 'Express'),
(3, 400.00, 5.00, '2025-01-05 21:20:38', 'Standard');

INSERT INTO SAE_Historique_prix (Id_Variete, code_Client, date_debut, date_fin, prix) VALUES
(1, 3, '2024-01-01', '2024-03-31', 140),
(2, 4, '2024-01-01', '2024-03-31', 175),
(6, 2, '2024-01-01', '2024-03-31', 240);

INSERT INTO SAE_Produits_commandes (Id_Commandes, Id_Variete, quantite, poids_reel) VALUES
(1, 1, 3, 2.8),
(1, 4, 2, 1.9),
(2, 2, 10, 9.8),
(3, 6, 2, 1.95);

INSERT INTO SAE_Variete (code_variete, nom, calibre, prix) VALUES
('PMGO7001', 'Golden', '70', 150),
('PMFU8002', 'Fuji', '80', 180),
('PEFL6001', 'Flamingo', '60', 200),
('CBAN9001', 'Banane', '90', 120),
('CORA7001', 'Orange', '70', NULL),
('CFRA5002', 'Fraise', '50', 250);

-- Clés étrangères pour la table `SAE_Anomalies`
ALTER TABLE SAE_Anomalies
  ADD CONSTRAINT fk_anomalies_commandes FOREIGN KEY (Id_Commandes) REFERENCES SAE_Commandes(Id_Commandes);

-- Clés étrangères pour la table `SAE_Client`
ALTER TABLE SAE_Client
  ADD CONSTRAINT fk_client_categorie FOREIGN KEY (categorie_client) REFERENCES SAE_Categorie_client(code_Client);

-- Clés étrangères pour la table `SAE_Colis`
ALTER TABLE SAE_Colis
  ADD CONSTRAINT fk_colis_commandes FOREIGN KEY (Id_Commandes) REFERENCES SAE_Commandes(Id_Commandes),
  ADD CONSTRAINT fk_colis_preparateur FOREIGN KEY (Id_Preparateur) REFERENCES SAE_Employes(Id_Employe);

-- Clés étrangères pour la table `SAE_Commandes`
ALTER TABLE SAE_Commandes
  ADD CONSTRAINT fk_commandes_preparateur FOREIGN KEY (Id_Preparateur) REFERENCES SAE_Employes(Id_Employe),
  ADD CONSTRAINT fk_commandes_saisie FOREIGN KEY (saisie_par) REFERENCES SAE_Employes(Id_Employe);

-- Clés étrangères pour la table `SAE_Factures`
ALTER TABLE SAE_Factures
  ADD CONSTRAINT fk_factures_commandes FOREIGN KEY (Id_Commandes) REFERENCES SAE_Commandes(Id_Commandes);

-- Clés étrangères pour la table `SAE_Historique_prix`
ALTER TABLE SAE_Historique_prix
  ADD CONSTRAINT fk_historique_variete FOREIGN KEY (Id_Variete) REFERENCES SAE_Variete(Id_Variete),
  ADD CONSTRAINT fk_historique_client FOREIGN KEY (code_Client) REFERENCES SAE_Categorie_client(code_Client);

-- Clés étrangères pour la table `SAE_Produits_commandes`
ALTER TABLE SAE_Produits_commandes
  ADD CONSTRAINT fk_produits_commandes FOREIGN KEY (Id_Commandes) REFERENCES SAE_Commandes(Id_Commandes),
  ADD CONSTRAINT fk_produits_variete FOREIGN KEY (Id_Variete) REFERENCES SAE_Variete(Id_Variete);

-- Clés étrangères pour la table `SAE_Article`
ALTER TABLE SAE_Article
  ADD CONSTRAINT fk_article_categorie FOREIGN KEY (code_article) REFERENCES SAE_Categorie_article(code_article);




-- Créer des séquences personnalisées avec une valeur de départ spécifique
CREATE SEQUENCE SAE_Anomalie_Id_Anomalie_seq START WITH 3;
CREATE SEQUENCE SAE_Article_Id_Article_seq START WITH 5;
CREATE SEQUENCE SAE_Categorie_article_code_article_seq START WITH 5;
CREATE SEQUENCE SAE_Categorie_client_code_Client_seq START WITH 8;
CREATE SEQUENCE SAE_Client_Id_Client_seq START WITH 4;
CREATE SEQUENCE SAE_Colis_Id_Colis_seq START WITH 4;
CREATE SEQUENCE SAE_Commandes_Id_Commandes_seq START WITH 7;
CREATE SEQUENCE SAE_Employes_Id_Employe_seq START WITH 5;
CREATE SEQUENCE SAE_Factures_Id_Facture_seq START WITH 4;
CREATE SEQUENCE SAE_Variete_Id_Variete_seq START WITH 7;


-- FK pour SAE_Anomalies
ALTER TABLE SAE_Anomalies
  ADD CONSTRAINT fk_anomalies_commandes FOREIGN KEY (Id_Commandes)
  REFERENCES SAE_Commandes(Id_Commandes);

-- FK pour SAE_Article
ALTER TABLE SAE_Article
  ADD CONSTRAINT fk_article_categorie FOREIGN KEY (code_article)
  REFERENCES SAE_Categorie_article(code_article);

-- FK pour SAE_Client
ALTER TABLE SAE_Client
  ADD CONSTRAINT fk_client_categorie FOREIGN KEY (categorie_client)
  REFERENCES SAE_Categorie_client(code_Client);

-- FK pour SAE_Colis
ALTER TABLE SAE_Colis
  ADD CONSTRAINT fk_colis_commandes FOREIGN KEY (Id_Commandes)
  REFERENCES SAE_Commandes(Id_Commandes),
  ADD CONSTRAINT fk_colis_preparateur FOREIGN KEY (Id_Preparateur)
  REFERENCES SAE_Employes(Id_Employe);

-- FK pour SAE_Commandes
ALTER TABLE SAE_Commandes
  ADD CONSTRAINT fk_commandes_preparateur FOREIGN KEY (Id_Preparateur)
  REFERENCES SAE_Employes(Id_Employe),
  ADD CONSTRAINT fk_commandes_saisie FOREIGN KEY (saisie_par)
  REFERENCES SAE_Employes(Id_Employe);

-- FK pour SAE_Factures
ALTER TABLE SAE_Factures
  ADD CONSTRAINT fk_factures_commandes FOREIGN KEY (Id_Commandes)
  REFERENCES SAE_Commandes(Id_Commandes);

-- FK pour SAE_Historique_prix
ALTER TABLE SAE_Historique_prix
  ADD CONSTRAINT fk_historique_variete FOREIGN KEY (Id_Variete)
  REFERENCES SAE_Variete(Id_Variete),
  ADD CONSTRAINT fk_historique_client FOREIGN KEY (code_Client)
  REFERENCES SAE_Categorie_client(code_Client);

-- FK pour SAE_Produits_commandes
ALTER TABLE SAE_Produits_commandes
  ADD CONSTRAINT fk_produits_commandes FOREIGN KEY (Id_Commandes)
  REFERENCES SAE_Commandes(Id_Commandes),
  ADD CONSTRAINT fk_produits_variete FOREIGN KEY (Id_Variete)
  REFERENCES SAE_Variete(Id_Variete);

-- Прив'язати вручну (якщо SERIAL не був використаний)
ALTER TABLE SAE_Anomalies
  ALTER COLUMN Id_Anomalie SET DEFAULT nextval('SAE_Anomalie_Id_Anomalie_seq');
