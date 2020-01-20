<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200113085647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE city (id UUID NOT NULL, name VARCHAR(255) NOT NULL, department VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, is_enbaled BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN city.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE collection (id UUID NOT NULL, id_dumpster_id UUID DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, volume INT DEFAULT NULL, vehicle VARCHAR(255) DEFAULT NULL, is_enabled BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FC4D6532C6532977 ON collection (id_dumpster_id)');
        $this->addSql('COMMENT ON COLUMN collection.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN collection.id_dumpster_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE dumpster (id UUID NOT NULL, id_city_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, is_enabled BOOLEAN NOT NULL, uploads VARCHAR(255) DEFAULT NULL, coordinates geography(POINT, 4326) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4E9832E35531CBDF ON dumpster (id_city_id)');
        $this->addSql('COMMENT ON COLUMN dumpster.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN dumpster.id_city_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE historic (id UUID NOT NULL, id_user_id UUID DEFAULT NULL, research VARCHAR(255) DEFAULT NULL, type_alert VARCHAR(255) DEFAULT NULL, is_enabled BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AD52EF5679F37AE5 ON historic (id_user_id)');
        $this->addSql('COMMENT ON COLUMN historic.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN historic.id_user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(255) NOT NULL, is_enabled BOOLEAN NOT NULL, token VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_dumpster (id UUID NOT NULL, id_user_id UUID DEFAULT NULL, id_dumpster_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AE15D6E379F37AE5 ON user_dumpster (id_user_id)');
        $this->addSql('CREATE INDEX IDX_AE15D6E3C6532977 ON user_dumpster (id_dumpster_id)');
        $this->addSql('COMMENT ON COLUMN user_dumpster.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_dumpster.id_user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_dumpster.id_dumpster_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE collection ADD CONSTRAINT FK_FC4D6532C6532977 FOREIGN KEY (id_dumpster_id) REFERENCES dumpster (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dumpster ADD CONSTRAINT FK_4E9832E35531CBDF FOREIGN KEY (id_city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE historic ADD CONSTRAINT FK_AD52EF5679F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_dumpster ADD CONSTRAINT FK_AE15D6E379F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_dumpster ADD CONSTRAINT FK_AE15D6E3C6532977 FOREIGN KEY (id_dumpster_id) REFERENCES dumpster (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE dumpster DROP CONSTRAINT FK_4E9832E35531CBDF');
        $this->addSql('ALTER TABLE collection DROP CONSTRAINT FK_FC4D6532C6532977');
        $this->addSql('ALTER TABLE user_dumpster DROP CONSTRAINT FK_AE15D6E3C6532977');
        $this->addSql('ALTER TABLE historic DROP CONSTRAINT FK_AD52EF5679F37AE5');
        $this->addSql('ALTER TABLE user_dumpster DROP CONSTRAINT FK_AE15D6E379F37AE5');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE collection');
        $this->addSql('DROP TABLE dumpster');
        $this->addSql('DROP TABLE historic');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_dumpster');
    }
}
