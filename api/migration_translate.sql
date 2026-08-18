-- AI tərcümə keşi
CREATE TABLE IF NOT EXISTS translation_cache (
  src_hash CHAR(32) NOT NULL,
  lang VARCHAR(5) NOT NULL,
  source TEXT,
  translated TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (src_hash, lang)
) DEFAULT CHARSET=utf8mb4;

-- AI API key üçün sahə
INSERT INTO site_settings (skey, svalue) VALUES ('ai_api_key','')
ON DUPLICATE KEY UPDATE svalue=svalue;
