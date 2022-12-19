<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221223144958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, sector_id INT NOT NULL, industry_id INT NOT NULL, symbol VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, beta NUMERIC(10, 2) NOT NULL, last_div NUMERIC(10, 2) NOT NULL, cik VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, ceo VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, full_time_employees INT NOT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, dcf_diff NUMERIC(10, 2) DEFAULT NULL, dcf NUMERIC(10, 2) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, ipo_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_4FBF094FECC836F9 (symbol), INDEX IDX_4FBF094FDE95C867 (sector_id), INDEX IDX_4FBF094F2B19A734 (industry_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE industry (id INT AUTO_INCREMENT NOT NULL, sector_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_CDFA6CA05E237E06 (name), INDEX IDX_CDFA6CA0DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, open NUMERIC(10, 2) NOT NULL, previous_close NUMERIC(10, 2) NOT NULL, change_price NUMERIC(10, 2) NOT NULL, changes_percentage NUMERIC(10, 2) NOT NULL, day_low NUMERIC(10, 2) NOT NULL, day_high NUMERIC(10, 2) NOT NULL, year_low NUMERIC(10, 2) NOT NULL, year_high NUMERIC(10, 2) NOT NULL, market_cap BIGINT NOT NULL, price_avg50 NUMERIC(10, 2) NOT NULL, price_avg200 NUMERIC(10, 2) NOT NULL, volume BIGINT NOT NULL, avg_volume BIGINT NOT NULL, eps NUMERIC(10, 2) DEFAULT NULL, pe NUMERIC(10, 2) DEFAULT NULL, earnings_announcement DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', shares_outstanding BIGINT NOT NULL, api_timestamp DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_6B71CBF4979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_4BA3D9E85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F2B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id)');
        $this->addSql('ALTER TABLE industry ADD CONSTRAINT FK_CDFA6CA0DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FDE95C867');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F2B19A734');
        $this->addSql('ALTER TABLE industry DROP FOREIGN KEY FK_CDFA6CA0DE95C867');
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4979B1AD6');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE industry');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE sector');
    }
}
