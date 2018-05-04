<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180504001327 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE area_user (area_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4FD6F956BD0F409C (area_id), INDEX IDX_4FD6F956A76ED395 (user_id), PRIMARY KEY(area_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE id_person (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, identification VARCHAR(40) DEFAULT NULL, type_identification VARCHAR(25) NOT NULL, name VARCHAR(60) NOT NULL, last_name VARCHAR(60) NOT NULL, birth_day DATETIME NOT NULL, phone VARCHAR(25) NOT NULL, address VARCHAR(25) NOT NULL, sex VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_room_id INT NOT NULL, initial_date DATETIME NOT NULL, final_date DATETIME NOT NULL, initial_hour TIME NOT NULL, final_hour TIME NOT NULL, reservation_date DATETIME NOT NULL, all_day TINYINT(1) NOT NULL, quantity_assistant INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_42C8495579F37AE5 (id_user_id), INDEX IDX_42C849558A8AD9E3 (id_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, id_sede_id INT NOT NULL, name VARCHAR(60) NOT NULL, code VARCHAR(60) NOT NULL, type VARCHAR(255) NOT NULL, capacity INT NOT NULL, INDEX IDX_729F519B3F02E8CF (id_sede_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sede (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sede_area (sede_id INT NOT NULL, area_id INT NOT NULL, INDEX IDX_DC7F0910E19F41BF (sede_id), INDEX IDX_DC7F0910BD0F409C (area_id), PRIMARY KEY(sede_id, area_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_person_id INT DEFAULT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(60) NOT NULL, UNIQUE INDEX UNIQ_8D93D649A14E0760 (id_person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE area_user ADD CONSTRAINT FK_4FD6F956BD0F409C FOREIGN KEY (area_id) REFERENCES area (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE area_user ADD CONSTRAINT FK_4FD6F956A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849558A8AD9E3 FOREIGN KEY (id_room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B3F02E8CF FOREIGN KEY (id_sede_id) REFERENCES sede (id)');
        $this->addSql('ALTER TABLE sede_area ADD CONSTRAINT FK_DC7F0910E19F41BF FOREIGN KEY (sede_id) REFERENCES sede (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sede_area ADD CONSTRAINT FK_DC7F0910BD0F409C FOREIGN KEY (area_id) REFERENCES area (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A14E0760 FOREIGN KEY (id_person_id) REFERENCES person (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE area_user DROP FOREIGN KEY FK_4FD6F956BD0F409C');
        $this->addSql('ALTER TABLE sede_area DROP FOREIGN KEY FK_DC7F0910BD0F409C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A14E0760');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849558A8AD9E3');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B3F02E8CF');
        $this->addSql('ALTER TABLE sede_area DROP FOREIGN KEY FK_DC7F0910E19F41BF');
        $this->addSql('ALTER TABLE area_user DROP FOREIGN KEY FK_4FD6F956A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495579F37AE5');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE area_user');
        $this->addSql('DROP TABLE id_person');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE sede');
        $this->addSql('DROP TABLE sede_area');
        $this->addSql('DROP TABLE user');
    }
}
