/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     5.5.2017 18:04:52                            */
/*==============================================================*/

DROP TABLE IF EXISTS members;
DROP TABLE IF EXISTS referencese;
DROP TABLE IF EXISTS block_header;
DROP TABLE IF EXISTS block_members;
DROP TABLE IF EXISTS block_references;
DROP TABLE IF EXISTS userrights;
DROP TABLE IF EXISTS rights;
DROP TABLE IF EXISTS users;



/*==============================================================*/
/* Table: block_header                                                 */
/*==============================================================*/
create TABLE block_header
(
  id                    SERIAL,
  style                 TEXT,
  bg_type               varchar(255) not null DEFAULT "color",
  heading_1             varchar(255) not null DEFAULT "",
  heading_2             varchar(255) not null DEFAULT "",
  button_1              varchar(255) not null DEFAULT "",
  button_2              varchar(255) not null DEFAULT "",
  button_1_link         TEXT not null DEFAULT "",
  button_2_link         TEXT not null DEFAULT "",
  image                 VARCHAR(255) default null,
  active                SMALLINT DEFAULT 0,
  position              INTEGER not NULL DEFAULT 696969,
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;


/*==============================================================*/
/* Table: block_members                                                 */
/*==============================================================*/
create TABLE block_members
(
   id                    SERIAL,
   style                 TEXT,
   bg_type               varchar(255) not null DEFAULT "color",
   heading_1             varchar(255) not null DEFAULT "",
   image                 VARCHAR(255) default null,
   active                SMALLINT DEFAULT 0,
   position              INTEGER not NULL DEFAULT 696969,
   primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: block_references                                      */
/*==============================================================*/
create TABLE block_references
(
   id                    SERIAL,
   style                 TEXT,
   bg_type               varchar(255) not null DEFAULT "color",
   heading             varchar(255) not null DEFAULT "",
   image                 VARCHAR(255) default null,
   active                SMALLINT DEFAULT 0,
   position              INTEGER not NULL DEFAULT 696969,
   primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: members                                               */
/*==============================================================*/
create TABLE members
(
   id                    SERIAL,
   name                  varchar(255) not null DEFAULT "",
   text                  TEXT not null DEFAULT "",
   image                 VARCHAR(255) default null,
   owner                 BIGINT UNSIGNED,
   active                TINYINT not null DEFAULT 0,
   primary key (id),
   foreign key (owner) references block_members (id) on delete set null
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: referencese                                           */
/*==============================================================*/
create TABLE referencese
(
   id                    SERIAL,
   name                  varchar(255) not null DEFAULT "",
   text                  TEXT not null DEFAULT "",
   image                 VARCHAR(255) default null,
   owner                 BIGINT UNSIGNED,
   active                TINYINT not null DEFAULT 0,
   reference             TEXT not null DEFAULT "",
   primary key (id),
   foreign key (owner) references block_references (id) on delete set null
) ENGINE=InnoDB CHARACTER SET utf8
;


/*==============================================================*/
/* Table: users                                                 */
/*==============================================================*/
create table users
(
   id                   SERIAL,
   email                varchar(255) not null,
   password             varchar(255) not null,
   primary key (id),
   unique (email)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: rights                                                */
/*==============================================================*/
create table rights
(
   id             SERIAL,
   name           varchar(255) not null,
   constraint unique_rights unique (name),
   primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;


/*==============================================================*/
/* Table: userRights                                            */
/*==============================================================*/
create table userrights
(
   userId             BIGINT UNSIGNED not null,
   rightId            BIGINT UNSIGNED not null,
   primary key (userId, rightId),
   constraint FK_commonRights_usr foreign key (userId)
   references users (id),
   constraint FK_commonRights_rig foreign key (rightId)
   references rights (id)
) ENGINE=InnoDB CHARACTER SET utf8
;


INSERT INTO `rights`(`name`) VALUES ("admin");
INSERT INTO `rights`(`name`) VALUES ("headers");
INSERT INTO `rights`(`name`) VALUES ("members");
INSERT INTO `rights`(`name`) VALUES ("references");

INSERT INTO `users`(`email`, `password`) VALUES ("netj01@vse.cz", "$2y$10$4iP5iusxv7MAYDaB92moYuZdhEK.51V4j9mv7pSQbJnjP5NBG4BMa");
INSERT INTO `userrights`(`userId`, `rightId`) VALUES (1,1);





















