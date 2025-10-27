<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251027133106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE credit (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(25) NOT NULL, name VARCHAR(255) NOT NULL, link_id INT DEFAULT NULL, INDEX IDX_1CC16EFEADA40271 (link_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE model (id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE model_credits (model_id VARCHAR(255) NOT NULL, credit_id INT NOT NULL, INDEX IDX_2184B88F7975B7E7 (model_id), INDEX IDX_2184B88FCE062FF9 (credit_id), PRIMARY KEY (model_id, credit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFEADA40271 FOREIGN KEY (link_id) REFERENCES link (id)');
        $this->addSql('ALTER TABLE model_credits ADD CONSTRAINT FK_2184B88F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_credits ADD CONSTRAINT FK_2184B88FCE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFEADA40271');
        $this->addSql('ALTER TABLE model_credits DROP FOREIGN KEY FK_2184B88F7975B7E7');
        $this->addSql('ALTER TABLE model_credits DROP FOREIGN KEY FK_2184B88FCE062FF9');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE model_credits');
    }
}
