<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323165418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, adresse_numero VARCHAR(20) NOT NULL, adresse_rue LONGTEXT NOT NULL, adresse_codepostale VARCHAR(255) NOT NULL, adresse_ville VARCHAR(255) NOT NULL, adresse_pays VARCHAR(255) NOT NULL, adresse_type VARCHAR(255) DEFAULT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_EF19255219EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE archiver_factures (id INT AUTO_INCREMENT NOT NULL, archiver_facture_numero VARCHAR(255) NOT NULL, annee_archive DATE NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, categorie_nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, client_nom VARCHAR(50) NOT NULL, client_prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, UNIQUE INDEX UNIQ_C82E74FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, transporteur_id INT DEFAULT NULL, commande_reference VARCHAR(255) NOT NULL, annee_commande DATE NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_35D4282C19EB6921 (client_id), INDEX IDX_35D4282C97C86FA4 (transporteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes_produits (commandes_id INT NOT NULL, produits_id INT NOT NULL, INDEX IDX_D58023F08BF5C2E6 (commandes_id), INDEX IDX_D58023F0CD11A2CF (produits_id), PRIMARY KEY(commandes_id, produits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factures (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, archiver_factures_id INT DEFAULT NULL, facture_date DATE NOT NULL, facture_numero VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_647590B19EB6921 (client_id), INDEX IDX_647590BF833357 (archiver_factures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, image_nom VARCHAR(255) NOT NULL, image_chemin VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_E01FBE6AF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, produit_reference VARCHAR(255) NOT NULL, produit_nom VARCHAR(255) NOT NULL, produit_designation LONGTEXT NOT NULL, produit_prix DOUBLE PRECISION NOT NULL, is_produit_vendu TINYINT(1) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_BE2DDF8CBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reductions (id INT AUTO_INCREMENT NOT NULL, reduction_reference VARCHAR(10) NOT NULL, reduction_designation LONGTEXT NOT NULL, reduction_pourcentage DOUBLE PRECISION NOT NULL, reduction_montant DOUBLE PRECISION NOT NULL, annee_reductions DATE NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reductions_produits (reductions_id INT NOT NULL, produits_id INT NOT NULL, INDEX IDX_6A89E43DF9B073FD (reductions_id), INDEX IDX_6A89E43DCD11A2CF (produits_id), PRIMARY KEY(reductions_id, produits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categories (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, sous_categorie_nom VARCHAR(255) DEFAULT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_DC8B1382BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stocks (id INT AUTO_INCREMENT NOT NULL, tissu_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, stock_reference VARCHAR(255) NOT NULL, stock_designation LONGTEXT NOT NULL, stock_quantite INT NOT NULL, is_stock_rupture TINYINT(1) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_56F79805A533E0C9 (tissu_id), INDEX IDX_56F79805F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tissus (id INT AUTO_INCREMENT NOT NULL, tissu_nom VARCHAR(255) NOT NULL, tissus_designation LONGTEXT NOT NULL, tissu_tarif DOUBLE PRECISION NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tissus_produits (tissus_id INT NOT NULL, produits_id INT NOT NULL, INDEX IDX_C97DC16756CF4D1 (tissus_id), INDEX IDX_C97DC167CD11A2CF (produits_id), PRIMARY KEY(tissus_id, produits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transporteurs (id INT AUTO_INCREMENT NOT NULL, transporteur_nom VARCHAR(255) NOT NULL, transporteur_prix DOUBLE PRECISION NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(50) NOT NULL, is_client TINYINT(1) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF19255219EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E74FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C97C86FA4 FOREIGN KEY (transporteur_id) REFERENCES transporteurs (id)');
        $this->addSql('ALTER TABLE commandes_produits ADD CONSTRAINT FK_D58023F08BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes_produits ADD CONSTRAINT FK_D58023F0CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590BF833357 FOREIGN KEY (archiver_factures_id) REFERENCES archiver_factures (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AF347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE reductions_produits ADD CONSTRAINT FK_6A89E43DF9B073FD FOREIGN KEY (reductions_id) REFERENCES reductions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reductions_produits ADD CONSTRAINT FK_6A89E43DCD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sous_categories ADD CONSTRAINT FK_DC8B1382BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE stocks ADD CONSTRAINT FK_56F79805A533E0C9 FOREIGN KEY (tissu_id) REFERENCES tissus (id)');
        $this->addSql('ALTER TABLE stocks ADD CONSTRAINT FK_56F79805F347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE tissus_produits ADD CONSTRAINT FK_C97DC16756CF4D1 FOREIGN KEY (tissus_id) REFERENCES tissus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tissus_produits ADD CONSTRAINT FK_C97DC167CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590BF833357');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8CBCF5E72D');
        $this->addSql('ALTER TABLE sous_categories DROP FOREIGN KEY FK_DC8B1382BCF5E72D');
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF19255219EB6921');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C19EB6921');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B19EB6921');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64919EB6921');
        $this->addSql('ALTER TABLE commandes_produits DROP FOREIGN KEY FK_D58023F08BF5C2E6');
        $this->addSql('ALTER TABLE commandes_produits DROP FOREIGN KEY FK_D58023F0CD11A2CF');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AF347EFB');
        $this->addSql('ALTER TABLE reductions_produits DROP FOREIGN KEY FK_6A89E43DCD11A2CF');
        $this->addSql('ALTER TABLE stocks DROP FOREIGN KEY FK_56F79805F347EFB');
        $this->addSql('ALTER TABLE tissus_produits DROP FOREIGN KEY FK_C97DC167CD11A2CF');
        $this->addSql('ALTER TABLE reductions_produits DROP FOREIGN KEY FK_6A89E43DF9B073FD');
        $this->addSql('ALTER TABLE stocks DROP FOREIGN KEY FK_56F79805A533E0C9');
        $this->addSql('ALTER TABLE tissus_produits DROP FOREIGN KEY FK_C97DC16756CF4D1');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C97C86FA4');
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E74FB88E14F');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE archiver_factures');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE commandes_produits');
        $this->addSql('DROP TABLE factures');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE reductions');
        $this->addSql('DROP TABLE reductions_produits');
        $this->addSql('DROP TABLE sous_categories');
        $this->addSql('DROP TABLE stocks');
        $this->addSql('DROP TABLE tissus');
        $this->addSql('DROP TABLE tissus_produits');
        $this->addSql('DROP TABLE transporteurs');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
