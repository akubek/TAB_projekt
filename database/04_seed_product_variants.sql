-- 04_seed_product_variants.sql

INSERT INTO product_variants (product_id, sku, attributes, images, price_modifier, stock_quantity) VALUES 

-- === WARIANTY DLA PRODUKTÓW TESTOWE (EDGE CASES) ===
(100, 'TEST-EMPTY', '{"size": "Universal"}', '[]', 0.00, 0),
(101, 'LAY-FIX-U', '{"size": "Universal"}', '["https://placehold.co/400x500?text=Long+Name+Test"]', 0.00, 50),
(102, 'LUX-GOLD-24K', '{"color": "mustard", "material": "Złoto 24K"}', '["https://placehold.co/400x500?text=Luxury+Watch"]', 0.00, 2),

-- === WARIANTY DLA PRODUKTÓW ZWYKŁYCH ===

-- ID 1: Kurtka Zimowa The North Face (Różne ilości zdjęć dla testów)
(1, 'TNF-JKT-M-BLK', '{"size": "M", "color": "black"}', '["https://placehold.co/400x500?text=TNF+Winter+M+Front", "https://placehold.co/400x500?text=TNF+Winter+M+Back", "https://placehold.co/400x500?text=TNF+Winter+M+Detail"]', 0.00, 10),
(1, 'TNF-JKT-L-BLK', '{"size": "L", "color": "black"}', '["https://placehold.co/400x500?text=TNF+Winter+L+Front"]', 0.00, 15),
(1, 'TNF-JKT-XL-BLK', '{"size": "XL", "color": "black"}', '[]', 50.00, 5),

-- ID 2: Koszula Elegancka Vistula
(2, 'VST-SH-39-WHT', '{"size": "39", "color": "white"}', '["https://placehold.co/400x500?text=Vistula+Front", "https://placehold.co/400x500?text=Vistula+Collar"]', 0.00, 20),
(2, 'VST-SH-40-WHT', '{"size": "40", "color": "white"}', '["https://placehold.co/400x500?text=Vistula+Front", "https://placehold.co/400x500?text=Vistula+Collar"]', 0.00, 20),

-- ID 3: Koszulka Sportowa Basic Nike (Rozbudowana galeria)
(3, 'NK-TS-S-BLK', '{"size": "S", "color": "black"}', '["https://placehold.co/400x500?text=Nike+Black+S"]', 0.00, 50),
(3, 'NK-TS-M-BLK', '{"size": "M", "color": "black"}', '["https://placehold.co/400x500?text=Nike+Black+M+1", "https://placehold.co/400x500?text=Nike+Black+M+2", "https://placehold.co/400x500?text=Nike+Black+M+3", "https://placehold.co/400x500?text=Nike+Black+M+4"]', 0.00, 100),
(3, 'NK-TS-L-BLK', '{"size": "L", "color": "black"}', '[]', 0.00, 80),

-- ID 4: Kurtka Ramoneska Zara
(4, 'ZRA-RAM-S-BLK', '{"size": "S", "color": "black"}', '["https://placehold.co/400x500?text=Zara+Ramoneska+Front", "https://placehold.co/400x500?text=Zara+Ramoneska+Side"]', 0.00, 12),
(4, 'ZRA-RAM-M-BLK', '{"size": "M", "color": "black"}', '["https://placehold.co/400x500?text=Zara+Ramoneska+Front", "https://placehold.co/400x500?text=Zara+Ramoneska+Side"]', 0.00, 8),

-- ID 5: Koszula Wiskozowa Reserved
(5, 'RES-SHW-M-BLU', '{"size": "M", "color": "light_blue"}', '["https://placehold.co/400x500?text=Reserved+Blue+Front"]', 0.00, 45),
(5, 'RES-SHW-L-BLU', '{"size": "L", "color": "light_blue"}', '[]', 0.00, 20),

-- ID 6: Top Treningowy Puma
(6, 'PUM-TOP-S-PNK', '{"size": "S", "color": "pink"}', '["https://placehold.co/400x500?text=Puma+Pink+1", "https://placehold.co/400x500?text=Puma+Pink+2", "https://placehold.co/400x500?text=Puma+Pink+3"]', 0.00, 25),

-- Pozostałe (skrócone listy bez zdjęć lub z 1 dla różnorodności)
(7, 'SMY-SW-104-RED', '{"size": "104", "color": "red"}', '["https://placehold.co/400x500?text=Smyk+Sweater"]', 0.00, 15),
(8, 'COC-TR-110-GRN', '{"size": "110", "color": "bottle_green"}', '[]', 0.00, 20),
(9, 'HM-UNI-M-GRY', '{"size": "M", "color": "gray_melange"}', '["https://placehold.co/400x500?text=HM+Grey+M"]', 0.00, 60),
(9, 'HM-UNI-L-GRY', '{"size": "L", "color": "gray_melange"}', '["https://placehold.co/400x500?text=HM+Grey+L"]', 0.00, 50),
(10, 'ADI-TIR-M-NVY', '{"size": "M", "color": "navy_blue"}', '["https://placehold.co/400x500?text=Adidas+Tiro+1", "https://placehold.co/400x500?text=Adidas+Tiro+2"]', 0.00, 50),
(11, 'PUM-CLS-M-WHT', '{"size": "M", "color": "white"}', '[]', 0.00, 25),
(12, 'RBK-CMP-M-BLK', '{"size": "M", "color": "black"}', '["https://placehold.co/400x500?text=Reebok+Front"]', 0.00, 15),
(13, 'UA-RSH-M-RED', '{"size": "M", "color": "red"}', '[]', 0.00, 20),
(14, 'NK-PRM-L-BEG', '{"size": "L", "color": "beige"}', '["https://placehold.co/400x500?text=Nike+Beige"]', 0.00, 10),
(15, 'ZRA-LIN-M-WHT', '{"size": "M", "color": "white"}', '["https://placehold.co/400x500?text=Zara+Linen+1", "https://placehold.co/400x500?text=Zara+Linen+2"]', 0.00, 12),
(16, 'HM-SAT-S-BLK', '{"size": "S", "color": "black"}', '[]', 0.00, 15),
(17, 'MNG-BOH-M-MLT', '{"size": "M", "color": "pink"}', '["https://placehold.co/400x500?text=Mango+Boho"]', 0.00, 20),
(18, 'RES-JNS-S-BLU', '{"size": "S", "color": "light_blue"}', '["https://placehold.co/400x500?text=Reserved+Jeans+1", "https://placehold.co/400x500?text=Reserved+Jeans+2"]', 0.00, 25),
(19, 'MOH-BUF-S-WHT', '{"size": "S", "color": "white"}', '[]', 0.00, 10);
