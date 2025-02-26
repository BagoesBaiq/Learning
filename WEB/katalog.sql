CREATE DATABASE katalog_barang;

USE katalog_barang;

CREATE TABLE barang (
    nama_barang VARCHAR(100),
    deskripsi TEXT,
    harga DECIMAL(10, 2)
);

INSERT INTO barang (nama, deskripsi, harga) VALUES
('Keset', 'Keset dengan penyerapan tinggi', 15000000),
('Pel', 'Pel dengan tingkat kebersihan', 350000),
('Sapu', 'Sapu bisa membersihkan debu membandel', 2000000);

select * from barang;