-- MySQL dump 10.16  Distrib 10.2.15-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: u905801586_noble
-- ------------------------------------------------------
-- Server version	10.2.15-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Genre`
--

DROP TABLE IF EXISTS `Genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Genre` (
  `GenreID` int(11) NOT NULL AUTO_INCREMENT,
  `GenreName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `GenreID` (`GenreID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Genre`
--

/*!40000 ALTER TABLE `Genre` DISABLE KEYS */;
INSERT INTO `Genre` VALUES (1,'Classics'),(2,'Children'),(3,'Fantasy'),(4,'Historical'),(5,'Nonfiction'),(6,'Romance'),(7,'Science Fiction');
/*!40000 ALTER TABLE `Genre` ENABLE KEYS */;

--
-- Table structure for table `GenreList`
--

DROP TABLE IF EXISTS `GenreList`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GenreList` (
  `GLID` int(11) NOT NULL AUTO_INCREMENT,
  `ISBN-13` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `GenreID` int(11) NOT NULL,
  PRIMARY KEY (`GLID`),
  UNIQUE KEY `GenreListEntryID` (`GLID`),
  KEY `ISBN-13` (`ISBN-13`),
  KEY `GenreID` (`GenreID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GenreList`
--

/*!40000 ALTER TABLE `GenreList` DISABLE KEYS */;
INSERT INTO `GenreList` VALUES (1,'978-0140424386',1),(2,'978-0785157267',7),(3,'978-0807000670',5),(4,'978-1420953381',1),(5,'978-1420953381',6),(6,'978-0140424386',1),(7,'978-0440414124',4),(8,'978-0393089059',1),(9,'978-0393089059',6),(10,'978-0140449303',1),(11,'978-0871356604',3),(12,'978-0871356604',7),(13,'978-1497438095',1),(14,'978-1497438095',6),(15,'978-0590481090',5),(16,'978-0385386555',4),(17,'978-0143106296',1),(18,'978-0143106296',6),(19,'978-0440414124',2),(20,'978-0385386555',2),(21,'978-0060256678',2),(22,'978-0060598242',2),(23,'978-0060598242',3),(24,'978-0142411599',7),(25,'978-0142411599',2),(26,'978-0290204890',3),(27,'978-0439120425',2),(28,'978-0679882831',2),(29,'978-1401216672',3),(30,'978-1401245252',3),(31,'978-1401245252',7),(32,'978-1594746376',7),(33,'',0),(34,'978-1401232597',3),(35,'978-1401232597',3);
/*!40000 ALTER TABLE `GenreList` ENABLE KEYS */;

--
-- Table structure for table `OrderInfo`
--

DROP TABLE IF EXISTS `OrderInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OrderInfo` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL,
  `ISBN-13` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `UnitsPurchased` int(11) NOT NULL,
  `TotalPrice` double NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrderInfo`
--

/*!40000 ALTER TABLE `OrderInfo` DISABLE KEYS */;
INSERT INTO `OrderInfo` VALUES ();
/*!40000 ALTER TABLE `OrderInfo` ENABLE KEYS */;

--
-- Table structure for table `Product`
--

DROP TABLE IF EXISTS `Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product` (
  `ISBN-13` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `Title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Price` double NOT NULL,
  `Weight` double NOT NULL,
  `UnitsInStorage` int(11) NOT NULL,
  `Dimension` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `ImagePath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ISBN-13`),
  UNIQUE KEY `ImagePath` (`ImagePath`),
  UNIQUE KEY `ProductID` (`ISBN-13`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` VALUES ('978-0060256678','Where the Sidewalk Ends','Shel Silverstein',135,18,1000,'6.8 x 0.9 x 8.8 inches','Come in ... for where the sidewalk ends, Shel Silverstein\'s world begins. You\'ll meet a boy who turns into a TV set, and a girl who eats a whale. The Unicorn and the Bloath live there, and so does Sarah Cynthia Sylvia Stout who will not take the garbage out. It is a place where you wash your shadow and plant diamond gardens, a place where shoes fly, sisters are auctioned off, and crocodiles go to the dentist.\r\n\r\nShel Silverstein\'s masterful collection of poems and drawings is at once outrageously funny and profound.','aa104f8b1436148e6a34997761556bff.jpg'),('978-0060598242','The Chronicles of Narnia','C.S. Lewis',205,34,1000,'6 x 2.2 x 9 inches','Fantastic creatures, heroic deeds, epic battles in the war between good and evil, and unforgettable adventures come together in this world where magic meets reality, which has been enchanting readers of all ages for over sixty years. The Chronicles of Narnia has transcended the fantasy genre to become a part of the canon of classic literature.','105907c7e0b1e7f7ce56ed6b549b5339.jpg'),('978-0140424386','The Canterbury Tales','Geoffrey Chaucer',92,12,1000,'5.1 x 1 x 7.8 inches','The Canterbury Tales (Middle English: Tales of Caunterbury) is a collection of 24 stories that runs to over 17,000 lines written in Middle English by Geoffrey Chaucer between 1387 and 1400. In 1386, Chaucer became Controller of Customs and Justice of Peace and, in 1389, Clerk of the King\'s work. It was during these years that Chaucer began working on his most famous text, The Canterbury Tales. The tales (mostly written in verse, although some are in prose) are presented as part of a story-telling contest by a group of pilgrims as they travel together on a journey from London to Canterbury to visit the shrine of Saint Thomas Becket at Canterbury Cathedral. The prize for this contest is a free meal at the Tabard Inn at Southwark on their return.','4bdd483e21f7a1adcc4ac9b70fd795a3.jpg'),('978-0140449303','The Decameron','Giovanni Boccaccio',120,26,1000,'5.1 x 1.8 x 7.8 inches','The Decameron (Italian: Decameron or Decamerone), subtitled Prince Galehaut (Old Italian: Prencipe Galeotto), is a collection of novellas by the 14th-century Italian author Giovanni Boccaccio (1313–1375). The book is structured as a frame story containing 100 tales told by a group of seven young women and three young men sheltering in a secluded villa just outside Florence to escape the Black Death, which was afflicting the city. Boccaccio probably conceived of The Decameron after the epidemic of 1348, and completed it by 1353. The various tales of love in The Decameron range from the erotic to the tragic. Tales of wit, practical jokes, and life lessons contribute to the mosaic. In addition to its literary value and widespread influence (for example on Chaucer\'s The Canterbury Tales), it provides a document of life at the time. Written in the vernacular of the Florentine language, it is considered a masterpiece of classical early Italian prose.[1]','a4eaeca520be1f45d2efd0a7a7e0ac79.jpg'),('978-0142411599','Epic','Conor Kostick',50,9,986,'4.2 x 1 x 7.5 inches','Welcome to a society governed through computer games!\r\nOn New Earth, society is governed and conflicts are resolved in the arena of a fantasy computer game, Epic. If you win, you have the chance to fulfill your dreams; if you lose, your life both in and out of the game is worth nothing. When teenage Erik dares to subvert the rules of Epic, he and his friends must face the Committee. If Erik and his friends win, they may have the key to destroying the Committee’s tyranny. But if they lose . . .','020be165a3e587d7c83cb489c3ec9923.jpg'),('978-0143106296','The Aeneid','Virgil',141,12,1000,'5.1 x 0.8 x 7.7 inches','Fleeing the ashes of Troy, Aeneas, Achilles’ mighty foe in the Iliad, begins an incredible journey to fulfill his destiny as the founder of Rome. His voyage will take him through stormy seas, entangle him in a tragic love affair, and lure him into the world of the dead itself--all the way tormented by the vengeful Juno, Queen of the Gods. Ultimately, he reaches the promised land of Italy where, after bloody battles and with high hopes, he founds what will become the Roman empire. An unsparing portrait of a man caught between love, duty, and fate, the Aeneid redefines passion, nobility, and courage for our times. Robert Fagles, whose acclaimed translations of Homer’s Iliad and Odyssey were welcomed as major publishing events, brings the Aeneid to a new generation of readers, retaining all of the gravitas and humanity of the original Latin as well as its powerful blend of poetry and myth. Featuring an illuminating introduction to Virgil’s world by esteemed scholar Bernard Knox, this volume lends a vibrant new voice to one of the seminal literary achievements of the ancient world.','f77613afca1d12f998e6f28b06912566.jpg'),('978-0290204890','Batman: Year One','Frank Miller',94,10,997,'6.7 x 0.3 x 10.2 inches','In 1986, Frank Miller and David Mazzucchelli produced this groundbreaking reinterpretation of the origin of Batman — who he is and how he came to be.\r\n\r\nWritten shortly after THE DARK KNIGHT RETURNS, Miller\'s dystopian fable of Batman\'s final days, Year One set the stage for a new vision of a legendary character.','21abab3ca46902fa8e907f5c97e24263.jpg'),('978-0385386555','Under the Blood-Red Sun','Graham Salisbury',95,8,999,'5.5 x 0.6 x 8.3 inches','Tomi was born in Hawaii His grandfather and parents were born in Japan and came to America to escape poverty World War II seems far away from Tomi and his friends who are too busy playing ball on their eighth-grade team the Rats But then Pearl Harbor is attacked by the Japanese and the United States declares war on Japan Japanese men are rounded up and Tomis father and grandfather are arrested Its a terrifying time to be Japanese in America But one thing doesnt change the loyalty of Tomis buddies the Rats.','e73ffe9992ccebd8570787082b18c3df.jpg'),('978-0393089059','The Odyssey','Homer',271,33,1000,'6.5 x 1.5 x 9.6 inches','Wilson’s Odyssey captures the beauty and enchantment of this ancient poem as well as the suspense and drama of its narrative. Its characters are unforgettable, from the cunning goddess Athena, whose interventions guide and protect the hero, to the awkward teenage son, Telemachus, who struggles to achieve adulthood and find his father; from the cautious, clever, and miserable Penelope, who somehow keeps clamoring suitors at bay during her husband’s long absence, to the “complicated” hero himself, a man of many disguises, many tricks, and many moods, who emerges in this translation as a more fully rounded human being than ever before.','62a9ca3aa7c115a90abe0b892ee5c026.jpg'),('978-0439120425','Esperanza Rising','Pam Munoz Ryan',51,6,996,'5.2 x 0.8 x 7.5 inches','Esperanza thought she\'d always live with her family on their ranch in Mexico--she\'d always have fancy dresses, a beautiful home, and servants. But a sudden tragedy forces Esperanza and Mama to flee to California during the Great Depression, and to settle in a camp for Mexican farm workers. Esperanza isn\'t ready for the hard labor, financial struggles, or lack of acceptance she now faces. When their new life is threatened, Esperanza must find a way to rise above her difficult circumstances--Mama\'s life, and her own, depend on it.','752c6054d8b6911b0df7a41dfe783f0e.jpg'),('978-0440414124','The Watsons Go to Birmingham - 1963','Christopher Paul Curtis',60,7,994,'5.2 x 0.5 x 7.7 inches','Enter the hilarious world of ten-year-old Kenny and his family, the Weird Watsons of Flint, Michigan. There\'s Momma, Dad, little sister Joetta, and brother Byron, who\'s thirteen and an \"official juvenile delinquent.\"\r\n\r\nWhen Byron gets to be too much trouble, they head South to Birmingham to visit Grandma, the one person who can shape him up. And they happen to be in Birmingham when Grandma\'s church is blown up.','6200cb9673d0f304a0da442f5fef2f49.jpg'),('978-0590481090','Malcolm X: By Any Means Necessary','Walter Dean Myers',60,5,993,'5.2 x 0.5 x 7.8 inches','In this highly praised, award-winning biography, Walter Dean Myers portrays Malcolm X as prophet, dealer, convict, troublemaker, revolutionary, and voice of black militancy. A Coretta Scott King Honor Book and an ALA Notable Children\'s Book. ','e5102f33ad5be4f1309cff46fb7a1436.jpg'),('978-0679882831','There\'s a Wocket in My Pocket!','Dr. Seuss',38,6,983,'4.3 x 0.5 x 5.8 inches','There\'s a Wocket in My Pocket is filled with bizarre creatures and rhymes: the nupboard in the cupboard, ghairs beneath the stairs, and the bofa on the sofa!  ','90f0012ba099c31425b7335359964af0.jpg'),('978-0785157267','X-Men: God Loves, Man Kills','Chris Claremont',117,14,1000,'6.6 x 0.2 x 10.2 inches','The Uncanny X-Men. Magneto, master of magnetism. The bitterest of enemies for years. But now they must join forces against a new adversary who threatens them all and the entire world besides in the name of God.','04531201006a58db8e467e8400c3c08e.jpg'),('978-0807000670','Where Do We Go from Here: Chaos or Community?','Dr. Martin Luther King Jr.',102,9,998,'5.5 x 0.7 x 8.5 inches','In 1967, Dr. Martin Luther King, Jr., isolated himself from the demands of the civil rights movement, rented a house in Jamaica with no telephone, and labored over his final manuscript. In this prophetic work, which has been unavailable for more than ten years, he lays out his thoughts, plans, and dreams for America\'s future, including the need for better jobs, higher wages, decent housing, and quality education. With a universal message of hope that continues to resonate, King demanded an end to global suffering, asserting that humankind-for the first time-has the resources and technology to eradicate poverty.','1240d8c520f67835ece151b77538b8e2.jpg'),('978-0871356604','Doctor Strange and Doctor Doom: Triumph and Torment','Roger Stern',220,9,1000,'8.5 x 0.2 x 11 inches','Every year on Midsummer\'s Eve, Victor von Doom clashes with the forces of evil in a vain attempt to free his mother\'s soul from Hell. Only when Doctor Stephen Strange -- Master of the Mystic Arts and Earth\'s Sorcerer Supreme -- is convinced to join the fight, does the outcome have any hope of changing. But first these unlikely allies must journey to Mephisto\'s infernal realm ... where they find that the cost of one soul may be more than they are willing to pay!','da17bde2ab6f0d1ec52b0dfd5084dcd9.jpg'),('978-1401216672','Batman: The Killing Joke','Alan Moore',159,18,991,'7.3 x 0.4 x 11 inches','According to the grinning engine of madness and mayhem known as The Joker, that\'s all that separates the sane from the psychotic. Freed once again from the confines of Arkham Asylum, he\'s out to prove his deranged point. And he\'s going to use Gotham City\'s top cop, Commissioner Jim Gordon, and his brilliant and beautiful daughter Barbara to do it.\r\n\r\nNow Batman must race to stop his archnemesis before his reign of terror claims two of the Dark Knight\'s closest friends. Can he finally put an end to the cycle of bloodlust and lunacy that links these two iconic foes before it leads to its fatal conclusion? And as the horrifying origin of the Clown Prince of Crime is finally revealed, will the thin line that separates Batman\'s nobility and The Joker\'s insanity snap once and for all?','38ae7007ef55a43033dc4f65d4423fd0.jpg'),('978-1401232597','Batman: The Long Halloween','Jeph Loeb',169,20,997,'6.6 x 0.6 x 10.2 inches','Taking place during Batman\'s early days of crime fighting, this new edition of the classic mystery tells the story of a mysterious killer who murders his prey only on holidays. Working with District Attorney Harvey Dent and Lieutenant James Gordon, Batman races against the calendar as he tries to discover who Holiday is before he claims his next victim each month. A mystery that has the reader continually guessing the identity of the killer, this story also ties into the events that transform Harvey Dent into Batman\'s deadly enemy, Two-Face.','8b9fb5271da082ff886e4dd486199aeb.jpg'),('978-1401245252','Watchmen','Alan Moore',179,22,999,'6.6 x 1.1 x 10.2 inches','Considered the greatest graphic novel in the history of the medium, the Hugo Award-winning story chronicles the fall from grace of a group of super-heroes plagued by all-too-human failings. Along the way, the concept of the super-hero is dissected as the heroes are stalked by an unknown assassin.','6b90c313c066695dca5808a942fe1c3d.jpg'),('978-1420953381','The Taming of the Shrew','William Shakespeare',60,6,999,'5.5 x 0.2 x 8.5 inches','Baptista Minola, a lord in Padua, insists that if his youngest daughter Bianca is to be married that her older sister Katherine be married first. Bianca, the more desirable of the two sisters, has no shortage of suitors. However, Katherine, the titular “shrew,” has a temper so notorious that it is thought that no man would ever wish to marry her. When Petruchio comes to town in search of a wife, Hortensio, one of Bianca’s suitors convinces Petruchio to marry Katherine. Only interested in her money, Petruchio marries Katherine and returns with her to his country house in Verona in order to “tame” her, a task that he soon finds out is more than he bargained for. Meanwhile, Gremio, Lucentio, and Hortensio, now free to court Bianca, all vie for her hand in marriage. ','4253a9f6441957e055dd39c71e646e48.jpg'),('978-1497438095','Romeo and Juliet','William Shakespeare',60,10,996,'6.1 x 0.3 x 9.2 inches','Two households, both alike in dignity,\r\nIn fair Verona, where we lay our scene,\r\nFrom ancient grudge break to new mutiny,\r\nWhere civil blood makes civil hands unclean.\r\nFrom forth the fatal loins of these two foes\r\nA pair of star-cross\'d lovers take their life;\r\nWhose misadventured piteous overthrows\r\nDo with their death bury their parents\' strife.','db573951d2e215d75af5b6486d88fc54.jpg'),('978-1594746376','William Shakespeare\'s Star Wars','Ian Doescher',110,11,999,'5.6 x 0.7 x 8.3 inches','Return once more to a galaxy far, far away with this sublime retelling of George Lucas’s epic Star Wars in the style of the immortal Bard of Avon. The saga of a wise (Jedi) knight and an evil (Sith) lord, of a beautiful princess held captive and a young hero coming of age, Star Wars abounds with all the valor and villainy of Shakespeare’s greatest plays. ’Tis a tale told by fretful droids, full of faithful Wookiees and fearsome Stormtroopers, signifying...pretty much everything.','e331a869bc704c4160d33e0f55b30ca4.jpg');
/*!40000 ALTER TABLE `Product` ENABLE KEYS */;

--
-- Table structure for table `ProductFavorite`
--

DROP TABLE IF EXISTS `ProductFavorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductFavorite` (
  `ProductFavoriteID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL,
  `ISBN-13` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ProductFavoriteID`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductFavorite`
--

/*!40000 ALTER TABLE `ProductFavorite` DISABLE KEYS */;
INSERT INTO `ProductFavorite` VALUES ();
/*!40000 ALTER TABLE `ProductFavorite` ENABLE KEYS */;

--
-- Table structure for table `ProductRating`
--

DROP TABLE IF EXISTS `ProductRating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductRating` (
  `ProductRatingID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL,
  `ISBN-13` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `Rating` int(11) NOT NULL,
  `WouldBuyAgain` int(11) NOT NULL,
  PRIMARY KEY (`ProductRatingID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductRating`
--

/*!40000 ALTER TABLE `ProductRating` DISABLE KEYS */;
INSERT INTO `ProductRating` VALUES (1,29,'978-0060256678',5,0),(2,28,'978-0060256678',1,0),(3,35,'978-1401216672',5,0),(4,35,'978-1401232597',3,0);
/*!40000 ALTER TABLE `ProductRating` ENABLE KEYS */;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DateOfRegistration` datetime NOT NULL,
  `FirstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `GiftCardBalance` int(11) NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UID` (`UID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES ();
/*!40000 ALTER TABLE `User` ENABLE KEYS */;

--
-- Table structure for table `UserDetails`
--

DROP TABLE IF EXISTS `UserDetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserDetails` (
  `UID` int(11) NOT NULL,
  `City` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `State` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `Zip` int(5) NOT NULL,
  `Phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `Address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserDetails`
--

/*!40000 ALTER TABLE `UserDetails` DISABLE KEYS */;
INSERT INTO `UserDetails` VALUES ();
  /*!40000 ALTER TABLE `UserDetails` ENABLE KEYS */;

--
-- Table structure for table `UserShoppingCart`
--

DROP TABLE IF EXISTS `UserShoppingCart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserShoppingCart` (
  `USCID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL,
  `ISBN-13` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `UnitsInCart` int(11) NOT NULL,
  PRIMARY KEY (`USCID`),
  UNIQUE KEY `USCID` (`USCID`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserShoppingCart`
--

/*!40000 ALTER TABLE `UserShoppingCart` DISABLE KEYS */;
INSERT INTO `UserShoppingCart` VALUES ();
/*!40000 ALTER TABLE `UserShoppingCart` ENABLE KEYS */;

--
-- Dumping routines for database 'u905801586_noble'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-19  6:36:57
