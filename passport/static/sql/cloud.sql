create database antxcloud;

use antxcloud;

create table account
(
    uid      int  not null
        primary key,
    username text not null,
    password text not null,
    email    text not null,
    phone    text null
);
create table info
(
    uid            int  not null,
    ranking        int auto_increment
        primary key,
    username       text not null,
    avatar         text null,
    signature      text null,
    nickname       text null,
    gender         text null,
    birthday       date null,
    job            text null,
    primary_school text null,
    middle_school  text null,
    university     text null,
    company        text null,
    location       text null,
    hometown       text null,
    email          text null
);
create table status
(
    uid      int                  not null
        primary key,
    username text                 not null,
    status   tinyint(1) default 1 null,
    reason   text                 null,
    ip_1     text                 null,
    ip_2     text                 null,
    ip_3     text                 null,
    ip_4     text                 null,
    ip_5     text                 null,
    ip_6     text                 null,
    ip_7     text                 null,
    ip_8     text                 null,
    ip_9     text                 null,
    ip_10    text                 null
);
create table privacy
(
    uid            int                  not null
        primary key,
    username       text                 not null,
    gender         tinyint(1) default 1 null,
    birthday       tinyint(1) default 1 null,
    job            tinyint(1) default 1 null,
    primary_school tinyint(1) default 1 null,
    middle_school  tinyint(1) default 1 null,
    university     tinyint(1) default 1 null,
    company        tinyint(1) default 1 null,
    location       tinyint(1) default 1 null,
    hometown       tinyint(1) default 1 null,
    email          tinyint(1) default 1 null,
    phone          tinyint(1) default 1 null
);

create table mail
(
    id       int auto_increment
        primary key,
    email    text    not null,
    password text    not null,
    server   text    not null,
    port     int     null,
    status   tinyint not null
);

INSERT INTO mail (id, email, password, server, port, status)
VALUES (1, 'no-replay@antx.cc', 'zhong0911AntxMail', 'smtp.antx.cc', 25, 1);
INSERT INTO mail (id, email, password, server, port, status)
VALUES (2, 'adisaint@163.com', 'ZETWBSBHCWTOHBMC', 'smtp.163.com', 465, 1);
INSERT INTO mail (id, email, password, server, port, status)
VALUES (3, 'adisaint@qq.com', 'nwfheoidgkihbhjf', 'smtp.qq.com', 465, 1);
INSERT INTO mail (id, email, password, server, port, status)
VALUES (4, 'antxcc@163.com', 'XRBYGAZWRCMCAOMQ', 'smtp.163.com', 465, 1);