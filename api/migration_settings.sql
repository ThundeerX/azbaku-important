-- AzBaku — Sayt tənzimləmələri cədvəli (kalkulyator tarifləri, əlaqə, sosial)
CREATE TABLE IF NOT EXISTS site_settings (
  skey VARCHAR(60) PRIMARY KEY,
  svalue TEXT
);

INSERT INTO site_settings (skey, svalue) VALUES
('fee_copart','12'),('fee_iaai','10'),('fee_manheim','10'),
('fee_adesa','10'),('fee_edge','10'),('fee_encar','5'),
('inland_cost','250'),('service_fee','450'),('azn_rate','1.70'),
('ocean_poti_sedan','1100'),('ocean_poti_suv','1200'),('ocean_poti_truck','1400'),
('ocean_poti_van','1300'),('ocean_poti_ev','1000'),('ocean_poti_hybrid','1150'),('ocean_poti_premium','1350'),
('ocean_baku_sedan','1500'),('ocean_baku_suv','1650'),('ocean_baku_truck','1900'),
('ocean_baku_van','1750'),('ocean_baku_ev','1400'),('ocean_baku_hybrid','1600'),('ocean_baku_premium','1800'),
('customs_1_3','20'),('customs_4_7','25'),('customs_8plus','30'),('customs_ev_discount','50'),
('phone','070 888 42 42'),('email','info@azbaku.az'),('address','Bakı, Azərbaycan'),
('instagram','#'),('facebook','#'),('whatsapp','#')
ON DUPLICATE KEY UPDATE svalue=svalue;
