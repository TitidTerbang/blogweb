-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS blog_database;

-- Gunakan database
USE blog_database;

-- Tabel pengguna (users)
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,       -- ID unik untuk setiap pengguna
                       name VARCHAR(100) NOT NULL,              -- Nama pengguna
                       email VARCHAR(150) NOT NULL UNIQUE,      -- Email (unik)
                       password VARCHAR(255) NOT NULL,          -- Password yang di-hash
                       role ENUM('admin', 'writer', 'reader') DEFAULT 'reader', -- Peran pengguna
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Tanggal pendaftaran
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel kategori (categories)
CREATE TABLE categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,       -- ID unik untuk setiap kategori
                            name VARCHAR(100) NOT NULL UNIQUE,       -- Nama kategori
                            slug VARCHAR(100) NOT NULL UNIQUE,       -- URL slug untuk kategori
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Tanggal dibuat
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel artikel (articles)
CREATE TABLE articles (
                          id INT AUTO_INCREMENT PRIMARY KEY,       -- ID unik untuk setiap artikel
                          user_id INT NOT NULL,                    -- ID penulis (relasi ke tabel users)
                          category_id INT,                         -- ID kategori (relasi ke tabel categories)
                          title VARCHAR(255) NOT NULL,             -- Judul artikel
                          slug VARCHAR(255) NOT NULL UNIQUE,       -- URL slug untuk artikel
                          content TEXT NOT NULL,                   -- Isi artikel
                          image_url VARCHAR(255),                  -- URL gambar artikel (opsional)
                          status ENUM('draft', 'published') DEFAULT 'draft', -- Status artikel
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Tanggal dibuat
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Relasi ke tabel users
                          FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL -- Relasi ke tabel categories
);

-- Tabel komentar (comments)
CREATE TABLE comments (
                          id INT AUTO_INCREMENT PRIMARY KEY,       -- ID unik untuk setiap komentar
                          article_id INT NOT NULL,                 -- ID artikel (relasi ke tabel articles)
                          user_id INT NOT NULL,                    -- ID pengguna yang berkomentar (relasi ke tabel users)
                          content TEXT NOT NULL,                   -- Isi komentar
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Tanggal komentar dibuat
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE, -- Relasi ke tabel articles
                          FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Relasi ke tabel users
);

-- Tabel tag (tags)
CREATE TABLE tags (
                      id INT AUTO_INCREMENT PRIMARY KEY,       -- ID unik untuk setiap tag
                      name VARCHAR(100) NOT NULL UNIQUE,       -- Nama tag
                      slug VARCHAR(100) NOT NULL UNIQUE,       -- URL slug untuk tag
                      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Tanggal dibuat
                      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel relasi artikel dan tag (article_tags)
CREATE TABLE article_tags (
                              article_id INT NOT NULL,                 -- ID artikel (relasi ke tabel articles)
                              tag_id INT NOT NULL,                     -- ID tag (relasi ke tabel tags)
                              PRIMARY KEY (article_id, tag_id),        -- Kombinasi artikel dan tag harus unik
                              FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE, -- Relasi ke tabel articles
                              FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE -- Relasi ke tabel tags
);
