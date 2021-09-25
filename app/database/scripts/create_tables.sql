CREATE TABLE IF NOT EXISTS cargos
(
    id_cargo      SERIAL      PRIMARY KEY,
    nome_cargo    varchar(30) NOT NULL,
    descricao     varchar(60) NOT NULL
);

CREATE TABLE IF NOT EXISTS centros_de_custo
(
    id_centro_custo     SERIAL         PRIMARY KEY,
    nome_centro_custo   varchar(30)    NOT NULL        
);

CREATE TABLE IF NOT EXISTS departamentos
(
    id_departamento         SERIAL         PRIMARY KEY,
    nome_departamento       varchar(30)    NOT NULL,
    id_centro_custo_fk      SERIAL,   
    FOREIGN KEY (id_centro_custo_fk)        REFERENCES centros_de_custo(id_centro_custo)      
);

CREATE TABLE IF NOT EXISTS usuarios
(
    id_usuario            SERIAL      PRIMARY KEY ,
    nome                  varchar(60) NOT NULL,
    email                 varchar(50) NOT NULL,
    senha                 varchar(32) NOT NULL,
    dtNascimento          date,
    id_cargo_fk           SERIAL,     
    id_departamento_fk    SERIAL,      
    FOREIGN KEY (id_cargo_fk)         REFERENCES cargos(id_cargo),
    FOREIGN KEY (id_departamento_fk)  REFERENCES departamentos(id_departamento)          
);