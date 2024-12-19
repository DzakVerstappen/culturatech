-- Tabel untuk pengguna (user)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk produk (barang yang dijual)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image_url VARCHAR(255),
    seller_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id)
);

-- Tabel untuk keranjang belanja (cart)
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,     -- ID unik untuk setiap entri keranjang
    user_id INT NOT NULL,                  -- Wajib terhubung ke pengguna yang login
    product_id INT NOT NULL,               -- Produk wajib dipilih
    quantity INT DEFAULT 1,                -- Default jumlah adalah 1
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Waktu penambahan otomatis
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,  -- Hapus entri jika pengguna dihapus
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE -- Hapus entri jika produk dihapus
);


-- Tabel untuk transaksi atau pesanan (orders)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel untuk detail pesanan
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
