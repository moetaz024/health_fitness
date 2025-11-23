<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Fix: make new columns nullable first, to avoid '0000-00-00' error
 */
final class Version20251123123143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add nom, prenom, date_naissance as nullable first';
    }

    public function up(Schema $schema): void
    {
        // نخليهم NULL في الأول باش ما يطيحش على users القدام
        $this->addSql("
            ALTER TABLE user
                ADD nom VARCHAR(80) DEFAULT NULL,
                ADD prenom VARCHAR(80) DEFAULT NULL,
                ADD date_naissance DATE DEFAULT NULL
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("
            ALTER TABLE user 
                DROP nom, 
                DROP prenom, 
                DROP date_naissance
        ");
    }
}
