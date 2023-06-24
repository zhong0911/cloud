create database antxcloud_ssh;

use antxcloud_ssh;

create table connection_records
(
    id          bigint auto_increment
        primary key,
    host        text           null,
    port        int default 22 null,
    username    text           null,
    password    text           null,
    public_key  text           null,
    private_key text           null,
    passphrase  text           null,
    time        datetime       null,
    result      text           null,
    reason      text           null
);


