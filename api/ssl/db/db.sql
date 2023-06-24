create database antxcloud_ssl;

use antxcloud_ssl;

create table generate_csr_records
(
    id                       bigint auto_increment
        primary key,
    uid                      text     null,
    name                     text     null,
    generation_time          datetime null,
    digest_alg               text     null,
    private_key_type         text     null,
    private_key_bits         text     null,
    country_name             text     null,
    state_or_province_name   text     null,
    locality_name            text     null,
    organization_name        text     null,
    organizational_unit_name text     null,
    common_name              text     null,
    email_address            text     null,
    csr                      text     null,
    private_key              text     null
);



