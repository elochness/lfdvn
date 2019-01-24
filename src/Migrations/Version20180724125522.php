<?php

declare(strict_types=1);

/*
 * This file is part of the lfdvn package.
 *
 * (c) Pierre François
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180724125522 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE article_category_id article_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE enterprise_details CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE schedule CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE article_category_id article_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE enterprise_details CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE schedule CHANGE id id INT NOT NULL');
    }
}
