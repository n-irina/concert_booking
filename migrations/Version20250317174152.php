<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250317174152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hall_seat_type (id INT AUTO_INCREMENT NOT NULL, hall_id INT DEFAULT NULL, seat_type_id INT DEFAULT NULL, capacity INT NOT NULL, INDEX IDX_795D9AD652AFCFD6 (hall_id), INDEX IDX_795D9AD64ECEE001 (seat_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hall_seat_type ADD CONSTRAINT FK_795D9AD652AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE hall_seat_type ADD CONSTRAINT FK_795D9AD64ECEE001 FOREIGN KEY (seat_type_id) REFERENCES seat_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hall_seat_type DROP FOREIGN KEY FK_795D9AD652AFCFD6');
        $this->addSql('ALTER TABLE hall_seat_type DROP FOREIGN KEY FK_795D9AD64ECEE001');
        $this->addSql('DROP TABLE hall_seat_type');
    }
}
