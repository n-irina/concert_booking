<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250317173929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, session_id INT NOT NULL, seat_type_id INT NOT NULL, booking_date DATETIME NOT NULL, seat_count INT NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE613FECDF (session_id), INDEX IDX_E00CEDDE4ECEE001 (seat_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, hall_id INT NOT NULL, date_time DATETIME NOT NULL, INDEX IDX_D044D5D471F7E88B (event_id), INDEX IDX_D044D5D452AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_seat_type (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, seat_type_id INT DEFAULT NULL, price INT NOT NULL, available_seats INT NOT NULL, INDEX IDX_5E65D8C2613FECDF (session_id), INDEX IDX_5E65D8C24ECEE001 (seat_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4ECEE001 FOREIGN KEY (seat_type_id) REFERENCES seat_type (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D471F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D452AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE session_seat_type ADD CONSTRAINT FK_5E65D8C2613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE session_seat_type ADD CONSTRAINT FK_5E65D8C24ECEE001 FOREIGN KEY (seat_type_id) REFERENCES seat_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE613FECDF');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4ECEE001');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D471F7E88B');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D452AFCFD6');
        $this->addSql('ALTER TABLE session_seat_type DROP FOREIGN KEY FK_5E65D8C2613FECDF');
        $this->addSql('ALTER TABLE session_seat_type DROP FOREIGN KEY FK_5E65D8C24ECEE001');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_seat_type');
    }
}
