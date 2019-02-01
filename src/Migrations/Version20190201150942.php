<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190201150942 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, contains CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, enabled BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX article_category_id ON article (article_category_id)');
        $this->addSql('CREATE TABLE article_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, image VARCHAR(30) DEFAULT NULL, enabled BOOLEAN NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE enterprise_details (id INTEGER NOT NULL, name VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, code_postal VARCHAR(5) NOT NULL, city VARCHAR(75) NOT NULL, telephone VARCHAR(15) NOT NULL, email VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, subcategory_id INTEGER DEFAULT NULL, tax_rate_id INTEGER DEFAULT NULL, name VARCHAR(50) NOT NULL, quantity INTEGER NOT NULL, description CLOB NOT NULL, image VARCHAR(100) DEFAULT NULL, is_purchase BOOLEAN DEFAULT \'1\' NOT NULL, enabled BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, packaging VARCHAR(100) DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, refundable NUMERIC(10, 2) DEFAULT NULL)');
        $this->addSql('CREATE INDEX tax_rate_id ON product (tax_rate_id)');
        $this->addSql('CREATE INDEX subcategory_id ON product (subcategory_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE TABLE purchase (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, buyer_id INTEGER DEFAULT NULL, delivery_date DATE NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_6117D13B6C755722 ON purchase (buyer_id)');
        $this->addSql('CREATE TABLE purchase_item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER DEFAULT NULL, purchase_id INTEGER DEFAULT NULL, quantity SMALLINT NOT NULL, price DOUBLE PRECISION NOT NULL, tax_rate DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_6FA8ED7D4584665A ON purchase_item (product_id)');
        $this->addSql('CREATE INDEX IDX_6FA8ED7D558FBEB9 ON purchase_item (purchase_id)');
        $this->addSql('CREATE TABLE schedule (id INTEGER NOT NULL, monday VARCHAR(30) NOT NULL, tuesday VARCHAR(30) NOT NULL, wednesday VARCHAR(30) NOT NULL, thursday VARCHAR(30) NOT NULL, friday VARCHAR(30) NOT NULL, saturday VARCHAR(30) NOT NULL, sunday VARCHAR(30) NOT NULL, alert_day VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subcategory (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(50) NOT NULL, enabled BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX category_id ON subcategory (category_id)');
        $this->addSql('CREATE TABLE tax_rate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rate DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json_array)
        , firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, cellphone VARCHAR(20) DEFAULT NULL, enabled BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_category');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE enterprise_details');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE purchase_item');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE subcategory');
        $this->addSql('DROP TABLE tax_rate');
        $this->addSql('DROP TABLE user');
    }
}
