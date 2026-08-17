-- Auksion + ştat üzrə ABŞ daxili daşınma tarifləri
CREATE TABLE IF NOT EXISTS shipping_states (
  id INT PRIMARY KEY AUTO_INCREMENT,
  auction VARCHAR(30) NOT NULL,
  state_name VARCHAR(80) NOT NULL,
  port VARCHAR(80),
  cost INT DEFAULT 250,
  UNIQUE KEY uq_auction_state (auction, state_name)
) DEFAULT CHARSET=utf8mb4;
