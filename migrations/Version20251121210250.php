<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251121210250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, biographie LONGTEXT NOT NULL, experience INT NOT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, date_creation DATETIME NOT NULL, montant_total DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, user_id INT NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, quantiter INT NOT NULL, prix_achat DOUBLE PRECISION NOT NULL, orders_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_52EA1F09CFFE9AD6 (orders_id), INDEX IDX_52EA1F094584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, stock INT NOT NULL, categorie VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, date_reservation DATETIME NOT NULL, status VARCHAR(255) NOT NULL, user_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C84955ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, duree INT NOT NULL, categorie VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, coach_id INT NOT NULL, INDEX IDX_E19D9AD23C105691 (coach_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD23C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09CFFE9AD6');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955ED5CA9E6');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD23C105691');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
    }
}
