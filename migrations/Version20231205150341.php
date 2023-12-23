<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205150341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_dattente (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) DEFAULT NULL, adresse_ipliste VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE convertis ADD avatar VARCHAR(255) DEFAULT NULL, DROP avatar_instagram, DROP photo');
        $this->addSql('ALTER TABLE visite_rec CHANGE ip adresse_iprec VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE liste_dattente');
        $this->addSql('ALTER TABLE convertis ADD photo VARCHAR(255) DEFAULT NULL, CHANGE avatar avatar_instagram VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE visite_rec CHANGE adresse_iprec ip VARCHAR(255) NOT NULL');
    }
}
