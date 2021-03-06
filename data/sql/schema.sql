CREATE TABLE codes (id BIGINT AUTO_INCREMENT, name VARCHAR(255), used TINYINT(1) DEFAULT '0', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE standorte (id SMALLINT AUTO_INCREMENT, name VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey (id BIGINT AUTO_INCREMENT, survey_angebot_bekannt_id SMALLINT, survey_angebot_vergleichbare_reise_id SMALLINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX survey_angebot_bekannt_id_idx (survey_angebot_bekannt_id), INDEX survey_angebot_vergleichbare_reise_id_idx (survey_angebot_vergleichbare_reise_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey_angebot_bekannt (id SMALLINT AUTO_INCREMENT, name VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey_angebot_vergleichbare_reise (id SMALLINT AUTO_INCREMENT, name VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey_angebot_verkehrsmittel12 (id SMALLINT AUTO_INCREMENT, name VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey_angebot_verkehrsmittel12_user (survey_id SMALLINT, user_id BIGINT, PRIMARY KEY(survey_id, user_id)) ENGINE = INNODB;
CREATE TABLE survey_angebot_verkehrsmittel_allgemein (id SMALLINT AUTO_INCREMENT, name VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey_angebot_verkehrsmittel_allgemein_user (survey_id SMALLINT, user_id BIGINT, PRIMARY KEY(survey_id, user_id)) ENGINE = INNODB;
CREATE TABLE survey_anlaesse (id SMALLINT AUTO_INCREMENT, name VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey_anlaesse_user (survey_id SMALLINT, user_id BIGINT, PRIMARY KEY(survey_id, user_id)) ENGINE = INNODB;
CREATE TABLE survey_gefallen (id BIGINT AUTO_INCREMENT, preislich VARCHAR(255) NOT NULL, spontan VARCHAR(255) NOT NULL, gutes_angebot VARCHAR(255) NOT NULL, freunden VARCHAR(255) NOT NULL, entfernung VARCHAR(255) NOT NULL, junge VARCHAR(255) NOT NULL, user_id BIGINT NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE user (id BIGINT AUTO_INCREMENT, anrede VARCHAR(255) NOT NULL, vorname VARCHAR(255) NOT NULL, nachname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, strasse VARCHAR(255) NOT NULL, plz BIGINT NOT NULL, wohnort VARCHAR(255) NOT NULL, codes_id BIGINT, standorte_id SMALLINT, abgemeldet TINYINT(1) DEFAULT '0', survey_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX email_index_idx (email(10) ASC), INDEX codes_id_idx (codes_id), INDEX standorte_id_idx (standorte_id), INDEX survey_id_idx (survey_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_forgot_password (id BIGINT AUTO_INCREMENT, user_id BIGINT NOT NULL, unique_key VARCHAR(255), expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id BIGINT AUTO_INCREMENT, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email_address VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE survey ADD CONSTRAINT survey_survey_angebot_bekannt_id_survey_angebot_bekannt_id FOREIGN KEY (survey_angebot_bekannt_id) REFERENCES survey_angebot_bekannt(id);
ALTER TABLE survey ADD CONSTRAINT sssi FOREIGN KEY (survey_angebot_vergleichbare_reise_id) REFERENCES survey_angebot_vergleichbare_reise(id);
ALTER TABLE survey_angebot_verkehrsmittel12_user ADD CONSTRAINT survey_angebot_verkehrsmittel12_user_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id);
ALTER TABLE survey_angebot_verkehrsmittel12_user ADD CONSTRAINT sssi_1 FOREIGN KEY (survey_id) REFERENCES survey_angebot_verkehrsmittel12(id);
ALTER TABLE survey_angebot_verkehrsmittel_allgemein_user ADD CONSTRAINT survey_angebot_verkehrsmittel_allgemein_user_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id);
ALTER TABLE survey_angebot_verkehrsmittel_allgemein_user ADD CONSTRAINT sssi_2 FOREIGN KEY (survey_id) REFERENCES survey_angebot_verkehrsmittel_allgemein(id);
ALTER TABLE survey_anlaesse_user ADD CONSTRAINT survey_anlaesse_user_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id);
ALTER TABLE survey_anlaesse_user ADD CONSTRAINT survey_anlaesse_user_survey_id_survey_anlaesse_id FOREIGN KEY (survey_id) REFERENCES survey_anlaesse(id);
ALTER TABLE survey_gefallen ADD CONSTRAINT survey_gefallen_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id);
ALTER TABLE user ADD CONSTRAINT user_survey_id_survey_id FOREIGN KEY (survey_id) REFERENCES survey(id);
ALTER TABLE user ADD CONSTRAINT user_standorte_id_standorte_id FOREIGN KEY (standorte_id) REFERENCES standorte(id);
ALTER TABLE user ADD CONSTRAINT user_codes_id_codes_id FOREIGN KEY (codes_id) REFERENCES codes(id);
ALTER TABLE sf_guard_forgot_password ADD CONSTRAINT sf_guard_forgot_password_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
