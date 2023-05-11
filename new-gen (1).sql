-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2021 at 10:12 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new-gen`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `login` (IN `email_in` VARCHAR(30), IN `pass_in` VARCHAR(255))  NO SQL
SELECT * FROM customer WHERE email = email_in and pass = pass_in$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `signup` (IN `name` VARCHAR(30), IN `email` VARCHAR(30), IN `hash` VARCHAR(255))  NO SQL
INSERT INTO customer VALUES ('',name,email,hash)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `theater_list` (INOUT `names_list` VARCHAR(3000))  NO SQL
BEGIN
    declare is_done integer default 0;
    declare rid varchar(40) default "";
    
    declare theater_cr cursor FOR
    select theater_name from theater;
    declare continue handler for not found set is_done = 1;
    open theater_cr;
    get_list: LOOP
    fetch theater_cr into rid;
    if is_done = 1 THEN
    leave get_list;
    end if;
    set names_list =  concat(rid, "<br><br>" , names_list);
    end loop get_list;
    close theater_cr;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Customer_Id` int(11) NOT NULL,
  `Customer_Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_Id`, `Customer_Name`, `Email`, `Pass`) VALUES
(11, 'Nandhakumar', 'nandha@gmail.com', '0a05e392e20d2f87fff600df38db9bfc'),
(15, 'nandha', 'example@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(16, 'member1', 'rough@email.com', 'e10adc3949ba59abbe56e057f20f883e'),
(17, 'aditya', 'aditya@gmail.com', '189fe48d1050763b571517a9e2aa113b'),
(18, 'suhaas', 'suhaas@gmail.com', '82004ec653567aebd72261f1e28ac481');

--
-- Triggers `customer`
--
DELIMITER $$
CREATE TRIGGER `cus_tr` AFTER INSERT ON `customer` FOR EACH ROW UPDATE screen SET Price = Price-1
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `movie_id` int(11) NOT NULL,
  `movie_name` varchar(30) DEFAULT NULL,
  `genre` varchar(20) DEFAULT NULL,
  `movie_rating` double(6,2) DEFAULT NULL,
  `No_of_rating` int(11) NOT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movie_id`, `movie_name`, `genre`, `movie_rating`, `No_of_rating`, `duration`) VALUES
(1, 'Godzilla vs kong', 'Action', 4.23, 1, 150),
(2, 'Tenet', 'Sci-fi', 4.87, 1, 150),
(3, 'Jumanji', 'Kids', 4.34, 2, 160),
(4, 'Fast and Furious', 'Action', 4.34, 2, 170),
(5, 'The Midnight Sky', 'Sci-fi', 4.10, 3, 130),
(6, 'The Lion King', 'Kids', 4.14, 1, 140),
(7, 'Monster Hunter', 'Action', 4.12, 1, 150),
(8, 'Space Sweepers', 'Sci-fi', 4.10, 1, 180),
(9, 'Wonder Park', 'Kids', 4.37, 6, 150),
(10, 'Under Water', 'Action', 4.67, 1, 170);

-- --------------------------------------------------------

--
-- Stand-in structure for view `movie_view`
-- (See below for the actual view)
--
CREATE TABLE `movie_view` (
`movie_id` int(11)
,`movie_name` varchar(30)
,`genre` varchar(20)
,`movie_rating` double(6,2)
,`No_of_rating` int(11)
,`duration` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `screen`
--

CREATE TABLE `screen` (
  `screen_id` int(11) NOT NULL,
  `theater_id` int(11) DEFAULT NULL,
  `screen_no` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `screen`
--

INSERT INTO `screen` (`screen_id`, `theater_id`, `screen_no`, `Price`) VALUES
(1, 1, 1, 147),
(2, 1, 2, 107),
(3, 1, 3, 117),
(4, 2, 1, 107),
(5, 2, 2, 127),
(6, 2, 3, 117),
(7, 3, 1, 117),
(8, 3, 2, 97),
(9, 3, 3, 107),
(10, 4, 1, 117),
(11, 4, 2, 107),
(12, 4, 3, 97),
(13, 5, 1, 107),
(14, 5, 2, 127),
(15, 5, 3, 117);

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(11) NOT NULL,
  `show_id` int(11) DEFAULT NULL,
  `seat_booked` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`seat_id`, `show_id`, `seat_booked`) VALUES
(1, 4, ''),
(2, 1, ''),
(3, 2, 'fkln'),
(5, 3, 'finp'),
(6, 5, 'dejo'),
(7, 6, ''),
(8, 7, ''),
(9, 8, ''),
(10, 9, ''),
(11, 10, ''),
(12, 11, ''),
(13, 12, ''),
(14, 13, ''),
(15, 14, ''),
(16, 15, ''),
(17, 16, ''),
(18, 17, 'agijo'),
(19, 18, 'j'),
(20, 19, ''),
(21, 20, 'demo'),
(22, 21, ''),
(23, 22, ''),
(24, 23, ''),
(25, 24, ''),
(26, 25, ''),
(27, 26, ''),
(28, 27, ''),
(29, 28, ''),
(30, 29, ''),
(31, 30, ''),
(32, 31, ''),
(33, 32, ''),
(34, 33, ''),
(35, 34, ''),
(36, 35, ''),
(37, 36, ''),
(38, 37, ''),
(39, 38, ''),
(40, 39, ''),
(41, 40, ''),
(42, 41, ''),
(43, 42, ''),
(44, 43, ''),
(45, 44, ''),
(46, 45, ''),
(47, 46, ''),
(48, 47, ''),
(49, 50, ''),
(50, 51, ''),
(51, 52, ''),
(52, 53, ''),
(53, 54, ''),
(54, 55, ''),
(55, 56, ''),
(56, 57, ''),
(57, 58, ''),
(58, 59, ''),
(59, 60, '');

--
-- Triggers `seat`
--
DELIMITER $$
CREATE TRIGGER `seat_reming` AFTER UPDATE ON `seat` FOR EACH ROW UPDATE shows , seat
	SET shows.seats_remaining = CASE 
    	WHEN shows.social_distancing = 'Yes' THEN 
        	8 - (SELECT LENGTH(seat_booked) FROM seat 
                                WHERE seat.show_id = shows.show_id )
        ELSE 
        	16 - (SELECT LENGTH(seat_booked) FROM seat 
                                WHERE seat.show_id = shows.show_id )
        END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `show_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `screen_id` int(11) DEFAULT NULL,
  `theater_id` int(11) DEFAULT NULL,
  `show_date_time` datetime DEFAULT NULL,
  `social_distancing` varchar(10) DEFAULT NULL,
  `seats_remaining` int(11) DEFAULT '16'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`show_id`, `movie_id`, `screen_id`, `theater_id`, `show_date_time`, `social_distancing`, `seats_remaining`) VALUES
(1, 2, 1, 1, '2021-06-01 09:00:00', 'Yes', 8),
(2, 3, 2, 1, '2021-06-01 09:00:00', 'No', 12),
(3, 4, 3, 1, '2021-06-01 09:00:00', 'No', 12),
(4, 5, 4, 2, '2021-06-01 09:00:00', 'No', 16),
(5, 6, 5, 2, '2021-06-01 09:00:00', 'Yes', 4),
(6, 7, 6, 2, '2021-06-01 09:00:00', 'No', 16),
(7, 8, 7, 3, '2021-06-01 09:00:00', 'No', 16),
(8, 9, 8, 3, '2021-06-01 09:00:00', 'No', 16),
(9, 10, 9, 3, '2021-06-01 09:00:00', 'No', 16),
(10, 1, 10, 4, '2021-06-01 09:00:00', 'Yes', 8),
(11, 2, 11, 4, '2021-06-01 09:00:00', 'No', 16),
(12, 3, 12, 4, '2021-06-01 09:00:00', 'No', 16),
(13, 4, 13, 5, '2021-06-01 09:00:00', 'No', 16),
(14, 5, 14, 5, '2021-06-01 09:00:00', 'No', 16),
(15, 6, 15, 5, '2021-06-01 09:00:00', 'Yes', 8),
(16, 2, 1, 1, '2021-06-01 13:00:00', 'No', 16),
(17, 8, 2, 1, '2021-06-01 13:00:00', 'No', 11),
(18, 9, 3, 1, '2021-06-01 13:00:00', 'No', 15),
(19, 10, 4, 2, '2021-06-01 13:00:00', 'No', 16),
(20, 1, 5, 2, '2021-06-01 13:00:00', 'Yes', 4),
(21, 2, 6, 2, '2021-06-01 13:00:00', 'No', 16),
(22, 3, 7, 3, '2021-06-01 13:00:00', 'No', 16),
(23, 4, 8, 3, '2021-06-01 13:00:00', 'No', 16),
(24, 5, 9, 3, '2021-06-01 13:00:00', 'No', 16),
(25, 6, 10, 4, '2021-06-01 13:00:00', 'Yes', 8),
(26, 7, 11, 4, '2021-06-01 13:00:00', 'No', 16),
(27, 8, 12, 4, '2021-06-01 13:00:00', 'No', 16),
(28, 9, 13, 5, '2021-06-01 13:00:00', 'No', 16),
(29, 10, 14, 5, '2021-06-01 13:00:00', 'No', 16),
(30, 1, 15, 5, '2021-06-01 13:00:00', 'Yes', 8),
(31, 2, 1, 1, '2021-06-01 17:00:00', 'No', 16),
(32, 3, 2, 1, '2021-06-01 17:00:00', 'No', 16),
(33, 4, 3, 1, '2021-06-01 17:00:00', 'No', 16),
(34, 5, 4, 2, '2021-06-01 17:00:00', 'No', 16),
(35, 6, 5, 2, '2021-06-01 17:00:00', 'Yes', 8),
(36, 7, 6, 2, '2021-06-01 17:00:00', 'No', 16),
(37, 8, 7, 3, '2021-06-01 17:00:00', 'No', 16),
(38, 9, 8, 3, '2021-06-01 17:00:00', 'No', 16),
(39, 3, 9, 3, '2021-06-01 17:00:00', 'No', 16),
(40, 1, 10, 4, '2021-06-01 17:00:00', 'Yes', 8),
(41, 2, 11, 4, '2021-06-01 17:00:00', 'No', 16),
(42, 3, 12, 4, '2021-06-01 17:00:00', 'No', 16),
(43, 4, 13, 5, '2021-06-01 17:00:00', 'No', 16),
(44, 5, 14, 5, '2021-06-01 17:00:00', 'No', 16),
(45, 6, 15, 5, '2021-06-01 17:00:00', 'Yes', 8),
(46, 2, 1, 1, '2021-06-01 21:00:00', 'No', 16),
(47, 8, 2, 1, '2021-06-01 21:00:00', 'No', 16),
(48, 9, 3, 1, '2021-06-01 21:00:00', 'No', NULL),
(49, 2, 4, 2, '2021-06-01 21:00:00', 'No', NULL),
(50, 1, 5, 2, '2021-06-01 21:00:00', 'Yes', 8),
(51, 2, 6, 2, '2021-06-01 21:00:00', 'No', 16),
(52, 3, 7, 3, '2021-06-01 21:00:00', 'No', 16),
(53, 4, 8, 3, '2021-06-01 21:00:00', 'No', 16),
(54, 5, 9, 3, '2021-06-01 21:00:00', 'No', 16),
(55, 6, 10, 4, '2021-06-01 21:00:00', 'Yes', 8),
(56, 7, 11, 4, '2021-06-01 21:00:00', 'No', 16),
(57, 8, 12, 4, '2021-06-01 21:00:00', 'No', 16),
(58, 9, 13, 5, '2021-06-01 21:00:00', 'No', 16),
(59, 5, 14, 5, '2021-06-01 21:00:00', 'No', 16),
(60, 1, 15, 5, '2021-06-01 21:00:00', 'Yes', 8);

-- --------------------------------------------------------

--
-- Table structure for table `theater`
--

CREATE TABLE `theater` (
  `Theater_Id` int(11) NOT NULL,
  `Theater_Name` varchar(30) NOT NULL,
  `Theater_Rating` double NOT NULL,
  `No_of_Screens` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`Theater_Id`, `Theater_Name`, `Theater_Rating`, `No_of_Screens`) VALUES
(1, 'The Forum Vijaya Mall', 4.55, 3),
(2, 'Sathyam Movies', 4.32, 3),
(3, 'AGS Cinema', 4.22, 3),
(4, 'Luxe Cinemas', 3.87, 3),
(5, 'Palazzo', 4.14, 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `theater_view`
-- (See below for the actual view)
--
CREATE TABLE `theater_view` (
`Theater_Id` int(11)
,`Theater_Name` varchar(30)
,`Theater_Rating` double
,`No_of_Screens` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `show_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `theater_name` varchar(30) DEFAULT NULL,
  `screen_no` int(11) DEFAULT NULL,
  `seat_no` varchar(20) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `show_id`, `customer_id`, `theater_name`, `screen_no`, `seat_no`, `price`) VALUES
(186, 5, 11, 'Sathyam Movies', 2, 'dejo', 120),
(187, 20, 11, 'Sathyam Movies', 2, 'demo', 120),
(188, 3, 11, 'The Forum Vijaya Mall', 3, 'finp', 110),
(189, 17, 11, 'The Forum Vijaya Mall', 2, 'agijo', 100),
(190, 49, 11, 'Sathyam Movies', 1, 'bjko', 100),
(191, 2, 11, 'The Forum Vijaya Mall', 2, 'fkln', 100),
(192, 18, 11, 'The Forum Vijaya Mall', 3, 'j', 117),
(193, 18, 11, 'The Forum Vijaya Mall', 3, '', 117);

-- --------------------------------------------------------

--
-- Structure for view `movie_view`
--
DROP TABLE IF EXISTS `movie_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `movie_view`  AS  select `movie`.`movie_id` AS `movie_id`,`movie`.`movie_name` AS `movie_name`,`movie`.`genre` AS `genre`,`movie`.`movie_rating` AS `movie_rating`,`movie`.`No_of_rating` AS `No_of_rating`,`movie`.`duration` AS `duration` from `movie` ;

-- --------------------------------------------------------

--
-- Structure for view `theater_view`
--
DROP TABLE IF EXISTS `theater_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `theater_view`  AS  select `theater`.`Theater_Id` AS `Theater_Id`,`theater`.`Theater_Name` AS `Theater_Name`,`theater`.`Theater_Rating` AS `Theater_Rating`,`theater`.`No_of_Screens` AS `No_of_Screens` from `theater` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_Id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movie_id`),
  ADD UNIQUE KEY `movie_unique` (`movie_name`);

--
-- Indexes for table `screen`
--
ALTER TABLE `screen`
  ADD PRIMARY KEY (`screen_id`),
  ADD KEY `theater_id` (`theater_id`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `show_id` (`show_id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`show_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `theater_id` (`theater_id`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Indexes for table `theater`
--
ALTER TABLE `theater`
  ADD PRIMARY KEY (`Theater_Id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `show_id` (`show_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `screen`
--
ALTER TABLE `screen`
  MODIFY `screen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `theater`
--
ALTER TABLE `theater`
  MODIFY `Theater_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `screen`
--
ALTER TABLE `screen`
  ADD CONSTRAINT `screen_ibfk_1` FOREIGN KEY (`theater_id`) REFERENCES `theater` (`Theater_Id`);

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`);

--
-- Constraints for table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `shows_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`movie_id`),
  ADD CONSTRAINT `shows_ibfk_2` FOREIGN KEY (`theater_id`) REFERENCES `theater` (`Theater_Id`),
  ADD CONSTRAINT `shows_ibfk_3` FOREIGN KEY (`screen_id`) REFERENCES `screen` (`screen_id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Customer_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
