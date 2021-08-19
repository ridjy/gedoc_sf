<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819112831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (cat_id INT AUTO_INCREMENT NOT NULL, cat_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(cat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_categorie (id INT AUTO_INCREMENT NOT NULL, doc_id INT NOT NULL, cat_id INT NOT NULL, date_ajout VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_motcle (dmc_id INT AUTO_INCREMENT NOT NULL, doc_id INT NOT NULL, mc_id INT NOT NULL, date_ajout VARCHAR(255) NOT NULL, PRIMARY KEY(dmc_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (doc_id INT AUTO_INCREMENT NOT NULL, cat_id INT NOT NULL, doc_name VARCHAR(250) NOT NULL, doc_date_creation VARCHAR(255) NOT NULL, doc_date_modif VARCHAR(255) NOT NULL, doc_description TEXT NOT NULL, doc_emplacement VARCHAR(255) NOT NULL, doc_taille INT NOT NULL, user_id INT NOT NULL, doc_titre VARCHAR(250) DEFAULT NULL, doc_date_publication VARCHAR(75) DEFAULT NULL, PRIMARY KEY(doc_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motcles (mc_id INT AUTO_INCREMENT NOT NULL, mc_lib VARCHAR(100) NOT NULL, UNIQUE INDEX mc_lib (mc_lib), PRIMARY KEY(mc_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id_notif INT AUTO_INCREMENT NOT NULL, date_notif VARCHAR(50) NOT NULL, contenu TEXT NOT NULL, lu INT NOT NULL, date_lecture VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id_notif)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (users_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(250) NOT NULL, firstname VARCHAR(250) NOT NULL, password VARCHAR(250) NOT NULL, email VARCHAR(250) NOT NULL, PRIMARY KEY(users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE doc_categorie');
        $this->addSql('DROP TABLE doc_motcle');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE motcles');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE users');
    }
}
