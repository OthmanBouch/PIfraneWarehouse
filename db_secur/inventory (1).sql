-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 13 avr. 2024 à 19:48
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `inventory`
--

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `ID` int(11) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Product` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `history`
--

INSERT INTO `history` (`ID`, `Stock`, `Product`, `Quantity`, `Time`) VALUES
(6, 22, 52, 8, '2024-04-07 16:30:32'),
(7, 22, 52, 10, '2024-04-07 16:30:38'),
(8, 24, 54, 1, '2024-04-07 16:32:28'),
(9, 24, 54, 6, '2024-04-07 16:32:32'),
(10, 24, 54, 10, '2024-04-07 16:32:36'),
(11, 0, 51, 4, '2024-04-07 16:43:57'),
(12, 0, 51, 5, '2024-04-07 16:44:02'),
(13, 24, 54, 4, '2024-04-08 16:47:49'),
(14, 24, 54, 4, '2024-04-08 16:47:54'),
(15, 24, 54, 10, '2024-04-11 19:07:48'),
(16, 28, 61, 150, '2024-04-13 15:41:52'),
(17, 28, 61, 50, '2024-04-13 15:42:16'),
(18, 28, 61, 200, '2024-04-13 15:42:27'),
(19, 28, 61, 100, '2024-04-13 15:42:34'),
(20, 28, 61, 188, '2024-04-13 17:47:15');

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `ID` int(11) NOT NULL,
  `Location` varchar(250) NOT NULL,
  `Slot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`ID`, `Location`, `Slot`) VALUES
(7, 'Local A1', 1),
(8, 'Local A2', 2),
(9, 'Local A3', 3),
(10, 'Local B1', 1),
(11, 'Local B2', 2),
(12, 'Local B3', 3);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `Pname` varchar(50) NOT NULL,
  `Price` float DEFAULT NULL,
  `Ptype` varchar(50) NOT NULL DEFAULT 'Undefined Item',
  `Description` varchar(350) NOT NULL DEFAULT 'No description is given for this product. ',
  `Created_by` int(11) NOT NULL,
  `Created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`ID`, `img`, `Pname`, `Price`, `Ptype`, `Description`, `Created_by`, `Created`) VALUES
(51, 'stopsign.png', 'Stop sign ', 50, 'Road Signage', '', 28, '2024-04-06 20:45:12'),
(52, 'Capture d’écran (2).png', 'screenshot', 10, 'Public Event Supplies', '', 28, '2024-04-06 20:45:22'),
(54, 'stopsign.png', 'stop sign2', 15, '', '', 28, '2024-04-06 23:48:08'),
(61, 'Bouchi_Pic.jpeg', 'Slave', 23.2, 'Machinery', 'Gnetically gifted slave ', 28, '2024-04-12 21:21:03');

-- --------------------------------------------------------

--
-- Structure de la table `productswsuppliers`
--

CREATE TABLE `productswsuppliers` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `Created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `productswsuppliers`
--

INSERT INTO `productswsuppliers` (`id`, `supplier`, `product`, `Created`) VALUES
(70, 11, 61, '2024-04-12 21:21:04');

-- --------------------------------------------------------

--
-- Structure de la table `product_supplier`
--

CREATE TABLE `product_supplier` (
  `ID` int(11) NOT NULL,
  `S_id` int(11) NOT NULL,
  `P_id` int(11) NOT NULL,
  `Quantity_ordered` int(11) NOT NULL,
  `Quantity_received` int(11) NOT NULL,
  `Quantity_remaining` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Created_by` int(11) NOT NULL,
  `Created` datetime NOT NULL DEFAULT current_timestamp(),
  `batch` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product_supplier`
--

INSERT INTO `product_supplier` (`ID`, `S_id`, `P_id`, `Quantity_ordered`, `Quantity_received`, `Quantity_remaining`, `Status`, `Created_by`, `Created`, `batch`) VALUES
(256, 11, 54, 5, 4, 1, 'Pending', 28, '2024-04-06 23:48:26', NULL),
(259, 1, 51, 5, 5, 0, 'Arrived', 28, '2024-04-07 15:42:39', NULL),
(261, 2, 52, 10, 10, 0, 'Arrived', 28, '2024-04-07 16:28:22', NULL),
(262, 11, 54, 10, 10, 0, 'Arrived', 28, '2024-04-07 16:32:23', NULL),
(263, 11, 61, 200, 188, 12, 'Pending', 28, '2024-04-12 21:33:29', NULL),
(264, 11, 61, 100, 100, 0, 'Arrived', 28, '2024-04-13 15:42:11', NULL);

--
-- Déclencheurs `product_supplier`
--
DELIMITER $$
CREATE TRIGGER `update_quantity_remaining_trigger` BEFORE UPDATE ON `product_supplier` FOR EACH ROW BEGIN
    DECLARE new_quantity_received INT;
    DECLARE new_quantity_ordered INT;

    
    SET new_quantity_received = NEW.Quantity_received;
    SET new_quantity_ordered = NEW.Quantity_ordered;

    
    SET NEW.Quantity_remaining = new_quantity_ordered - new_quantity_received;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `ID` int(20) NOT NULL,
  `P_id` int(20) NOT NULL,
  `Location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`ID`, `P_id`, `Location`) VALUES
(22, 52, 8),
(24, 54, 9),
(28, 61, 11),
(30, 52, 8);

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

CREATE TABLE `supplier` (
  `ID` int(11) NOT NULL,
  `Sname` varchar(50) NOT NULL,
  `Slocation` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Created_by` int(11) NOT NULL,
  `Created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `supplier`
--

INSERT INTO `supplier` (`ID`, `Sname`, `Slocation`, `Email`, `Created_by`, `Created`) VALUES
(1, 'MAC', 'Casablanca', 'MAC@supplier.ma', 5, '2024-02-16 23:02:42'),
(2, 'ZAM', 'Mohammedia', 'ZAM@suplier.ma', 5, '2024-02-16 23:02:42'),
(11, 'DAM', 'Sidi Kacem', 'DAM@supplier.ma', 28, '2024-04-04 00:45:27');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Lname` varchar(50) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Adress` varchar(500) NOT NULL,
  `Zip` int(11) NOT NULL,
  `Phone` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'User',
  `Created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `img`, `Fname`, `Lname`, `Description`, `Adress`, `Zip`, `Phone`, `password`, `Email`, `user_type`, `Created`) VALUES
(5, 'logo_EL.png', 'Chinwi', 'Skrt7', '', 'Al Akhawayn University', 53000, 659884411, 'e10adc3949ba59abbe56e057f20f883e', 'akram@gmail.com', 'Admin', '2024-02-04 10:34:01'),
(7, '', 'Omar', 'Bouchentouf', '', '', 0, 0, 'e10adc3949ba59abbe56e057f20f883e', 'O.Bouchentouf@gmail.com', 'User', '2024-02-04 15:30:12'),
(11, '', 'Hamza', 'Fahim', '', '', 0, 0, 'e10adc3949ba59abbe56e057f20f883e', 'H.Fahim@gmail.com', 'User', '2024-02-04 20:33:10'),
(27, '', 'Morad', 'Essadiki', '', '', 0, 0, 'e10adc3949ba59abbe56e057f20f883e', 'MoradEssadiki@gmail.com', 'User', '2024-02-12 21:54:00'),
(28, 'Bouchi_Pic.jpeg', 'bouchentouf', 'Othman', '22 years old i got that dawg in me skibidi rizzler aint fanum taxir the rissler of ozz no more. you better be balling ', '129, Quartier le Soleil, Mohammedia', 28882, 682226106, 'e10adc3949ba59abbe56e057f20f883e', 'Ot.Bouchentouf@aui.ma', 'Admin', '2024-02-19 11:09:23');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `productswsuppliers`
--
ALTER TABLE `productswsuppliers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `history`
--
ALTER TABLE `history`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `productswsuppliers`
--
ALTER TABLE `productswsuppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `product_supplier`
--
ALTER TABLE `product_supplier`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
