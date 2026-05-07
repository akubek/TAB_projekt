-- 03_seed_products.sql

-- Wstawianie produktów tylko do "liści" kategorii
INSERT INTO products (id, category_id, brand_name, main_image, name, description, base_price, attributes) VALUES 

-- 03-- === ODZIEŻ MĘSKA ===
-- 101: Kurtki (Męskie)
(1, 101, 'The North Face', 'https://placehold.co/400x500?text=Kurtka+Zimowa+North+Face', 'Kurtka Zimowa Puchowa', 'Bardzo ciepła kurtka na srogą zimę, wodoodporna.', 899.00, '{"available_sizes": ["M", "L", "XL"], "available_colors": ["black"]}'),

-- 102: Koszule (Męskie)
(2, 102, 'Vistula', 'https://placehold.co/400x500?text=Koszula+Elegancka+Vistula', 'Koszula Elegancka Slim Fit', 'Biała koszula bawełniana, idealna do garnituru.', 199.50, '{"available_sizes": ["39", "40"], "available_colors": ["white"]}'),

-- 103: T-Shirty (Męskie) 
(3, 103, 'Nike', 'https://placehold.co/400x500?text=Koszulka+Sportowa+Nike', 'Koszulka Sportowa Basic', 'Oddychająca koszulka do biegania i na siłownię.', 129.99, '{"available_sizes": ["S", "M", "L"], "available_colors": ["black"]}'),
(10, 103, 'Adidas', 'https://placehold.co/400x500?text=Koszulka+Treningowa+Tiro', 'Koszulka Treningowa Tiro', 'Szybkoschnący materiał z technologią Aeroready.', 119.99, '{"available_sizes": ["M"], "available_colors": ["navy_blue"]}'),
(11, 103, 'Puma', 'https://placehold.co/400x500?text=T-Shirt+Classics+Logo', 'T-Shirt Classics Logo', 'Klasyczna bawełniana koszulka z dużym logo na piersi.', 99.99, '{"available_sizes": ["M"], "available_colors": ["white"]}'),
(12, 103, 'Reebok', 'https://placehold.co/400x500?text=Koszulka+Compression', 'Koszulka Compression', 'Dopasowana koszulka, idealna pod inne warstwy ubrań.', 89.99, '{"available_sizes": ["M"], "available_colors": ["black"]}'),
(13, 103, 'Under Armour', 'https://placehold.co/400x500?text=Koszulka+Termoaktywna+Rush', 'Koszulka Termoaktywna Rush', 'Oddaje energię do mięśni, poprawia wydolność.', 149.99, '{"available_sizes": ["M"], "available_colors": ["red"]}'),
(14, 103, 'Nike', 'https://placehold.co/400x500?text=T-Shirt+Premium+Oversize', 'T-Shirt Premium Oversize', 'Bardzo gruby, mięsisty materiał, krój oversize.', 159.99, '{"available_sizes": ["L"], "available_colors": ["beige"]}'),


-- === ODZIEŻ DAMSKA ===
-- 201: Kurtki (Damskie)
(4, 201, 'Zara', 'https://placehold.co/400x500?text=Kurtka+Ramoneska', 'Kurtka Ramoneska Skórzana', 'Klasyczna czarna ramoneska z ekoskóry z paskiem.', 249.99, '{"available_sizes": ["S", "M"], "available_colors": ["black"]}'),

-- 202: Koszule (Damskie) 
(5, 202, 'Reserved', 'https://placehold.co/400x500?text=Koszula+Wiskozowa', 'Koszula Wiskozowa', 'Lekka i zwiewna koszula damska na co dzień, kolor błękitny.', 119.99, '{"available_sizes": ["M", "L"], "available_colors": ["light_blue"]}'),
(15, 202, 'Zara', 'https://placehold.co/400x500?text=Koszula+Lniana+Premium', 'Koszula Lniana Premium', 'W 100% z naturalnego lnu, bardzo przewiewna, na upalne dni.', 149.90, '{"available_sizes": ["M"], "available_colors": ["white"]}'),
(16, 202, 'H&M', 'https://placehold.co/400x500?text=Koszula+Satynowa', 'Koszula Satynowa', 'Elegancka koszula z delikatnym połyskiem, lejący materiał.', 129.99, '{"available_sizes": ["S"], "available_colors": ["black"]}'),
(17, 202, 'Mango', 'https://placehold.co/400x500?text=Koszula+w+Kwiaty+Boho', 'Koszula w Kwiaty Boho', 'Wiosenny, kwiatowy wzór, luźny krój z falbankami.', 139.99, '{"available_sizes": ["M"], "available_colors": ["pink"]}'),
(18, 202, 'Reserved', 'https://placehold.co/400x500?text=Koszula+Jeansowa', 'Koszula Jeansowa Vintage', 'Klasyczna katana koszulowa z niebieskiego denimu.', 159.99, '{"available_sizes": ["S"], "available_colors": ["light_blue"]}'),
(19, 202, 'Mohito', 'https://placehold.co/400x500?text=Koszula+z+Bufkami', 'Elegancka Koszula z Bufkami', 'Ozdobne rękawy, dopasowana w talii, kolor perłowa biel.', 119.99, '{"available_sizes": ["S"], "available_colors": ["white"]}'),

-- 203: T-Shirty (Damskie)
(6, 203, 'Puma', 'https://placehold.co/400x500?text=Top+Treningowy', 'Top Treningowy', 'Damska koszulka bez rękawów z przewiewnej siateczki.', 99.99, '{"available_sizes": ["S"], "available_colors": ["pink"]}'),

-- === ODZIEŻ DZIECIĘCA ===
-- 301: Swetry (Dziecięce)
(7, 301, 'Smyk', 'https://placehold.co/400x500?text=Sweter+z+Reniferem', 'Sweter z Reniferem', 'Ciepły świąteczny sweterek dla chłopca lub dziewczynki.', 89.99, '{"available_sizes": ["104"], "available_colors": ["red"]}'),
-- 302: Koszulki (Dziecięce)
(8, 302, 'Coccodrillo', 'https://placehold.co/400x500?text=T-Shirt+T-Rex', 'T-Shirt T-Rex', 'Bawełniana koszulka z nadrukiem dinozaura.', 49.99, '{"available_sizes": ["110"], "available_colors": ["bottle_green"]}'),

-- === ODZIEŻ UNISEX ===
-- 401: Koszulki (Unisex)
(9, 401, 'H&M', 'https://placehold.co/400x500?text=Koszulka+Oversize', 'Koszulka Oversize', 'Gładka, bawełniana koszulka o bardzo luźnym kroju.', 59.99, '{"available_sizes": ["M", "L"], "available_colors": ["gray_melange"]}'),

-- === PRODUKTY TESTOWE (EDGE CASES) ===
(100, 402, 'TEST_BRAND', 'https://placehold.co/400x500?text=TEST_NO_STOCK', 'TEST_NO_STOCK', 'Ten produkt służy do testowania braku dostępności na magazynie. Nie powinien dać się dodać do koszyka.', 0.00, '{"available_sizes": ["Universal"], "available_colors": []}'),
(101, 402, 'LayoutFix', 'https://placehold.co/400x500?text=TEST_LAYOUT', 'TEST_LAYOUT', 'Lorem ipsum test text...', 9.99, '{"available_sizes": ["Universal"], "available_colors": []}'),
(102, 402, 'Luxury Gold', 'https://placehold.co/400x500?text=Luxury+Watch', 'Złoty Zegarek Kolekcjonerski', 'Produkt o bardzo wysokiej cenie do testów.', 99999.99, '{"available_sizes": [], "available_colors": ["mustard"]}');

-- Aktualizacja sekwencji dla tabeli products
SELECT setval('products_id_seq', (SELECT MAX(id) FROM products));
