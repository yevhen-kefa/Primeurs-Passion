--
-- PostgreSQL database dump
--

-- Dumped from database version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: sae_anomalie_id_anomalie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_anomalie_id_anomalie_seq
    START WITH 3
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_anomalie_id_anomalie_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: sae_anomalies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_anomalies (
    id_anomalie integer DEFAULT nextval('public.sae_anomalie_id_anomalie_seq'::regclass) NOT NULL,
    id_commandes integer NOT NULL,
    description character varying(255) NOT NULL,
    date_facture timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    solution character varying(255)
);


ALTER TABLE public.sae_anomalies OWNER TO postgres;

--
-- Name: sae_anomalies_id_anomalie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_anomalies_id_anomalie_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_anomalies_id_anomalie_seq OWNER TO postgres;

--
-- Name: sae_anomalies_id_anomalie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_anomalies_id_anomalie_seq OWNED BY public.sae_anomalies.id_anomalie;


--
-- Name: sae_article; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_article (
    id_article integer NOT NULL,
    categorie character varying(50) NOT NULL,
    code_article integer NOT NULL
);


ALTER TABLE public.sae_article OWNER TO postgres;

--
-- Name: sae_article_id_article_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_article_id_article_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_article_id_article_seq OWNER TO postgres;

--
-- Name: sae_article_id_article_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_article_id_article_seq OWNED BY public.sae_article.id_article;


--
-- Name: sae_categorie_article; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_categorie_article (
    code_article integer NOT NULL
);


ALTER TABLE public.sae_categorie_article OWNER TO postgres;

--
-- Name: sae_categorie_article_code_article_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_categorie_article_code_article_seq
    START WITH 5
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_categorie_article_code_article_seq OWNER TO postgres;

--
-- Name: sae_categorie_client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_categorie_client (
    code_client integer NOT NULL,
    nomtarif character varying(50) NOT NULL
);


ALTER TABLE public.sae_categorie_client OWNER TO postgres;

--
-- Name: sae_categorie_client_code_client_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_categorie_client_code_client_seq
    START WITH 8
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_categorie_client_code_client_seq OWNER TO postgres;

--
-- Name: sae_client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_client (
    id_client integer NOT NULL,
    code_client character varying(7) NOT NULL,
    nom character varying(50) NOT NULL,
    prenom character varying(50) NOT NULL,
    adresse character varying(100) NOT NULL,
    tel character varying(20),
    categorie_client integer NOT NULL,
    is_admin boolean DEFAULT false,
    pass character varying(255) NOT NULL,
    email character varying(100) NOT NULL
);


ALTER TABLE public.sae_client OWNER TO postgres;

--
-- Name: sae_client_id_client_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_client_id_client_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_client_id_client_seq OWNER TO postgres;

--
-- Name: sae_client_id_client_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_client_id_client_seq OWNED BY public.sae_client.id_client;


--
-- Name: sae_colis; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_colis (
    id_colis integer NOT NULL,
    id_commandes integer NOT NULL,
    numero_tournee integer NOT NULL,
    id_preparateur integer NOT NULL,
    total_colis integer NOT NULL
);


ALTER TABLE public.sae_colis OWNER TO postgres;

--
-- Name: sae_colis_id_colis_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_colis_id_colis_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_colis_id_colis_seq OWNER TO postgres;

--
-- Name: sae_colis_id_colis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_colis_id_colis_seq OWNED BY public.sae_colis.id_colis;


--
-- Name: sae_commande_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_commande_items (
    id_item integer NOT NULL,
    id_commande integer NOT NULL,
    id_variete integer NOT NULL,
    quantite integer NOT NULL
);


ALTER TABLE public.sae_commande_items OWNER TO postgres;

--
-- Name: sae_commande_items_id_item_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_commande_items_id_item_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_commande_items_id_item_seq OWNER TO postgres;

--
-- Name: sae_commande_items_id_item_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_commande_items_id_item_seq OWNED BY public.sae_commande_items.id_item;


--
-- Name: sae_commandes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_commandes (
    id_commandes integer NOT NULL,
    date_enregistrement timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    id_client integer NOT NULL,
    date_commande timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.sae_commandes OWNER TO postgres;

--
-- Name: sae_commandes_id_commandes_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_commandes_id_commandes_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_commandes_id_commandes_seq OWNER TO postgres;

--
-- Name: sae_commandes_id_commandes_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_commandes_id_commandes_seq OWNED BY public.sae_commandes.id_commandes;


--
-- Name: sae_employes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_employes (
    id_employe integer NOT NULL,
    prenom character varying(50) NOT NULL,
    nom character varying(50) NOT NULL,
    date_naissance date NOT NULL,
    date_embauche date NOT NULL,
    type_contrat character varying(20) NOT NULL,
    fonction character varying(50) NOT NULL
);


ALTER TABLE public.sae_employes OWNER TO postgres;

--
-- Name: sae_employes_id_employe_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_employes_id_employe_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_employes_id_employe_seq OWNER TO postgres;

--
-- Name: sae_employes_id_employe_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_employes_id_employe_seq OWNED BY public.sae_employes.id_employe;


--
-- Name: sae_factures; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_factures (
    id_facture integer NOT NULL,
    id_commandes integer NOT NULL,
    montant_total numeric(10,2) NOT NULL,
    remise numeric(10,2) DEFAULT 0.00,
    montant_final numeric(10,2) GENERATED ALWAYS AS ((montant_total - remise)) STORED,
    date_facture timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    type character varying(20) NOT NULL
);


ALTER TABLE public.sae_factures OWNER TO postgres;

--
-- Name: sae_factures_id_facture_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_factures_id_facture_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_factures_id_facture_seq OWNER TO postgres;

--
-- Name: sae_factures_id_facture_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_factures_id_facture_seq OWNED BY public.sae_factures.id_facture;


--
-- Name: sae_historique_prix; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_historique_prix (
    id_variete integer NOT NULL,
    code_client integer NOT NULL,
    date_debut date NOT NULL,
    date_fin date NOT NULL,
    prix integer NOT NULL
);


ALTER TABLE public.sae_historique_prix OWNER TO postgres;

--
-- Name: sae_panier; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_panier (
    id_panier integer NOT NULL,
    id_client integer NOT NULL,
    id_variete integer NOT NULL,
    quantite integer DEFAULT 1 NOT NULL,
    date_ajout timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.sae_panier OWNER TO postgres;

--
-- Name: sae_panier_id_panier_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_panier_id_panier_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_panier_id_panier_seq OWNER TO postgres;

--
-- Name: sae_panier_id_panier_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_panier_id_panier_seq OWNED BY public.sae_panier.id_panier;


--
-- Name: sae_produits_commandes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_produits_commandes (
    id_commandes integer NOT NULL,
    id_variete integer NOT NULL,
    quantite integer NOT NULL,
    poids_reel real
);


ALTER TABLE public.sae_produits_commandes OWNER TO postgres;

--
-- Name: sae_variete; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sae_variete (
    id_variete integer NOT NULL,
    code_variete character varying(20) NOT NULL,
    nom character varying(50) NOT NULL,
    calibre character varying(50) NOT NULL,
    prix integer,
    id_article integer NOT NULL
);


ALTER TABLE public.sae_variete OWNER TO postgres;

--
-- Name: sae_variete_id_variete_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sae_variete_id_variete_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sae_variete_id_variete_seq OWNER TO postgres;

--
-- Name: sae_variete_id_variete_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sae_variete_id_variete_seq OWNED BY public.sae_variete.id_variete;


--
-- Name: sae_article id_article; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_article ALTER COLUMN id_article SET DEFAULT nextval('public.sae_article_id_article_seq'::regclass);


--
-- Name: sae_client id_client; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_client ALTER COLUMN id_client SET DEFAULT nextval('public.sae_client_id_client_seq'::regclass);


--
-- Name: sae_colis id_colis; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_colis ALTER COLUMN id_colis SET DEFAULT nextval('public.sae_colis_id_colis_seq'::regclass);


--
-- Name: sae_commande_items id_item; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_commande_items ALTER COLUMN id_item SET DEFAULT nextval('public.sae_commande_items_id_item_seq'::regclass);


--
-- Name: sae_commandes id_commandes; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_commandes ALTER COLUMN id_commandes SET DEFAULT nextval('public.sae_commandes_id_commandes_seq'::regclass);


--
-- Name: sae_employes id_employe; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_employes ALTER COLUMN id_employe SET DEFAULT nextval('public.sae_employes_id_employe_seq'::regclass);


--
-- Name: sae_factures id_facture; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_factures ALTER COLUMN id_facture SET DEFAULT nextval('public.sae_factures_id_facture_seq'::regclass);


--
-- Name: sae_panier id_panier; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_panier ALTER COLUMN id_panier SET DEFAULT nextval('public.sae_panier_id_panier_seq'::regclass);


--
-- Name: sae_variete id_variete; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_variete ALTER COLUMN id_variete SET DEFAULT nextval('public.sae_variete_id_variete_seq'::regclass);


--
-- Data for Name: sae_anomalies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_anomalies (id_anomalie, id_commandes, description, date_facture, solution) FROM stdin;
1	1	Erreur de poids pour le produit Golden	2025-01-05 21:20:38	Recalcul du prix effectué
2	3	Produit Fraise hors saison	2025-01-05 21:20:38	Remplacement par Fraise congelée
\.


--
-- Data for Name: sae_article; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_article (id_article, categorie, code_article) FROM stdin;
1	Fruits	1
2	Légumes	2
3	Fruits exotiques	3
4	Fruits secs	4
\.


--
-- Data for Name: sae_categorie_article; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_categorie_article (code_article) FROM stdin;
1
2
3
4
\.


--
-- Data for Name: sae_categorie_client; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_categorie_client (code_client, nomtarif) FROM stdin;
1	Personnel
2	Boulangerie
3	Traiteur
4	Collectivités
5	Restauration1
6	Restauration2
7	Restauration3
\.


--
-- Data for Name: sae_client; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_client (id_client, code_client, nom, prenom, adresse, tel, categorie_client, is_admin, pass, email) FROM stdin;
7	CADMADM	admin	admin		+33614446674	2	t	$2y$10$BOjpJqLLPHNCah2AJwxeb.gZUdDE56yOt5pG.tHAyeFABqO2QC2dK	u@gmail.com
8	CTESUSE	Test	User	127 Ryue	+33604446678	2	f	$2y$10$oUs02L.7I6q1PgdVRYWOeed6MbHCeVYAQOsQns9a8ffHbI21iyL5C	uu@gmail.com
1	CABEROY	dsqd	dqdsq	qsdq	+330604444444	1	f	$2y$10$fR.TUdm.0hRwK3rMVNC5/ek5DwN5S3Bwx9QuT8NghqVwyFM7TNvUG	dsds@gmail.com
\.


--
-- Data for Name: sae_colis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_colis (id_colis, id_commandes, numero_tournee, id_preparateur, total_colis) FROM stdin;
1	1	3	1	2
2	2	5	2	1
3	3	1	3	1
\.


--
-- Data for Name: sae_commande_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_commande_items (id_item, id_commande, id_variete, quantite) FROM stdin;
1	4	1	4
2	4	2	3
3	4	3	2
4	5	7	3
5	6	2	1
6	6	16	1
7	6	9	3
8	7	1	1
9	7	2	2
10	7	7	1
11	7	9	1
12	7	3	5
\.


--
-- Data for Name: sae_commandes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_commandes (id_commandes, date_enregistrement, id_client, date_commande) FROM stdin;
1	2025-01-05 21:09:44	1	2025-05-26 12:55:55.78813
2	2025-01-05 21:09:44	1	2025-05-26 12:55:55.78813
3	2025-01-05 21:09:44	1	2025-05-26 12:55:55.78813
4	2025-05-26 12:58:12.227954	7	2025-05-26 12:58:12.227954
5	2025-05-26 13:05:36.567619	8	2025-05-26 13:05:36.567619
6	2025-05-26 15:09:21.967417	7	2025-05-26 15:09:21.967417
7	2025-05-26 16:05:38.635012	7	2025-05-26 16:05:38.635012
\.


--
-- Data for Name: sae_employes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_employes (id_employe, prenom, nom, date_naissance, date_embauche, type_contrat, fonction) FROM stdin;
1	Jean	Dupont	1985-06-15	2010-03-01	CDI	Préparateur
2	Marie	Curie	1990-11-23	2015-08-12	CDI	Préparateur
3	Albert	Einstein	1975-03-14	2000-05-10	CDI	Préparateur
4	Elisa	Lambert	1992-09-12	2020-07-05	CDD	Saisie des commandes
\.


--
-- Data for Name: sae_factures; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_factures (id_facture, id_commandes, montant_total, remise, date_facture, type) FROM stdin;
1	1	500.00	10.00	2025-01-05 21:20:38	Standard
2	2	950.00	20.00	2025-01-05 21:20:38	Express
3	3	400.00	5.00	2025-01-05 21:20:38	Standard
\.


--
-- Data for Name: sae_historique_prix; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_historique_prix (id_variete, code_client, date_debut, date_fin, prix) FROM stdin;
1	3	2024-01-01	2024-03-31	140
2	4	2024-01-01	2024-03-31	175
6	2	2024-01-01	2024-03-31	240
\.


--
-- Data for Name: sae_panier; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_panier (id_panier, id_client, id_variete, quantite, date_ajout) FROM stdin;
\.


--
-- Data for Name: sae_produits_commandes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_produits_commandes (id_commandes, id_variete, quantite, poids_reel) FROM stdin;
1	1	3	2.8
1	4	2	1.9
2	2	10	9.8
3	6	2	1.95
\.


--
-- Data for Name: sae_variete; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sae_variete (id_variete, code_variete, nom, calibre, prix, id_article) FROM stdin;
1	PMGO7001	Golden	70	150	1
2	PMFU8002	Fuji	80	180	1
3	PEFL6001	Flamingo	60	200	1
4	CBAN9001	Banane	90	120	1
5	CORA7001	Orange	70	\N	1
6	CFRA5002	Fraise	50	250	1
7	20001	Tomate	70	100	2
9	20003	Carotte	60	90	2
10	20004	Poivron	75	110	2
11	20005	Aubergine	85	130	3
13	FRT10001	Pomme	80	100	1
14	FRT30001	Mangue	90	150	3
15	FRT40001	Noix	50	200	4
8	20002	Concombre	80	120	2
16	FRT30002	Papaye	85	170	3
17	FRT30003	Ananas	90	200	3
18	FRT40002	Amande	40	210	4
19	FRT40003	Noisette	45	180	4
20	FRT40004	Pistache	50	220	4
\.


--
-- Name: sae_anomalie_id_anomalie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_anomalie_id_anomalie_seq', 3, false);


--
-- Name: sae_anomalies_id_anomalie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_anomalies_id_anomalie_seq', 1, false);


--
-- Name: sae_article_id_article_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_article_id_article_seq', 1, false);


--
-- Name: sae_categorie_article_code_article_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_categorie_article_code_article_seq', 5, false);


--
-- Name: sae_categorie_client_code_client_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_categorie_client_code_client_seq', 8, false);


--
-- Name: sae_client_id_client_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_client_id_client_seq', 8, true);


--
-- Name: sae_colis_id_colis_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_colis_id_colis_seq', 3, true);


--
-- Name: sae_commande_items_id_item_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_commande_items_id_item_seq', 12, true);


--
-- Name: sae_commandes_id_commandes_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_commandes_id_commandes_seq', 7, true);


--
-- Name: sae_employes_id_employe_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_employes_id_employe_seq', 4, true);


--
-- Name: sae_factures_id_facture_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_factures_id_facture_seq', 3, true);


--
-- Name: sae_panier_id_panier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_panier_id_panier_seq', 17, true);


--
-- Name: sae_variete_id_variete_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sae_variete_id_variete_seq', 20, true);


--
-- Name: sae_anomalies sae_anomalies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_anomalies
    ADD CONSTRAINT sae_anomalies_pkey PRIMARY KEY (id_anomalie);


--
-- Name: sae_article sae_article_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_article
    ADD CONSTRAINT sae_article_pkey PRIMARY KEY (id_article);


--
-- Name: sae_categorie_article sae_categorie_article_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_categorie_article
    ADD CONSTRAINT sae_categorie_article_pkey PRIMARY KEY (code_article);


--
-- Name: sae_categorie_client sae_categorie_client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_categorie_client
    ADD CONSTRAINT sae_categorie_client_pkey PRIMARY KEY (code_client);


--
-- Name: sae_client sae_client_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_client
    ADD CONSTRAINT sae_client_email_key UNIQUE (email);


--
-- Name: sae_client sae_client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_client
    ADD CONSTRAINT sae_client_pkey PRIMARY KEY (id_client);


--
-- Name: sae_colis sae_colis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_colis
    ADD CONSTRAINT sae_colis_pkey PRIMARY KEY (id_colis);


--
-- Name: sae_commande_items sae_commande_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_commande_items
    ADD CONSTRAINT sae_commande_items_pkey PRIMARY KEY (id_item);


--
-- Name: sae_commandes sae_commandes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_commandes
    ADD CONSTRAINT sae_commandes_pkey PRIMARY KEY (id_commandes);


--
-- Name: sae_employes sae_employes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_employes
    ADD CONSTRAINT sae_employes_pkey PRIMARY KEY (id_employe);


--
-- Name: sae_factures sae_factures_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_factures
    ADD CONSTRAINT sae_factures_pkey PRIMARY KEY (id_facture);


--
-- Name: sae_panier sae_panier_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_panier
    ADD CONSTRAINT sae_panier_pkey PRIMARY KEY (id_panier);


--
-- Name: sae_variete sae_variete_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_variete
    ADD CONSTRAINT sae_variete_pkey PRIMARY KEY (id_variete);


--
-- Name: sae_anomalies fk_anomalies_commandes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_anomalies
    ADD CONSTRAINT fk_anomalies_commandes FOREIGN KEY (id_commandes) REFERENCES public.sae_commandes(id_commandes);


--
-- Name: sae_article fk_article_categorie; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_article
    ADD CONSTRAINT fk_article_categorie FOREIGN KEY (code_article) REFERENCES public.sae_categorie_article(code_article);


--
-- Name: sae_client fk_client_categorie; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_client
    ADD CONSTRAINT fk_client_categorie FOREIGN KEY (categorie_client) REFERENCES public.sae_categorie_client(code_client);


--
-- Name: sae_colis fk_colis_commandes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_colis
    ADD CONSTRAINT fk_colis_commandes FOREIGN KEY (id_commandes) REFERENCES public.sae_commandes(id_commandes);


--
-- Name: sae_colis fk_colis_preparateur; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_colis
    ADD CONSTRAINT fk_colis_preparateur FOREIGN KEY (id_preparateur) REFERENCES public.sae_employes(id_employe);


--
-- Name: sae_commandes fk_commandes_client; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_commandes
    ADD CONSTRAINT fk_commandes_client FOREIGN KEY (id_client) REFERENCES public.sae_client(id_client);


--
-- Name: sae_factures fk_factures_commandes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_factures
    ADD CONSTRAINT fk_factures_commandes FOREIGN KEY (id_commandes) REFERENCES public.sae_commandes(id_commandes);


--
-- Name: sae_historique_prix fk_historique_client; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_historique_prix
    ADD CONSTRAINT fk_historique_client FOREIGN KEY (code_client) REFERENCES public.sae_categorie_client(code_client);


--
-- Name: sae_historique_prix fk_historique_variete; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_historique_prix
    ADD CONSTRAINT fk_historique_variete FOREIGN KEY (id_variete) REFERENCES public.sae_variete(id_variete);


--
-- Name: sae_panier fk_panier_client; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_panier
    ADD CONSTRAINT fk_panier_client FOREIGN KEY (id_client) REFERENCES public.sae_client(id_client) ON DELETE CASCADE;


--
-- Name: sae_panier fk_panier_variete; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_panier
    ADD CONSTRAINT fk_panier_variete FOREIGN KEY (id_variete) REFERENCES public.sae_variete(id_variete) ON DELETE CASCADE;


--
-- Name: sae_produits_commandes fk_produits_commandes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_produits_commandes
    ADD CONSTRAINT fk_produits_commandes FOREIGN KEY (id_commandes) REFERENCES public.sae_commandes(id_commandes);


--
-- Name: sae_produits_commandes fk_produits_variete; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_produits_commandes
    ADD CONSTRAINT fk_produits_variete FOREIGN KEY (id_variete) REFERENCES public.sae_variete(id_variete);


--
-- Name: sae_variete fk_variete_article; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_variete
    ADD CONSTRAINT fk_variete_article FOREIGN KEY (id_article) REFERENCES public.sae_article(id_article);


--
-- Name: sae_commande_items sae_commande_items_id_commande_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_commande_items
    ADD CONSTRAINT sae_commande_items_id_commande_fkey FOREIGN KEY (id_commande) REFERENCES public.sae_commandes(id_commandes) ON DELETE CASCADE;


--
-- Name: sae_commande_items sae_commande_items_id_variete_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sae_commande_items
    ADD CONSTRAINT sae_commande_items_id_variete_fkey FOREIGN KEY (id_variete) REFERENCES public.sae_variete(id_variete);


--
-- PostgreSQL database dump complete
--

