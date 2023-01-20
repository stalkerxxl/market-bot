<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119092707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, sector_id INT NOT NULL, industry_id INT NOT NULL, symbol VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, beta NUMERIC(10, 2) NOT NULL, last_div NUMERIC(10, 2) NOT NULL, cik VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, ceo VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, full_time_employees INT NOT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) DEFAULT NULL, zip VARCHAR(255) DEFAULT NULL, dcf_diff NUMERIC(10, 2) DEFAULT NULL, dcf NUMERIC(10, 2) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, ipo_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_4FBF094FECC836F9 (symbol), INDEX IDX_4FBF094FDE95C867 (sector_id), INDEX IDX_4FBF094F2B19A734 (industry_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE industry (id INT AUTO_INCREMENT NOT NULL, sector_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_CDFA6CA05E237E06 (name), INDEX IDX_CDFA6CA0DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE insider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE performance (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, day1 NUMERIC(20, 2) NOT NULL, day5 NUMERIC(20, 2) NOT NULL, month1 NUMERIC(20, 2) NOT NULL, month3 NUMERIC(20, 2) NOT NULL, month6 NUMERIC(20, 2) NOT NULL, year_to_day NUMERIC(20, 2) NOT NULL, year1 NUMERIC(20, 2) NOT NULL, year3 NUMERIC(20, 2) NOT NULL, year5 NUMERIC(20, 2) NOT NULL, year10 NUMERIC(20, 2) NOT NULL, max NUMERIC(20, 2) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_82D79681979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, open NUMERIC(10, 2) NOT NULL, previous_close NUMERIC(10, 2) NOT NULL, change_price NUMERIC(10, 2) NOT NULL, changes_percentage NUMERIC(10, 2) NOT NULL, day_low NUMERIC(10, 2) NOT NULL, day_high NUMERIC(10, 2) NOT NULL, year_low NUMERIC(10, 2) NOT NULL, year_high NUMERIC(10, 2) NOT NULL, market_cap BIGINT NOT NULL, price_avg50 NUMERIC(10, 2) NOT NULL, price_avg200 NUMERIC(10, 2) NOT NULL, volume BIGINT NOT NULL, avg_volume BIGINT NOT NULL, eps NUMERIC(10, 2) DEFAULT NULL, pe NUMERIC(10, 2) DEFAULT NULL, earnings_announcement DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', shares_outstanding BIGINT NOT NULL, api_timestamp DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_6B71CBF4979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roaster (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, year INT NOT NULL, quarter INT NOT NULL, purchases INT NOT NULL, sales INT NOT NULL, buy_sell_ratio NUMERIC(10, 2) NOT NULL, total_bought BIGINT NOT NULL, total_sold BIGINT NOT NULL, average_bought BIGINT NOT NULL, average_sold BIGINT NOT NULL, p_purchases INT NOT NULL, s_sales INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3798BD02979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_4BA3D9E85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, insider_id INT NOT NULL, filing_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', cik BIGINT NOT NULL, type VARCHAR(30) NOT NULL, owned BIGINT NOT NULL, acquistion_or_disposition VARCHAR(10) NOT NULL, form_type INT NOT NULL, quantity BIGINT NOT NULL, price NUMERIC(10, 2) NOT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_723705D1979B1AD6 (company_id), INDEX IDX_723705D1FCA943FB (insider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F2B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id)');
        $this->addSql('ALTER TABLE industry ADD CONSTRAINT FK_CDFA6CA0DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE performance ADD CONSTRAINT FK_82D79681979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE roaster ADD CONSTRAINT FK_3798BD02979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1FCA943FB FOREIGN KEY (insider_id) REFERENCES insider (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FDE95C867');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F2B19A734');
        $this->addSql('ALTER TABLE industry DROP FOREIGN KEY FK_CDFA6CA0DE95C867');
        $this->addSql('ALTER TABLE performance DROP FOREIGN KEY FK_82D79681979B1AD6');
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4979B1AD6');
        $this->addSql('ALTER TABLE roaster DROP FOREIGN KEY FK_3798BD02979B1AD6');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1979B1AD6');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1FCA943FB');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE industry');
        $this->addSql('DROP TABLE insider');
        $this->addSql('DROP TABLE performance');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE roaster');
        $this->addSql('DROP TABLE sector');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
