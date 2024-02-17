-- CREATE DATABASE
CREATE DATABASE IF NOT EXISTS app_hrmis;

-- USE DATABASE
USE app_hrmis;

-- CREATE TABLES
CREATE TABLE IF NOT EXISTS jabatan (
  id_jabatan int NOT NULL AUTO_INCREMENT,
  nama_jabatan varchar(50) NOT NULL,
  PRIMARY KEY (id_jabatan)
);

CREATE TABLE IF NOT EXISTS pegawai (
  id_pegawai int NOT NULL AUTO_INCREMENT,
  id_jabatan int NOT NULL,
  nama varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  password varchar(32) NOT NULL,
  tgl_lahir date NOT NULL,
  alamat varchar(150) NOT NULL,
  telepon varchar(16) NOT NULL,
  terakhir_login datetime,
  PRIMARY KEY (id_pegawai),
  FOREIGN KEY (id_jabatan) REFERENCES jabatan(id_jabatan)
);

CREATE TABLE IF NOT EXISTS catatan (
  id_catatan int NOT NULL AUTO_INCREMENT,
  id_pegawai int NOT NULL,
  catatan varchar(255) NOT NULL,
  status enum('WORKING', 'BREAK', 'STANDBY', 'ABSENT', 'DONE') NOT NULL,
  waktu_mulai datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  waktu_berakhir datetime,
  PRIMARY KEY (id_catatan),
  FOREIGN KEY (id_pegawai) REFERENCES pegawai(id_pegawai)
);

-- CREATE STORED PROCEDURES
DELIMITER :

CREATE PROCEDURE daftar_pegawai()
BEGIN
    SELECT *
    FROM pegawai p
    JOIN jabatan j ON p.id_jabatan = j.id_jabatan;
END:

CREATE PROCEDURE buat_pegawai(
    IN id_jabatan int, 
    IN nama varchar(50), 
    IN email varchar(50), 
    IN password varchar(32), 
    IN tgl_lahir date, 
    IN alamat varchar(150), 
    IN telepon varchar(16)
)
BEGIN
    INSERT INTO pegawai (id_jabatan, nama, email, password, tgl_lahir, alamat, telepon) 
    VALUES (id_jabatan, nama, email, MD5(password), tgl_lahir, alamat, telepon);
END:

CREATE PROCEDURE ubah_pegawai(
    IN id int, 
    IN _nama varchar(50), 
    IN _email varchar(50), 
    IN _password varchar(32), 
    IN _tgl_lahir date, 
    IN _alamat varchar(150), 
    IN _telepon varchar(16)
)
BEGIN
    UPDATE pegawai 
    SET 
        id_jabatan = id, 
        nama = _nama, 
        email = _email, 
        password = _password, 
        tgl_lahir = _tgl_lahir, 
        alamat = _alamat, 
        telepon = _telepon
    WHERE id_pegawai = id;
END:

CREATE PROCEDURE hapus_pegawai(IN id int)
BEGIN
    DELETE FROM pegawai WHERE id_pegawai = id;
END:

CREATE PROCEDURE login_pegawai(IN email_pegawai varchar(50), IN pass varchar(32))
BEGIN
    SET @id_pegawai = 0;
    SELECT id_pegawai FROM pegawai WHERE email = email_pegawai LIMIT 1 INTO @id_pegawai;
    IF @id_pegawai <> 0 THEN
        IF (SELECT password = MD5(pass) FROM pegawai WHERE id_pegawai = @id_pegawai) THEN
            UPDATE pegawai SET terakhir_login = NOW() WHERE id_pegawai = @id_pegawai;
            SELECT 'Login berhasil' AS success, nama_jabatan, id_pegawai, nama, email 
            FROM pegawai 
            JOIN jabatan ON jabatan.id_jabatan = pegawai.id_jabatan
            WHERE id_pegawai = @id_pegawai;
        ELSE
            SELECT 'Email atau password salah' AS error;
        END IF;
    ELSE
        SELECT 'Email atau password salah' AS error;
    END IF;
END:

-----------

CREATE PROCEDURE daftar_jabatan()
BEGIN
    SELECT * FROM jabatan;
END:

CREATE PROCEDURE buat_jabatan(IN nama_jabatan varchar(50))
BEGIN
    INSERT INTO jabatan (nama_jabatan) VALUES (nama_jabatan);
END:

CREATE PROCEDURE ubah_jabatan(IN id int, IN nama_jabatan varchar(50))
BEGIN
    UPDATE jabatan 
    SET nama_jabatan = nama_jabatan 
    WHERE id_jabatan = id;
END:

CREATE PROCEDURE hapus_jabatan(IN id int)
BEGIN
    DELETE FROM jabatan WHERE id_jabatan = id;
END:

-----------

CREATE PROCEDURE daftar_catatan()
BEGIN
    SELECT 
        c.id_catatan, p.nama as nama_pegawai, c.catatan, c.status, c.waktu_mulai, 
        c.waktu_berakhir, TIMEDIFF(waktu_berakhir, waktu_mulai) AS lama_pekerjaan 
    FROM catatan c
    JOIN pegawai p ON c.id_pegawai = p.id_pegawai
    WHERE c.waktu_mulai >= CURDATE();
END:

CREATE PROCEDURE daftar_catatan_pegawai(IN pegawai_id int)
BEGIN
    SELECT 
        c.id_catatan, c.catatan, c.status, c.waktu_mulai, c.waktu_berakhir, 
        TIMEDIFF(waktu_berakhir, waktu_mulai) AS lama_pekerjaan 
    FROM catatan c
    JOIN pegawai p ON c.id_pegawai = p.id_pegawai
    WHERE p.id_pegawai = pegawai_id;
END:

CREATE PROCEDURE hapus_catatan(IN id int)
BEGIN
    DELETE FROM catatan WHERE id_catatan = id;
END:

CREATE PROCEDURE buat_catatan_pegawai(
    IN id_pegawai int, 
    IN catatan varchar(255),
    IN status enum('WORKING', 'BREAK', 'STANDBY', 'ABSENT', 'DONE')
)
BEGIN
    SET @id_catatan_terakhir = 0;
    SELECT id_catatan FROM catatan WHERE id_pegawai = id_pegawai ORDER BY waktu_mulai DESC LIMIT 1 INTO @id_catatan_terakhir;
    IF @id_catatan_terakhir <> 0 THEN
        IF status = 'DONE' THEN
            UPDATE catatan SET waktu_berakhir = NOW() WHERE id_catatan = @id_catatan_terakhir;
            INSERT INTO catatan (id_pegawai, catatan, status, waktu_mulai, waktu_berakhir) VALUES (id_pegawai, catatan, status, NOW(), NOW());
        ELSE
            UPDATE catatan SET waktu_berakhir = NOW() WHERE id_catatan = @id_catatan_terakhir;
            INSERT INTO catatan (id_pegawai, catatan, status, waktu_mulai) VALUES (id_pegawai, catatan, status, NOW());
        END IF;
    ELSE
        INSERT INTO catatan (id_pegawai, catatan, status, waktu_mulai) VALUES (id_pegawai, catatan, status, NOW());
    END IF;
END:

CREATE PROCEDURE rata_rata_catatan(IN str_date date)
BEGIN
    SELECT SUBSTRING(SEC_TO_TIME(AVG(CASE WHEN status <> 'ABSENT' THEN TIMEDIFF(waktu_berakhir, waktu_mulai) ELSE NULL END)), 1, 8) AS lama_bekerja 
    FROM catatan
    WHERE waktu_mulai >= str_date;
END:

CREATE PROCEDURE lama_catatan_pegawai(IN id int, IN str_date date)
BEGIN
    SELECT SEC_TO_TIME(SUM(CASE WHEN status <> 'ABSENT' THEN TIMEDIFF(waktu_berakhir, waktu_mulai) ELSE NULL END)) AS lama_bekerja 
    FROM catatan
    WHERE id_pegawai = id  
    AND waktu_mulai >= str_date;
END:

DELIMITER ;

-- INSERT DATA DUMMY
INSERT INTO jabatan VALUES (1, 'Manager'), (2, 'Staff'), (3, 'Security'), (4, 'Cleaner'); 
INSERT INTO pegawai (id_jabatan, nama, password, email, tgl_lahir, alamat, telepon) VALUES 
(1, 'Budi', MD5('budi123'), 'budi@gmail.com', '1992-04-21', 'Jl. Jendral Sudirman No. 1', '081234567890'),
(2, 'Cindy', MD5('cindy123'), 'cindy@gmail.com', '1987-02-04', 'Jl. Cimindi No. 4', '081234567890'),
(3, 'Andi', MD5('andi123'), 'andi@gmail.com', '2001-06-13', 'Jl. Parahyangan No. 21', '081234567891'),
(4, 'Dedi', MD5('dedi123'), 'dedi@gmail.com', '1995-12-30', 'Jl. Situ Bagendit No. 25', '081234567891');
