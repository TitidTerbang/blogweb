-- Gunakan database blog_database
USE blog_database;

-- Bersihkan data sebelumnya (jika ada)
SET FOREIGN_KEY_CHECKS = 0; -- Matikan pemeriksaan kunci asing sementara
TRUNCATE TABLE article_tags;
TRUNCATE TABLE comments;
TRUNCATE TABLE articles;
TRUNCATE TABLE tags;
TRUNCATE TABLE categories;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1; -- Hidupkan kembali pemeriksaan kunci asing

-- Seed data untuk tabel users
INSERT INTO users (name, email, password, role) VALUES
                                                    ('Admin', 'admin@example.com', 'hashedpassword1', 'admin'),
                                                    ('Writer1', 'writer1@example.com', 'hashedpassword2', 'writer'),
                                                    ('Reader1', 'reader1@example.com', 'hashedpassword3', 'reader');

-- Seed data untuk tabel categories
INSERT INTO categories (name, slug) VALUES
                                        ('Technology', 'technology'),
                                        ('Health', 'health'),
                                        ('Lifestyle', 'lifestyle');

-- Seed data untuk tabel tags
INSERT INTO tags (name, slug) VALUES
                                  ('PHP', 'php'),
                                  ('React', 'react'),
                                  ('TailwindCSS', 'tailwindcss');

-- Seed data untuk tabel articles
INSERT INTO articles (user_id, category_id, title, slug, content, image_url, status) VALUES
                                                                                         (2, 1, 'Getting Started with PHP', 'getting-started-with-php', 'Learn how to start coding with PHP.', 'https://example.com/images/php.jpg', 'published'),
                                                                                         (2, 1, 'Introduction to React', 'introduction-to-react', 'React is a JavaScript library for building user interfaces.', 'https://example.com/images/react.jpg', 'published'),
                                                                                         (2, 2, 'The Benefits of a Healthy Lifestyle', 'healthy-lifestyle', 'Tips and tricks to maintain a healthy lifestyle.', 'https://example.com/images/health.jpg', 'draft');

-- Seed data untuk tabel comments
INSERT INTO comments (article_id, user_id, content) VALUES
                                                        (1, 3, 'Great article on PHP! Very informative.'),
                                                        (2, 3, 'React seems interesting. I want to learn more.');

-- Seed data untuk tabel article_tags
INSERT INTO article_tags (article_id, tag_id) VALUES
                                                  (1, 1), -- Artikel "Getting Started with PHP" diberi tag "PHP"
                                                  (2, 2), -- Artikel "Introduction to React" diberi tag "React"
                                                  (2, 3); -- Artikel "Introduction to React" juga diberi tag "TailwindCSS"
