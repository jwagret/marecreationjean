<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314123439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE adresses CHANGE adresse_numero adresse_numero VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_rue adresse_rue LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_codepostale adresse_codepostale VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_ville adresse_ville VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_pays adresse_pays VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_type adresse_type VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE archiver_factures CHANGE archiver_facture_numero archiver_facture_numero VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE categories CHANGE categorie_nom categorie_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE clients CHANGE client_nom client_nom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE client_prenom client_prenom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commandes CHANGE commande_reference commande_reference VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE factures CHANGE facture_numero facture_numero VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE images CHANGE image_nom image_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_chemin image_chemin VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produits CHANGE produit_reference produit_reference VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE produit_nom produit_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE produit_designation produit_designation LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reductions CHANGE reduction_reference reduction_reference VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE reduction_designation reduction_designation LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sous_categories CHANGE sous_categorie_nom sous_categorie_nom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stocks CHANGE stock_reference stock_reference VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE stock_designation stock_designation LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tissus CHANGE tissu_nom tissu_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tissus_designation tissus_designation LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE transporteurs CHANGE transporteur_nom transporteur_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
