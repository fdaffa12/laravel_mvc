-- (opsional) Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS ujump_202507;

-- Buat user
CREATE USER 'ujump_202507'@'%' IDENTIFIED BY 'P4ssword\*$#123456';

-- Berikan hak akses ke database
GRANT ALL PRIVILEGES ON ujump_202507.\* TO 'ujump_202507'@'%';
