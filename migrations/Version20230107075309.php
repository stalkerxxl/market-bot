<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230107075309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roaster (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, year YEAR NOT NULL, quarter INT NOT NULL, purchases INT NOT NULL, sales INT NOT NULL, buy_sell_ratio NUMERIC(10, 2) NOT NULL, total_bought BIGINT NOT NULL, total_sold BIGINT NOT NULL, average_bought BIGINT NOT NULL, average_sold BIGINT NOT NULL, p_purchases INT NOT NULL, s_sales INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3798BD02979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roaster ADD CONSTRAINT FK_3798BD02979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roaster DROP FOREIGN KEY FK_3798BD02979B1AD6');
        $this->addSql('DROP TABLE roaster');
    }
}
