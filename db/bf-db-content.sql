-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: bricofamily
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `category`
--

TRUNCATE TABLE `category`;
LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Perceuse, visseuse, perceuse à percussion, tournevis et perforateur sans fil',1),(2,'Perceuse à percussion, perforateur et marteau piqueur filaire',1),(3,'Scie et meuleuse électrique',1),(4,'Accessoire et consommable',1),(5,'Ponceuse et décapeur thermique',1),(6,'Outil multifonction et outil de précision',1),(7,'Rabot électrique, défonceuse et machine à bois',1),(8,'Perceuse à colonne',1),(9,'Batterie et chargeur',1),(10,'Outillage électroportatif 18V sur batterie universelle',1),(11,'Clé et douille',1),(12,'Tournevis',1),(13,'Scie et lame',1),(14,'Lime, râpe, rabot et ciseau à bois',1),(15,'Marteau, maillet, massette et masse',1),(16,'Pince et tenaille',1),(17,'Mètre, niveau et outils de mesure et traçage',1),(18,'Couteau, cutter et ciseau',1),(19,'Coffret et boîte à outils complète',1),(20,'Pistolet à colle et agrafeuse',1),(21,'Abrasif à main et brosse',1),(22,'Serre-joints et pince de serrage',1),(23,'Taraud et filière',1),(24,'Étau',1),(25,'Platoir, taloche et truelle',1),(26,'Couteau à colle',1),(27,'Outil de levage',1),(28,'Burin',1),(29,'Outil de décoffrage',1),(30,'Câble, chargeur et accessoires de voiture',1),(31,'Emporte-pièce, pointeau, chasse-goupille, chasse-pointe, tamponnoir',1),(32,'Scie cloche et trépan',1),(33,'Brosse pour perceuse',1),(34,'Accessoire pour perceuse',1),(35,'Mèche, forêt et burin',1),(36,'Embout de vissage',1),(37,'Accessoire pour ponceuse',1),(38,'Abrasif pour ponceuse',1),(39,'Disque et accessoire pour meuleuse',1),(40,'Lame et accessoire de scie',1),(41,'Outillage électroportatif',1),(42,'Aspirateur et nettoyeur',1),(43,'Outillage à main',1),(44,'Etabli, diable et rangement des outils',1),(45,'Escabeau, marche pied, échelle et échafaudage',1),(46,'Matériel de chantier',1),(47,'Compresseur et accessoire',1),(48,'Groupe électrogène',1),(49,'Soudure',1),(50,'Vêtement, chaussures et protection',1),(51,'Pistolet à peinture, décolleuse et décapeur',1),(52,'Projecteur et lampe de chantier',1),(53,'Etabli fixe et aménageable',1),(54,'Etabli pliant',1),(55,'Servante et coffre de chantier',1),(56,'Boite à outils (vide)',1),(57,'Cantine',1),(58,'Diable et chariot',1),(59,'Sac et porte-outils (vide)',1),(60,'Casier à vis et boite de rangement',1),(61,'Pinceau',1),(62,'Rouleau à peinture',1),(63,'Bac et grille de peintre',1),(64,'Couteau et grattoir',1),(65,'Outillage pour peinture décorative',1),(66,'Brosse métallique',1),(67,'Pistolet à peinture électrique et machine à peindre',1),(68,'Jerrican d\'essence, graisse et lubrifiant',1),(69,'Machine stationnaire d\'atelier',1),(70,'Panneau bois, aggloméré, mélaminé, MDF, et OSB',2),(71,'Lambris et accessoires pour lambris',2),(72,'Tasseau et planche',2),(73,'Plancher bois',2),(74,'Tablette bois',2),(75,'Poutre',2),(76,'Moulure',2),(77,'Plinthe bois',2),(78,'Isolation des combles et des toitures',2),(79,'Isolation des sols et plafonds',2),(80,'Isolation phonique et acoustique',2),(81,'Isolation des portes et fenêtres',2),(82,'Accessoire isolation',2),(83,'Isolation de la porte de garage',2),(84,'Plaque de plâtre et de doublage',2),(85,'Ossature métallique pour plaque',2),(86,'Béton cellulaire et carreau de plâtre',2),(87,'Colle, enduit et bande à joint',2),(88,'Cloison alvéolaire',2),(89,'Trappe de visite',2),(90,'Panneau à carreler',2),(91,'Vis',2),(92,'Boulon écrou et rondelle',2),(93,'Cheville',2),(94,'Clou',2),(95,'Crochet, piton, gond à visser',2),(96,'Pied, patin et embout',2),(97,'Roulette et roue',2),(98,'Compas, coulisse et coulisseau',2),(99,'Serrure de meuble',2),(100,'Loquetaux',2),(101,'Lève meuble',2),(102,'Colle et adhésif',2),(103,'Equerre',2),(104,'Crochet',2),(105,'Tourillon et lamello',2),(106,'Ferrure',2),(107,'Patte de fixation',2),(108,'Peinture intérieure couleur',2),(109,'Peinture blanche mur et plafond',2),(110,'Peinture cuisine et salle de bains',2),(111,'Peinture et enduit à effet décoratif',2),(112,'Relooking meuble et objet',2),(113,'Peinture pour carrelage',2),(114,'Sous-couche',2),(115,'Peinture de rénovation multi-supports',2),(116,'Peinture professionnelle',2),(117,'Bombe de peinture',2),(118,'Peinture extérieure bois',2),(119,'Lasure et traitement extérieur',2),(120,'Vernis extérieur',2),(121,'Peinture extérieure façade et crépi',2),(122,'Peinture extérieure fer',2),(123,'Peinture extérieure multi-supports',2),(124,'Peinture sol extérieur et garage',2),(125,'Anti-rouille et traitement du fer',2),(126,'Isolation des murs par l\'intérieur',2),(127,'Isolation des murs par l\'extérieur',2),(128,'Isolation des tuyaux et circuits d\'eau chaude',2),(129,'Charnière d\'ameublement',2),(130,'Paumelle d\'ameublement',2),(131,'Fiche d\'ameublement',2),(132,'Fixation et quincaillerie d\'assemblage',2);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `city`
--

TRUNCATE TABLE `city`;
LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (1,'Bourg-en-Bresse',1),(2,'Oyonnax',1),(3,'Bellegarde-sur-Valse',1),(4,'Ambérieu-en-Bugey',1),(5,'Gex',1),(6,'Belley',1),(7,'Miribel',1),(8,'Saint-Genis-Pouilly',1),(9,'Ferney-Voltaire',1),(10,'Divonne-les-Bains',1),(11,'Meximieux',1),(12,'Trévoux',1),(13,'Lagnieu',1),(14,'Montluel',1),(15,'Péronnas',1),(16,'Montluçon',2),(17,'Vichy',2),(18,'Moulins',2),(19,'Yzeure',2),(20,'Cusset',2),(21,'Domérat',2),(22,'Bellerive-sur-Allier',2),(23,'Commentry',2),(24,'Gannat',2),(25,'Saint-Pourçain-sur-S',2),(26,'Désertines',2),(27,'Avermes',2),(28,'Saint-Germain-de-Sal',2),(29,'Varennes-sur-Allier',2),(30,'Creuzier le vieux',2),(31,'Annonay',3),(32,'Aubenas',3),(33,'Guilherand-Granges',3),(34,'Tournon-sur-Rhône',3),(35,'Privas',3),(36,'Le Teil',3),(37,'Bourg-Saint-Andéol',3),(38,'Saint-Péray',3),(39,'La Voulte-sur-Rhône',3),(40,'Viviers',3),(41,'Vals-les Bains',3),(42,'Le Cheylard',3),(43,'Le Pouzin',3),(44,'Villeneuve-de-Berg',3),(45,'Les vans',3),(46,'Aurillac',4),(47,'Saint-Flour',4),(48,'Arpajon-sur-Cère',4),(49,'Ytrac',4),(50,'Mauriac',4),(51,'Riom-ès-Montagnes',4),(52,'Mauris',4),(53,'Jussac',4),(54,'Naucelles',4),(55,'Murat',4),(56,'Vic-Sur-Cère',4),(57,'Neussargues en Pinat',4),(58,'Ydes',4),(59,'Neuvéglise-sur-Truyè',4),(60,'Massiac',4),(61,'Valence',5),(62,'Montélimar',5),(63,'Romans-sur-Isère',5),(64,'Bourg-lès-Valence',5),(65,'Pierrelatte',5),(66,'Bourg-de-Péage',5),(67,'Portes-lès-Valence',5),(68,'Livron-sur-Drôme',5),(69,'Saint-Paul-Trois-Châ',5),(70,'Crest',5),(71,'Nyons',5),(72,'Chabeuil',5),(73,'Tain-l\'Hermitage',5),(74,'Loriol-sur-Drôme',5),(75,'Saint-Rambert-d\'Albo',5),(76,'Le-Puy-en-Velay',6),(77,'Monistrol-sur-Loire',6),(78,'Yssingeaux',6),(79,'Brioude',6),(80,'Aurec-sur-Loire',6),(81,'Sainte-Sigolène',6),(82,'Bas-en-Basset',6),(83,'Saint-Just-Malmont',6),(84,'Brives-Charensac',6),(85,'Langeac',6),(86,'Saint-Germain-Laprad',6),(87,'Espaly-Saint-Marcel',6),(88,'Saint-Didier-en-Vela',6),(89,'Vals-près-le-Puy',6),(90,'Coubon',6),(91,'Annecy',7),(92,'Thonon-les-Bains',7),(93,'Annemasse',7),(94,'Annecy-le-Vieux',7),(95,'Seynod',7),(96,'Cluses',7),(97,'Cran-Gevrier',7),(98,'Sallanches',7),(99,'Rumilly',7),(100,'Bonneville',7),(101,'Saint-Julien-en-Gene',7),(102,'Gaillard',7),(103,'La Roche-sur-Foron',7),(104,'Passy',7),(105,'Chamonix-Mont-Blanc',7),(106,'Grenoble',8),(107,'Saint-Martin-d\'Hères',8),(108,'Échirolles',8),(109,'Vienne',8),(110,'Bourgoin-Jallieu',8),(111,'Fontaine',8),(112,'Voiron',8),(113,'Villefontaine',8),(114,'Meylan',8),(115,'L\'Isle-d\'Abeau',8),(116,'Saint-Égrève',8),(117,'Seyssinet-Pariset',8),(118,'Le Pont-de-Claix',8),(119,'Sassenage',8),(120,'Voreppe',8),(121,'Saint-Etienne',9),(122,'Saint-Chamond',9),(123,'Roanne',9),(124,'Firminy',9),(125,'Monybrison',9),(126,'Rive-de-Gier',9),(127,'Saint-Just-Saint-Ram',9),(128,'Le Chambon-Feugeroll',9),(129,'Riorges',9),(130,'Andrézieux-Bouthéon',9),(131,'Roche-La-Molière',9),(132,'Unieux',9),(133,'Veauche',9),(134,'Sorbiers',9),(135,'Feurs',9),(136,'Clermont-Ferrand',10),(137,'Cournon-d\'Auvergne',10),(138,'Riom',10),(139,'Chamalières',10),(140,'Issoire',10),(141,'Thiers',10),(142,'Beaumont',10),(143,'Pont-du-Château',10),(144,'Gerzat',10),(145,'Aubière',10),(146,'Lempdes',10),(147,'Cébazat',10),(148,'Romagnat',10),(149,'Ambert',10),(150,'Ceyrat',10),(151,'Lyon',11),(152,'Villeurbanne',11),(153,'Vénissieux',11),(154,'Vaulx-en-Velin',11),(155,'Saint-Priest',11),(156,'Caluire-et-Cuire',11),(157,'Bron',11),(158,'Villefranche-sur-Saô',11),(159,'Meyzieu',11),(160,'Rillieux-la-Pape',11),(161,'Décines-Charpieu',11),(162,'Oullins',11),(163,'Sainte-Foy-lès-Lyon',11),(164,'Tassin-la-Demi-Lune',11),(165,'Saint-Genis-Laval',11),(166,'Chambéry',12),(167,'Aix-les-Bains',12),(168,'Albertville',12),(169,'La Motte-Servolex',12),(170,'La Ravoire',12),(171,'Saint-Jean-de-Maurie',12),(172,'Bourg-Saint-Maurice',12),(173,'Ugine',12),(174,'Cognin',12),(175,'Entrelacs',12),(176,'Saint-Alban-Leysse',12),(177,'Challes-les-Eaux',12),(178,'Barberaz',12),(179,'Le Bourget-du-Lac',12),(180,'Grésy-sur-Aix',12);
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `department`
--

TRUNCATE TABLE `department`;
LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,1,'Ain'),(2,3,'Allier'),(3,7,'Ardèche'),(4,15,'Cantal'),(5,26,'Drôme'),(6,43,'Haute-Loire'),(7,74,'Haute-Savoie'),(8,38,'Isère'),(9,42,'Loire'),(10,63,'Puy-de-Dôme'),(11,69,'Rhône'),(12,73,'Savoie');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `image`
--

TRUNCATE TABLE `image`;
LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `offer`
--

TRUNCATE TABLE `offer`;
LOCK TABLES `offer` WRITE;
/*!40000 ALTER TABLE `offer` DISABLE KEYS */;
/*!40000 ALTER TABLE `offer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `product`
--

TRUNCATE TABLE `product`;
LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Tool'),(2,'Material');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `transaction`
--

TRUNCATE TABLE `transaction`;
LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (1,'Rent'),(2,'Sale');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

TRUNCATE TABLE `user`;
LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-28 16:20:37
