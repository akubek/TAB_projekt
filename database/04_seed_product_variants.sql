-- 04_seed_product_variants.sql

-- Zwróć uwagę na 'images' w deklaracji kolumn poniżej!
INSERT INTO product_variants (product_id, sku, attributes, images, price_modifier, stock_quantity) VALUES 

-- === WARIANTY DLA PRODUKTÓW TESTOWE (EDGE CASES) ===
(100, 'TEST-EMPTY', '{"size": "Universal"}', '[]', 0.00, 0),
(101, 'LAY-FIX-U', '{"size": "Universal"}', '["https://placehold.co/400x500?text=Long+Name+Test"]', 0.00, 50),
(102, 'LUX-GOLD-24K', '{"material": "Złoto 24K"}', '["https://placehold.co/400x500?text=Luxury+Watch"]', 0.00, 2),

-- === WARIANTY DLA PRODUKTÓW ZWYKŁYCH ===

-- ID 1: Kurtka Zimowa The North Face
(1, 'TNF-JKT-M-BLK', '{"size": "M", "color": "Czarny"}', '["https://placehold.co/400x500?text=TNF+Winter+Jacket"]', 0.00, 10),
(1, 'TNF-JKT-L-BLK', '{"size": "L", "color": "Czarny"}', '[]', 0.00, 15),
(1, 'TNF-JKT-XL-BLK', '{"size": "XL", "color": "Czarny"}', '[]', 50.00, 5),

-- ID 2: Koszula Elegancka Vistula
(2, 'VST-SH-39-WHT', '{"size": "39", "color": "Biały"}', '[]', 0.00, 20),
(2, 'VST-SH-40-WHT', '{"size": "40", "color": "Biały"}', '[]', 0.00, 20),

-- ID 3: Koszulka Sportowa Basic Nike
(3, 'NK-TS-S-BLK', '{"size": "S", "color": "Czarny"}', '[]', 0.00, 50),
(3, 'NK-TS-M-BLK', '{"size": "M", "color": "Czarny"}', '["https://placehold.co/400x500?text=Nike+Black+Front", "https://placehold.co/400x500?text=Nike+Black+Back"]', 0.00, 100),
(3, 'NK-TS-L-BLK', '{"size": "L", "color": "Czarny"}', '[]', 0.00, 80),

-- ID 4: Kurtka Ramoneska Zara
(4, 'ZRA-RAM-S-BLK', '{"size": "S", "color": "Czarny"}', '[]', 0.00, 12),
(4, 'ZRA-RAM-M-BLK', '{"size": "M", "color": "Czarny"}', '[]', 0.00, 8),

-- ID 5: Koszula Wiskozowa Reserved
(5, 'RES-SHW-M-BLU', '{"size": "M", "color": "Błękitny"}', '["https://placehold.co/400x500?text=Reserved+Blue"]', 0.00, 45),
(5, 'RES-SHW-L-BLU', '{"size": "L", "color": "Błękitny"}', '[]', 0.00, 20),

-- ID 6: Top Treningowy Puma
(6, 'PUM-TOP-S-PNK', '{"size": "S", "color": "Różowy"}', '[]', 0.00, 25),

-- ID 7: Sweter z Reniferem Smyk
(7, 'SMY-SW-104-RED', '{"size": "104", "color": "Czerwony"}', '[]', 0.00, 15),

-- ID 8: T-Shirt T-Rex Coccodrillo
(8, 'COC-TR-110-GRN', '{"size": "110", "color": "Zielony"}', '[]', 0.00, 20),

-- ID 9: Koszulka Oversize H&M
(9, 'HM-UNI-M-GRY', '{"size": "M", "color": "Szary Melange"}', '[]', 0.00, 60),
(9, 'HM-UNI-L-GRY', '{"size": "L", "color": "Szary Melange"}', '[]', 0.00, 50),

-- ID 10: Koszulka Treningowa Tiro Adidas
(10, 'ADI-TIR-M-NVY', '{"size": "M", "color": "Granatowy"}', '["https://placehold.co/400x500?text=Adidas+Tiro"]', 0.00, 50),

-- ID 11: T-Shirt Classics Puma
(11, 'PUM-CLS-M-WHT', '{"size": "M", "color": "Biały"}', '[]', 0.00, 25),

-- ID 12: Koszulka Compression Reebok
(12, 'RBK-CMP-M-BLK', '{"size": "M", "color": "Czarny"}', '[]', 0.00, 15),

-- ID 13: Koszulka Rush Under Armour
(13, 'UA-RSH-M-RED', '{"size": "M", "color": "Czerwony"}', '[]', 0.00, 20),

-- ID 14: T-Shirt Premium Nike
(14, 'NK-PRM-L-BEG', '{"size": "L", "color": "Beżowy"}', '[]', 0.00, 10),

-- ID 15: Koszula Lniana Zara
(15, 'ZRA-LIN-M-WHT', '{"size": "M", "color": "Biały"}', '["https://placehold.co/400x500?text=Zara+Linen"]', 0.00, 12),

-- ID 16: Koszula Satynowa H&M
(16, 'HM-SAT-S-BLK', '{"size": "S", "color": "Czarny"}', '[]', 0.00, 15),

-- ID 17: Koszula Boho Mango
(17, 'MNG-BOH-M-MLT', '{"size": "M", "color": "Wielokolorowy"}', '[]', 0.00, 20),

-- ID 18: Koszula Jeansowa Reserved
(18, 'RES-JNS-S-BLU', '{"size": "S", "color": "Niebieski"}', '[]', 0.00, 25),

-- ID 19: Koszula z Bufkami Mohito
(19, 'MOH-BUF-S-WHT', '{"size": "S", "color": "Perłowa Biel"}', '[]', 0.00, 10);