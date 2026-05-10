-- 04_seed_product_variants.sql

INSERT INTO product_variants (product_id, sku, attributes, images, variant_price, stock_quantity) VALUES 

-- === WARIANTY DLA PRODUKTÓW TESTOWYCH (EDGE CASES) ===
(100, 'TEST-EMPTY', '{"size": "Universal"}', '[]', 0.00, 0),
(101, 'LAY-FIX-U', '{"size": "Universal"}', '["https://placehold.co/400x500?text=Long+Name+Test"]', 9.99, 50),
(102, 'LUX-GOLD-24K', '{"color": "mustard", "material": "Złoto 24K"}', '["https://placehold.co/400x500?text=Luxury+Watch"]', 99999.99, 2),

-- === WARIANTY DLA PRODUKTÓW ZWYKŁYCH ===

-- ID 1: Kurtka Zimowa The North Face (Cena bazowa 899.00)
(1, 'TNF-JKT-M-BLK', '{"size": "M", "color": "black"}', '["https://placehold.co/400x500?text=TNF+Winter+M+Front", "https://placehold.co/400x500?text=TNF+Winter+M+Back", "https://placehold.co/400x500?text=TNF+Winter+M+Detail"]', 899.00, 10),
(1, 'TNF-JKT-L-BLK', '{"size": "L", "color": "black"}', '["https://placehold.co/400x500?text=TNF+Winter+L+Front"]', 899.00, 15),
(1, 'TNF-JKT-XL-BLK', '{"size": "XL", "color": "black"}', '[]', 949.00, 5), -- Tu był modyfikator +50.00

-- ID 2: Koszula Elegancka Vistula (Cena bazowa 199.50)
(2, 'VST-SH-39-WHT', '{"size": "39", "color": "white"}', '["https://placehold.co/400x500?text=Vistula+Front", "https://placehold.co/400x500?text=Vistula+Collar"]', 199.50, 20),
(2, 'VST-SH-40-WHT', '{"size": "40", "color": "white"}', '["https://placehold.co/400x500?text=Vistula+Front", "https://placehold.co/400x500?text=Vistula+Collar"]', 199.50, 20),

-- ID 3: Koszulka Sportowa Basic Nike (Cena bazowa 129.99)
(3, 'NK-TS-S-BLK', '{"size": "S", "color": "black"}', '["https://placehold.co/400x500?text=Nike+Black+S"]', 129.99, 50),
(3, 'NK-TS-M-BLK', '{"size": "M", "color": "black"}', '["https://placehold.co/400x500?text=Nike+Black+M+1", "https://placehold.co/400x500?text=Nike+Black+M+2", "https://placehold.co/400x500?text=Nike+Black+M+3", "https://placehold.co/400x500?text=Nike+Black+M+4"]', 129.99, 100),
(3, 'NK-TS-L-BLK', '{"size": "L", "color": "black"}', '[]', 129.99, 80),

-- ID 4: Kurtka Ramoneska Zara (Cena bazowa 249.99)
(4, 'ZRA-RAM-S-BLK', '{"size": "S", "color": "black"}', '["https://placehold.co/400x500?text=Zara+Ramoneska+Front", "https://placehold.co/400x500?text=Zara+Ramoneska+Side"]', 249.99, 12),
(4, 'ZRA-RAM-M-BLK', '{"size": "M", "color": "black"}', '["https://placehold.co/400x500?text=Zara+Ramoneska+Front", "https://placehold.co/400x500?text=Zara+Ramoneska+Side"]', 249.99, 8),

-- ID 5: Koszula Wiskozowa Reserved (Cena bazowa 119.99)
(5, 'RES-SHW-M-BLU', '{"size": "M", "color": "light_blue"}', '["https://placehold.co/400x500?text=Reserved+Blue+Front"]', 119.99, 45),
(5, 'RES-SHW-L-BLU', '{"size": "L", "color": "light_blue"}', '[]', 119.99, 20),

-- ID 6: Top Treningowy Puma (Cena bazowa 99.99)
(6, 'PUM-TOP-S-PNK', '{"size": "S", "color": "pink"}', '["https://placehold.co/400x500?text=Puma+Pink+1", "https://placehold.co/400x500?text=Puma+Pink+2", "https://placehold.co/400x500?text=Puma+Pink+3"]', 99.99, 25),

-- Pozostałe (skrócone listy bez zdjęć lub z 1 dla różnorodności)
(7, 'SMY-SW-104-RED', '{"size": "104", "color": "red"}', '["https://placehold.co/400x500?text=Smyk+Sweater"]', 89.99, 15),
(8, 'COC-TR-110-GRN', '{"size": "110", "color": "bottle_green"}', '[]', 49.99, 20),
(9, 'HM-UNI-M-GRY', '{"size": "M", "color": "gray_melange"}', '["https://placehold.co/400x500?text=HM+Grey+M"]', 59.99, 60),
(9, 'HM-UNI-L-GRY', '{"size": "L", "color": "gray_melange"}', '["https://placehold.co/400x500?text=HM+Grey+L"]', 59.99, 50),
(10, 'ADI-TIR-M-NVY', '{"size": "M", "color": "navy_blue"}', '["https://placehold.co/400x500?text=Adidas+Tiro+1", "https://placehold.co/400x500?text=Adidas+Tiro+2"]', 119.99, 50),
(11, 'PUM-CLS-M-WHT', '{"size": "M", "color": "white"}', '[]', 99.99, 25),
(12, 'RBK-CMP-M-BLK', '{"size": "M", "color": "black"}', '["https://placehold.co/400x500?text=Reebok+Front"]', 89.99, 15),
(13, 'UA-RSH-M-RED', '{"size": "M", "color": "red"}', '[]', 149.99, 20),
(14, 'NK-PRM-L-BEG', '{"size": "L", "color": "beige"}', '["https://placehold.co/400x500?text=Nike+Beige"]', 159.99, 10),
(15, 'ZRA-LIN-M-WHT', '{"size": "M", "color": "white"}', '["https://placehold.co/400x500?text=Zara+Linen+1", "https://placehold.co/400x500?text=Zara+Linen+2"]', 149.90, 12),
(16, 'HM-SAT-S-BLK', '{"size": "S", "color": "black"}', '[]', 129.99, 15),
(17, 'MNG-BOH-M-MLT', '{"size": "M", "color": "pink"}', '["https://placehold.co/400x500?text=Mango+Boho"]', 139.99, 20),
(18, 'RES-JNS-S-BLU', '{"size": "S", "color": "light_blue"}', '["https://placehold.co/400x500?text=Reserved+Jeans+1", "https://placehold.co/400x500?text=Reserved+Jeans+2"]', 159.99, 25),
(19, 'MOH-BUF-S-WHT', '{"size": "S", "color": "white"}', '[]', 119.99, 10);
