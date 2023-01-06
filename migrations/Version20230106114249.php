<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106114249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE performance (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, day1 NUMERIC(20, 2) NOT NULL, day5 NUMERIC(20, 2) NOT NULL, month1 NUMERIC(20, 2) NOT NULL, month3 NUMERIC(20, 2) NOT NULL, month6 NUMERIC(20, 2) NOT NULL, year_to_day NUMERIC(20, 2) NOT NULL, year1 NUMERIC(20, 2) NOT NULL, year3 NUMERIC(20, 2) NOT NULL, year5 NUMERIC(20, 2) NOT NULL, year10 NUMERIC(20, 2) NOT NULL, max NUMERIC(20, 2) NOT NULL, UNIQUE INDEX UNIQ_82D79681979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE performance ADD CONSTRAINT FK_82D79681979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE performance DROP FOREIGN KEY FK_82D79681979B1AD6');
        $this->addSql('DROP TABLE performance');
    }
}
