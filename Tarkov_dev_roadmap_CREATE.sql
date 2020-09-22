-- CREATE SQL for tarkov_dev_roadmap

-- tables
-- Table: cadastro
CREATE TABLE cadastro (
    id_cad int unsigned NOT NULL AUTO_INCREMENT,
    nome text NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(200) NOT NULL,
    CONSTRAINT cadastro_pk PRIMARY KEY (id_cad)
);

-- Table: updates
CREATE TABLE updates (
    id_update int unsigned NOT NULL AUTO_INCREMENT,
    updateName text NOT NULL,
    estimatedDate text NOT NULL,
    extraInformation longtext NOT NULL,
	isWipe boolean NOT NULL,
    CONSTRAINT updates_pk PRIMARY KEY (id_update)
);

-- End of file.

