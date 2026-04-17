SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE Cart (
  id int(11) NOT NULL,
  orderId int(11) NOT NULL,
  session varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE CartItem (
  id int(11) NOT NULL,
  cartId int(11) NOT NULL,
  productId int(11) NOT NULL,
  amount int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE Categories (
  id int(11) NOT NULL,
  name varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO Categories ("id", "name") VALUES
(1, "Liha"),
(2, "Kala"),
(3, "Viljatuotteet"),
(4, "Marjat"),
(5, "Juustot"),
(6, "Muut tuotteet");

CREATE TABLE "orders" (
  "id" int(11) NOT NULL,
  "session" varchar(30) NOT NULL,
  "name" varchar(200) NOT NULL,
  "email" varchar(200) NOT NULL,
  "phone" varchar(30) NOT NULL,
  "datetime" datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE "producers" (
  "id" int(11) NOT NULL,
  "name" varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO "producers" ("id", "name") VALUES
(1, "Ellun kanat"),
(2, "Luomuvilja Oy"),
(3, "Sysimetsän hunajatila"),
(4, "Vipeltäjäfarmi"),
(5, "Valajan tuottajat"),
(6, "Jannen mehustamo"),
(7, "Rapalanmäen kala Oy"),
(8, "Alkuviljan tila Ky"),
(9, "Metsälläkävijät Osuuskunta"),
(10, "Munkkilan mäkijuusto");

CREATE TABLE "products" (
  "id" int(11) NOT NULL,
  "producer_id" int(11) NOT NULL,
  "category_id" int(11) NOT NULL,
  "name" varchar(200) NOT NULL,
  "stock" int(11) NOT NULL,
  "unit" varchar(5) NOT NULL,
  "prize" decimal(10,2) NOT NULL,
  "description" text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO "products" ("id", "producer_id", "category_id", "name", "stock", "unit", "prize", "description") VALUES
(1, 5, 2, "Rotunaudan sisäfilee", 15, "kg", "52.00", "Sydänmaan Highlander luomulihasta sisäfilee, n. 800g. Kilohinta."),
(2, 5, 1, "Rotukarjan paistisuikaleet", 13, "kg", "46.00", "Rotukarjan ulkofileestä tehty paistisuikale. Paketissa 1kg."),
(3, 1, 1, "Kalkkunan ohut schnitzel ", 57, "kg", "4.90", "Ohueksi moukaroidut kalkkunaleike 4kpl ja 320g paketti"),
(4, 1, 1, "Luomu broileri", 25, "kg", "15.50", "Kokonainen n. 1.4kg luomubroileri"),
(5, 7, 2, "KalaWursti", 17, "kpl", "7.20", "Suomalaisestä järvikalasta tuotettu makkara 240g paketti"),
(6, 7, 2, "Kuhafilee", 28, "kpl", "8.20", "Kuhaa fileenä 300g paketti\r\n"),
(7, 7, 2, "Silakkapihvi", 41, "kpl", "5.10", "Valmiiksi tehdyt silakkapihvit 4kpl ja 280g paketti"),
(8, 7, 2, "Järkälesärki yrttimaustettuna", 15, "kpl", "4.50", "Yrttimaustettua särkeä rapsiöljyssä 250g/200g purkeissa"),
(9, 2, 3, "Hienojauhettu Luomu \"00\" spelttijauho", 70, "kpl", "4.00", "Spelttijauhoa jauhettuna pizzajauhojen karkeudella 1kg"),
(10, 2, 3, "Luomu kaurajauhoja", 45, "kpl", "2.40", "Gluteenittomia luomu kaurajauhoja 1kg"),
(11, 2, 3, "Gluteeniton vehnäjauho", 67, "kpl", "3.70", "Yleisvehnäjauho leivontaan ja piirakoihin 1kg "),
(12, 8, 3, "Suomalaista alkuviljaa \"kamut\"", 51, "kpl", "3.70", "Vatsaystävällistä jalostamatonta \"Kamut\" alkuviljaa 1kg"),
(13, 6, 4, "Tyrnijauho", 51, "kpl", "2.50", "Superruokana puuroon tai jugurttiin hienoksi jauhettu tyrni 50g paketti"),
(14, 6, 6, "Tuorepuristettu omenamehu", 31, "kpl", "8.50", "Tuorepuristettu mehu Lobo omenasta 3 litran hanapakkauksissa"),
(15, 9, 6, "Metsämustikkamehu", 31, "kpl", "11.70", "Mustikkamehua 3 litran hanapakkauksissa"),
(16, 9, 6, "Puolukkamehu", 30, "kpl", "10.30", "Puolukkamehua 3 litran hanapakkauksissa"),
(17, 5, 5, "Valajan Brie", 50, "kpl", "6.20", "Ranskalaistyyppinen brie -juusto 150g kiekoissa"),
(18, 5, 5, "Valajan Gouda", 36, "kpl", "4.00", "Hollantilaistyylinen mieto Gouda 250g pakkauksissa"),
(19, 10, 5, "Luostarijuusto", 10, "kpl", "4.00", "Vanhan ajan kotijuustoa muistuttava tuote 200g paketti"),
(20, 10, 5, "Munkkijuusto", 40, "kpl", "8.80", "Suomalainen kermajuusto 500g pakkauksissa"),
(21, 4, 6, "Kuivatut ja suolatut heinäsirkat", 27, "kpl", "2.40", "Suomessa kasvatettujen heinäsirkkojen 50g herkkupussi "),
(22, 4, 6, "Heinäsirkkasipsit", 5, "kpl", "2.50", "Rasvassa paistetut ja suolatut heinäsirkat 75g pussi"),
(23, 3, 6, "Kukkaishunaja", 40, "kpl", "5.20", "Keski-Suomalainen keskikesän kukkaishunaja 350g paketti"),
(24, 3, 6, "Luomu hunaja", 28, "kpl", "4.80", "Kiteeltä kerätty Luomu hunajan 350g"),
(25, 1, 1, "Hunajamarinoitu rintafilee", 45, "kg", "17.60", "n. 700g pakkauksessa 5-6kpl hunajamarinoituja kanan rintafileitä. Kilohinta."),
(26, 2, 3, "Vehnäjauho", 27, "kpl", "4.20", "Leivontaan erittäin hyvin soveltuva, laadukas vehnäjauho 1kg paketissa"),
(27, 3, 6, "Kesäkukkahunaja", 50, "kpl", "4.70", "Juokseva kesäkukkaishunaja, 500g"),
(28, 4, 6, "Paistetut heinäsirkat", 70, "kpl", "3.80", "Voissa paistetut heinäsirjat, 500g uudelleenavattavassa rasiassa"),
(29, 5, 5, "Valajan Turunmaa", 25, "kpl", "8.90", "Kevyt, mutta vivahdeikas kermajuusto 500g pakkauksessa"),
(30, 6, 6, "Mansikkamehu", 47, "kpl", "11.50", "Todella maukas mansikkamehu 3l hanapakkauksessa"),
(31, 7, 2, "Lasimestarin silli", 25, "kpl", "8.30", "Todella maukasta lasimestarin silliä 700g purkissa"),
(32, 8, 3, "Spelttijauho", 40, "kpl", "9.20", "Gluteiinitinon spelttijauho 1kg paketissa"),
(33, 8, 3, "Tattarijauho, luomu", 30, "kg", "4.20", "Sopii rieskojen, leipästen, piirakoiden, torttujen, kakkujen ja muiden leivonnaisten leivontaan."),
(34, 9, 1, "Hirvenpaisti", 20, "kg", "17.20", "Raakakypsytetty hirvenpaisti n. 800g paloina. Kilohinta"),
(35, 10, 5, "Gouda", 32, "kpl", "7.20", "Mieto, pitkään kypsennetty gouda 500g paketissa");

ALTER TABLE "cart"
  ADD PRIMARY KEY ("id");

ALTER TABLE "cart_item"
  ADD PRIMARY KEY ("id");

ALTER TABLE "categories"
  ADD PRIMARY KEY ("id");

ALTER TABLE "orders"
  ADD PRIMARY KEY ("id");

ALTER TABLE "producers"
  ADD PRIMARY KEY ("id");

ALTER TABLE "products"
  ADD PRIMARY KEY ("id");

ALTER TABLE "cart"
  MODIFY "id" int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE "cart_item"
  MODIFY "id" int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE "categories"
  MODIFY "id" int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE "orders"
  MODIFY "id" int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE "producers"
  MODIFY "id" int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE "products"
  MODIFY "id" int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;