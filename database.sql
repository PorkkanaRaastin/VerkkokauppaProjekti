DROP DATABASE IF EXISTS onlinestore;
CREATE DATABASE onlinestore;

CREATE TABLE User (
    username VARCHAR(63) NOT NULL,
    password VARCHAR(2047) NOT NULL,
    userId INTEGER PRIMARY KEY AUTO_INCREMENT
);

CREATE TABLE Categories (
    name VARCHAR(255) NOT NULL,
    categoryId INTEGER PRIMARY KEY AUTO_INCREMENT
);

CREATE TABLE Producers (
    name VARCHAR(255) NOT NULL,
    producerId INTEGER PRIMARY KEY AUTO_INCREMENT
);

CREATE TABLE Orders (
    userId INTEGER NOT NULL,
    time DATETIME NOT NULL,
    orderId INTEGER PRIMARY KEY AUTO_INCREMENT,
    FOREIGN KEY (userId)
    REFERENCES User(userId)
);

CREATE TABLE Cart (
    orderId INTEGER NOT NULL,
    session VARCHAR(31) NOT NULL,
    cartId INTEGER PRIMARY KEY AUTO_INCREMENT,
    FOREIGN KEY (orderId)
    REFERENCES Orders(orderId)
);

CREATE TABLE Products (
    producerId INTEGER NOT NULL,
    categoryId INTEGER NOT NULL,
    name VARCHAR(255) NOT NULL,
    stock INTEGER NOT NULL,
    unit VARCHAR(7) NOT NULL,
    prize DECIMAL(15,7) NOT NULL,
    description TEXT NOT NULL,
    productId INTEGER PRIMARY KEY AUTO_INCREMENT,
    FOREIGN KEY (producerId)
    REFERENCES Producers(producerId),
    FOREIGN KEY (categoryId)
    REFERENCES Categories(categoryId)
);

CREATE TABLE CartItem (
    cartId INTEGER NOT NULL,
    productId INTEGER NOT NULL,
    amount INTEGER NOT NULL,
    itemId INTEGER PRIMARY KEY AUTO_INCREMENT,
    FOREIGN KEY (cartID)
    REFERENCES Cart(cartId),
    FOREIGN KEY (productId)
    REFERENCES Products(productId)
);

INSERT INTO Categories (categoryId, name) VALUES
(1, "Liha"),
(2, "Kala"),
(3, "Viljatuotteet"),
(4, "Marjat"),
(5, "Juustot"),
(6, "Muut tuotteet");

INSERT INTO Producers (producerId, name) VALUES
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

INSERT INTO Products (productId, producerId, categoryId, name, stock, unit, prize, description) VALUES
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