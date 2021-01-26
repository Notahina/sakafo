CREATE DATABASE sakafo;

Create Table Etudiants(
    idetu integer  auto_increment Primary key ,
    nom varchar(60) ,
    pwd varchar(60) ,
    datenaissance Date 
);
Insert into Etudiants values (null,'Rakoto',sha1('1234'),'2000-06-11');
Insert into Etudiants values (null,'Benja',sha1('1234'),'199-06-11');


create table Categorie(
    idCategorie int auto_increment primary key,
    nomCategorie varchar(25)
)engine=innodb;

create table Plat(
    idPlat int auto_increment primary key,
    code varchar(20) not null unique,
    nomPlat varchar(25),
    prix decimal,
    idCategorie int ,
    photo text,
	foreign key (idCategorie) references Categorie(idCategorie)
)engine=innodb;

create table PlatMenu(
    idPlaMenu int auto_increment primary key,
    idPlat int,
    date date not null,
    foreign key (idPlat) references Plat(idPlat)
)engine=innodb;


create table commande(
    idcommande int auto_increment primary key,
    idplat int,
    idetudiant int,
    quantite int,
	datecommande date,
    foreign key (idetudiant) references Etudiants(idetu)
);
Create table Token(
    idtoken varchar(128) primary key not null,
    idetu integer not null,
    dateexpiration datetime not null,
    foreign key (idetu) references Etudiants(idetu)
);
 CREATE View  PlatMenuJour as select p.idPlat ,p.nomPlat,pm.date,p.prix,p.photo from Plat p join PlatMenu pm on p.idPlat=pm.idPlat;
Create View TotalPlatEtu as select c.idetudiant,c.datecommande,(Sum(p.prix)*Sum(c.quantite)) total from Plat p join commande c on p.idPlat=c.idplat group by c.idetudiant,c.datecommande;
Create view ListePlat as select p.idPlat,p.nomPlat,sum(c.quantite),c.datecommande from commande c join Plat p on c.idplat=p.idPlat ;
insert into Categorie(nomCategorie) values('soupe');
insert into Categorie(nomCategorie) values('pizza');

insert into Plat(code,nomPlat,prix,idCategorie) values('007coco','La soupe tamatave',20000,1);
insert into Plat(code,nomPlat,prix,idCategorie) values('pizza45','pizza 4 fromages ',25000,2);
insert into Plat(code,nomPlat,prix,idCategorie) values('pizza46','pizza jambon ',21000,2);

Insert into PlatMenu values(null,7,'2021-01-07');
Insert into PlatMenu values(null,8,'2021-01-07');

Insert into commande values (null,7,1,2,'2021-01-07');