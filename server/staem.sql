-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 06, 2025 at 07:04 PM
-- Server version: 11.5.2-MariaDB
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `gameplay_desc` text DEFAULT NULL,
  `price` float NOT NULL,
  `publisher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `description`, `gameplay_desc`, `price`, `publisher_id`) VALUES
(1, 'The Legend of Zelda: Breath of the Wild', 'Forget everything you know about The Legend of Zelda games. Step into a world of discovery, exploration, and adventure in The Legend of Zelda: Breath of the Wild, a boundary-breaking new game in the acclaimed series. Travel across vast fields, through forests, and to mountain peaks as you discover what has become of the kingdom of Hyrule in this stunning Open-Air Adventure.', 'Breath of the Wild is an open world action-adventure game. Players are tasked with exploring the kingdom of Hyrule while controlling Link. Breath of the Wild encourages nonlinear gameplay, which is illustrated by the lack of defined entrances or exits to areas, scant instruction given to the player, and encouragement to explore freely. Breath of the Wild introduces a consistent physics engine to the Zelda series, letting players approach problems in different ways rather than trying to find a single solution. The \"chemistry engine\" defines the physical properties of most objects and governs how they interact with the player and one another. For example, during thunderstorms, metal objects will attract powerful lightning strikes; during a storm, therefore, a player must be careful not to carry metal, but may also throw metal objects at enemies to draw lightning to them. These design approaches result in a generally unstructured and interactive world that rewards experimentation and allows for nonlinear completion of the story.', 59.99, 4),
(2, 'Super Mario Odyssey', 'Explore incredible places far from the Mushroom Kingdom as you join Mario and his new ally Cappy on a massive, globe-trotting 3D adventure. Use amazing new abilities—like the power to capture and control objects, animals, and enemies—to collect Power Moons so you can power up the Odyssey airship and save Princess Peach from Bowser’s wedding plans!', 'Super Mario Odyssey is a platform game in which players control Mario as he travels across 14 different worlds, known as \"Kingdoms\" within the game, on the hat-shaped ship Odyssey, to rescue Princess Peach from Bowser, who plans to forcibly marry her. The Kingdoms in the game return to the exploration-based level design featured in Super Mario 64. Each Kingdom has Mario searching for and clearing various objectives in order to obtain items known as Power Moons, which are the power source of the Odyssey and grant access to new Kingdoms. Checkpoint flags littered throughout each Kingdom allow Mario to instantly warp to them once activated. Certain levels feature areas called \"flat\" zones, where Mario is placed in a 2D side-scrolling environment similar to his appearance in the original Super Mario Bros.', 39.99, 4),
(3, 'The Legend of Zelda: Tears of the Kingdom', 'In this sequel to the Legend of Zelda: Breath of the Wild game, you’ll decide your own path through the sprawling landscapes of Hyrule and the mysterious islands floating in the vast skies above. Can you harness the power of Link’s new abilities to fight back against the malevolent forces that threaten the kingdom?', 'Tears of the Kingdom retains the open-world action-adventure gameplay of Breath of the Wild (2017). As Link, the player explores the main setting of Hyrule and two new areas: the sky, which has several floating islands, and the Depths, a vast underground area beneath Hyrule. Link can climb, ride horses, or use a paraglider to soar through the air. Characters and locations from Breath of the Wild were kept and modified to fit the game\'s story.', 69.99, 4),
(4, 'Animal Crossing: New Horizons', 'Escape to a deserted island and create your own paradise as you explore, create, and customize in the Animal Crossing: New Horizons game. Your island getaway has a wealth of natural resources that can be used to craft everything from tools to creature comforts. You can hunt down insects at the crack of dawn, decorate your paradise throughout the day, or enjoy sunset on the beach while fishing in the ocean. The time of day and season match real life, so each day on your island is a chance to check in and find new surprises all year round.', 'In the Animal Crossing games, the player assumes the role of a human character who moves into a rural village populated with anthropomorphic animals and lives there indefinitely. Gameplay is open-ended: players have no defined objectives but are instead encouraged to spend their time in the village performing any number of activities which include collecting items, crafting items, planting plants, insect catching, fishing, and socializing with the village\'s residents. Animal Crossing games are played in real-time, utilizing the video game console\'s internal clock and calendar. Thus, the passage of time in the game world reflects that in reality, as well as the current season and time of day. Some in-game events, such as holidays or the growth of a tree, occur at certain times or require some duration of time to have passed.', 54.99, 4);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`, `game_id`) VALUES
(5, 'Platformer', 2),
(6, 'Adventure', 2);

-- --------------------------------------------------------

--
-- Table structure for table `library_items`
--

CREATE TABLE `library_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `body` text DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `date` date NOT NULL,
  `author_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `body`, `rating`, `date`, `author_id`, `game_id`) VALUES
(2, 'test', NULL, '2025-01-06', 1, 4),
(40, 'test', 3.1, '2025-01-06', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `is_purchase` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `value` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `is_publisher` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_publisher`) VALUES
(1, 'MIbrahim9276', 'm.ibrahim927@gmail.com', 'Aq1aq1aq1', 0),
(2, 'FromSoftware', 'mail@fromsoftware.com', 'from_software', 1),
(3, 'Atlas', 'mail@atlas.com', 'atlas', 1),
(4, 'Nintendo', 'mail@nintendo.com', 'nintendo', 1),
(5, 'Square Enix', 'mail@squareenix.com', 'square_enix', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_game_fk` (`game_id`);

--
-- Indexes for table `library_items`
--
ALTER TABLE `library_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `library_game_fk` (`game_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `library_items`
--
ALTER TABLE `library_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `genres`
--
ALTER TABLE `genres`
  ADD CONSTRAINT `genre_game_fk` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `library_items`
--
ALTER TABLE `library_items`
  ADD CONSTRAINT `library_game_fk` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
