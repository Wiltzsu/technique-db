-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 07, 2024 at 09:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `technique-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(255) NOT NULL,
  `categoryDescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryID`, `categoryName`, `categoryDescription`) VALUES
(3, 'Guard', NULL),
(4, 'Takedown', NULL),
(5, 'Submission', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Class`
--

CREATE TABLE `Class` (
  `classID` int(11) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `dateTime` datetime DEFAULT NULL,
  `classDescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Difficulty`
--

CREATE TABLE `Difficulty` (
  `difficultyID` int(11) NOT NULL,
  `difficulty` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Difficulty`
--

INSERT INTO `Difficulty` (`difficultyID`, `difficulty`) VALUES
(1, 'Easy'),
(2, 'Intermediate');

-- --------------------------------------------------------

--
-- Table structure for table `Note`
--

CREATE TABLE `Note` (
  `noteID` int(11) NOT NULL,
  `techniqueID` int(11) NOT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `dateCreated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Position`
--

CREATE TABLE `Position` (
  `positionID` int(11) NOT NULL,
  `positionName` varchar(255) NOT NULL,
  `positionDescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Position`
--

INSERT INTO `Position` (`positionID`, `positionName`, `positionDescription`) VALUES
(1, 'Half Guard', NULL),
(2, 'Closed Guard', NULL),
(3, 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE `Role` (
  `roleID` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `roleDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Technique`
--

CREATE TABLE `Technique` (
  `techniqueID` int(11) NOT NULL,
  `techniqueName` varchar(255) NOT NULL,
  `techniqueDescription` text DEFAULT NULL,
  `categoryID` int(11) NOT NULL,
  `difficultyID` int(11) NOT NULL,
  `positionID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Technique`
--

INSERT INTO `Technique` (`techniqueID`, `techniqueName`, `techniqueDescription`, `categoryID`, `difficultyID`, `positionID`) VALUES
(3, 's', 's', 3, 1, 2),
(4, 'a', 'a', 3, 2, 1),
(6, 'd', 'd', 3, 1, 2),
(7, 'ss', 's', 3, 2, 2),
(8, 'adasd', 'adsads', 3, 1, 2),
(9, 'dasdas', 'asdasd', 3, 2, 2),
(10, 'dddd', 'ddd', 3, 1, 2),
(11, 'adadada', 'dadadad', 3, 1, 2),
(12, 'kulli', 'adad', 3, 1, 2),
(13, 'julli', 'adad', 5, 1, 2),
(14, 'deeedde', 'dede', 5, 1, 2),
(15, 'kyrpä', 'dddd', 3, 1, 2),
(18, 'test', 'test', 3, 2, 2),
(19, 'im testing', 'im testing', 5, 2, 2),
(20, 'jorma', 'jarmo', 3, 1, 2),
(21, 'teppo', 'teppo', 3, 2, 2),
(22, 'testi', 'testi', 3, 2, 2),
(23, 'JORMAAA', 'JORMAAAA', 3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Techniques_Classes`
--

CREATE TABLE `Techniques_Classes` (
  `techniqueID` int(11) NOT NULL,
  `classID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roleID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `username`, `email`, `password`, `roleID`) VALUES
(1, 'julli', 'julli@kulli.com', '$2y$10$dWhALrScL6X6QiCMRUgVmOvDIKCrOgQY4ZAKERzBPbtuOmnfNMdxC', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `UserTechniqueNote`
--

CREATE TABLE `UserTechniqueNote` (
  `noteEntryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `techniqueID` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `practiceNotes` text DEFAULT NULL,
  `entryDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Video`
--

CREATE TABLE `Video` (
  `videoID` int(11) NOT NULL,
  `techniqueID` int(11) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `videoDescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`categoryID`),
  ADD UNIQUE KEY `categoryName` (`categoryName`);

--
-- Indexes for table `Class`
--
ALTER TABLE `Class`
  ADD PRIMARY KEY (`classID`);

--
-- Indexes for table `Difficulty`
--
ALTER TABLE `Difficulty`
  ADD PRIMARY KEY (`difficultyID`);

--
-- Indexes for table `Note`
--
ALTER TABLE `Note`
  ADD PRIMARY KEY (`noteID`);

--
-- Indexes for table `Position`
--
ALTER TABLE `Position`
  ADD PRIMARY KEY (`positionID`),
  ADD UNIQUE KEY `positionName` (`positionName`);

--
-- Indexes for table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `Technique`
--
ALTER TABLE `Technique`
  ADD PRIMARY KEY (`techniqueID`),
  ADD UNIQUE KEY `techniqueName` (`techniqueName`),
  ADD KEY `positionID` (`positionID`),
  ADD KEY `difficultyID` (`difficultyID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `Techniques_Classes`
--
ALTER TABLE `Techniques_Classes`
  ADD PRIMARY KEY (`techniqueID`,`classID`),
  ADD KEY `fk_techniqueClass_class` (`classID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `roleID` (`roleID`);

--
-- Indexes for table `UserTechniqueNote`
--
ALTER TABLE `UserTechniqueNote`
  ADD PRIMARY KEY (`noteEntryID`),
  ADD KEY `fk_usertechnique_user` (`userID`),
  ADD KEY `fk_usertechnique_technique` (`techniqueID`);

--
-- Indexes for table `Video`
--
ALTER TABLE `Video`
  ADD PRIMARY KEY (`videoID`),
  ADD KEY `fk_videos_technique` (`techniqueID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Class`
--
ALTER TABLE `Class`
  MODIFY `classID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Difficulty`
--
ALTER TABLE `Difficulty`
  MODIFY `difficultyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Note`
--
ALTER TABLE `Note`
  MODIFY `noteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Position`
--
ALTER TABLE `Position`
  MODIFY `positionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Role`
--
ALTER TABLE `Role`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Technique`
--
ALTER TABLE `Technique`
  MODIFY `techniqueID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `UserTechniqueNote`
--
ALTER TABLE `UserTechniqueNote`
  MODIFY `noteEntryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Video`
--
ALTER TABLE `Video`
  MODIFY `videoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Note`
--
ALTER TABLE `Note`
  ADD CONSTRAINT `fk_note_technique` FOREIGN KEY (`noteID`) REFERENCES `Technique` (`techniqueID`);

--
-- Constraints for table `Technique`
--
ALTER TABLE `Technique`
  ADD CONSTRAINT `Technique_ibfk_1` FOREIGN KEY (`positionID`) REFERENCES `Position` (`positionID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Technique_ibfk_2` FOREIGN KEY (`difficultyID`) REFERENCES `Difficulty` (`difficultyID`),
  ADD CONSTRAINT `Technique_ibfk_3` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryID`) ON UPDATE CASCADE;

--
-- Constraints for table `Techniques_Classes`
--
ALTER TABLE `Techniques_Classes`
  ADD CONSTRAINT `fk_techniqueClass_class` FOREIGN KEY (`classID`) REFERENCES `Class` (`classID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_techniqueClass_technique` FOREIGN KEY (`techniqueID`) REFERENCES `Technique` (`techniqueID`) ON DELETE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `Role` (`roleID`);

--
-- Constraints for table `UserTechniqueNote`
--
ALTER TABLE `UserTechniqueNote`
  ADD CONSTRAINT `fk_usertechnique_technique` FOREIGN KEY (`techniqueID`) REFERENCES `Technique` (`techniqueID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usertechnique_user` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `Video`
--
ALTER TABLE `Video`
  ADD CONSTRAINT `fk_videos_technique` FOREIGN KEY (`techniqueID`) REFERENCES `Video` (`videoID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
