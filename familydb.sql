CREATE DATABASE `familydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `familydb`;


--
-- Table structure for table `gamesave`
--

CREATE TABLE `gamesave` (
  `id` int(11) NOT NULL,
  `leaderid` int(11) NOT NULL,
  `savename` varchar(255) NOT NULL,
  `factiontype` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gameyear` decimal(10,1) NOT NULL DEFAULT '200.0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;



--
-- Table structure for table `people`
--


CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `dob` decimal(10,1) NOT NULL,
  `portrait` int(11) DEFAULT NULL,
  `gender` int(11) NOT NULL DEFAULT '1',
  `bio` text,
  `traits` text,
  `fatherid` int(11) DEFAULT NULL,
  `motherid` int(11) DEFAULT NULL,
  `spouseid` int(11) DEFAULT NULL,
  `children` int(11) NOT NULL DEFAULT '0',
  `fertility` int(11) NOT NULL DEFAULT '4',
  `alive` int(11) NOT NULL DEFAULT '1',
  `deathyear` decimal(10,1) DEFAULT NULL,
  `deathdesc` text,
  `gameid` int(11) NOT NULL,
  `linelinknumber` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2377 DEFAULT CHARSET=utf8;


--
-- Table structure for table `linknumbers`
--


CREATE TABLE `linknumbers` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `linkid` int(11) NOT NULL,
  `personid` int(11) NOT NULL,
  `fatherid` int(11) NOT NULL,
  `motherid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=413 DEFAULT CHARSET=utf8;




--
-- Indexes for table `gamesave`
--
ALTER TABLE `gamesave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linknumbers`
--
ALTER TABLE `linknumbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gamesave`
--
ALTER TABLE `gamesave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `linknumbers`
--
ALTER TABLE `linknumbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
