-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2023 at 09:59 PM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_bloodshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `B2B_requests`
--

CREATE TABLE `B2B_requests` (
  `B2B_id` int NOT NULL,
  `requester_blood_bank` int NOT NULL,
  `recipient_blood_bank` int NOT NULL,
  `request_date` datetime NOT NULL,
  `bloodgroup` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `no_of_bags` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `B2B_requests`
--

INSERT INTO `B2B_requests` (`B2B_id`, `requester_blood_bank`, `recipient_blood_bank`, `request_date`, `bloodgroup`, `status`, `no_of_bags`) VALUES
(1, 2, 3, '2023-07-07 17:03:11', 'A+', 'accepted', 1),
(2, 2, 3, '2023-07-07 17:04:22', 'A+', 'rejected', 1),
(3, 3, 1, '2023-07-07 17:08:28', 'A+', 'pending', 1),
(4, 2, 1, '2023-07-07 17:09:14', 'AB+', 'pending', 1),
(5, 2, 1, '2023-07-07 17:10:46', 'A+', 'pending', 1),
(8, 2, 3, '2023-07-07 17:19:21', 'B+', 'accepted', 2);

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank`
--

CREATE TABLE `blood_bank` (
  `bloodbank_id` int UNSIGNED NOT NULL,
  `bloodbank_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `blood_bank`
--

INSERT INTO `blood_bank` (`bloodbank_id`, `bloodbank_name`, `address`, `phone_number`, `email`, `password`) VALUES
(163, 'Salam Blood Bank', 'El Salam, First', '01037284932', 'sbb@bloodbank.com', '$2y$10$ghjx4KJhPDbuL2KE.WVVtOIJfUXlRrePsY9g4M4b0Oh5SXcPDStG6'),
(1, 'Assiut', 'Assiut downtown', '01020330497', 'assiut@bloodbank.com', '$2y$10$ynumNTlUaXf2pU6rhq66CenT6TTA05slY0r6MWkgiFRwH.E76T8My'),
(2, 'Menoufia', 'downtown city', '01136699369', 'm@bloodbank.com', '$2y$10$vGGr9LFm90UcD2l24w0r6uUbSyMItwNLAUh2yZ/KJJUymujwdwrpm'),
(3, 'Doukky', 'Douky, Cairo', '123', 'douky@bloodbank.com', '$2y$10$krSeqJcjuJCRM17Q6bsDyO1icjBuca1M.JxrgiJ4KVFMhmjqWpgji'),
(4, 'Madinat Nasr', 'madinat nasrt, cairo', '01134422336', 'mn@bloodbank.com', '$2y$10$GZ8b2KDkoS9pYJlGy8uX5.CbThyD5Qd9PoFrh5vtYeCvHkAdYNBf.'),
(5, 'Ismailia', 'DownTown city', '01136699745', 'ismailia@bloodbank.com', '$2y$10$novoAxFoGP2nQzqMQQVfVOj2rJDcB39NY.URGSXAhhDr8oEZNtaW2');

-- --------------------------------------------------------

--
-- Table structure for table `donation_center`
--

CREATE TABLE `donation_center` (
  `donation_center_id` int NOT NULL,
  `donation_center_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `blood_bank_id` int NOT NULL,
  `donation_center_location` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `donation_center`
--

INSERT INTO `donation_center` (`donation_center_id`, `donation_center_name`, `email`, `password`, `blood_bank_id`, `donation_center_location`) VALUES
(1, 'Blood Bank Alnozha', 'ahmed@staff.com', '$2y$10$WtHyROmomxNB6yV3hjoTvOcQdnBxkOpBuifCbsYpUxQU18.mzJa.K', 1, 'sheraton'),
(2, 'Youssef', 'youssef@staff.com', '$2y$10$ageilxTAxUhFBHcM.fgXquatOpMz13xK1fruV7hrPsJkF2ssvsnU6', 1, 'Heliopolis'),
(3, 'El nozha', 'sall@staff.com', '$2y$10$xEYtKPTNL3crtb3F5v3r8.xAUYu/bo3TIuc/8aYW8wS1CWeVZSNZm', 1, 'El nozha'),
(5, 'Qibaa MBCU', 'qmbcu@staff.com', '$2y$10$a7GecCa8fmMTUXu0TrKj..SVEK62ux/fmf8GOEBecgeQd6fw1rvay', 163, 'Qibaa St.');

-- --------------------------------------------------------

--
-- Table structure for table `donation_requests`
--

CREATE TABLE `donation_requests` (
  `request_id` int NOT NULL,
  `donor_id` int NOT NULL,
  `donation_center_id` int NOT NULL,
  `request_date` datetime NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donation_requests`
--

INSERT INTO `donation_requests` (`request_id`, `donor_id`, `donation_center_id`, `request_date`, `status`) VALUES
(5, 22, 1, '2023-07-05 19:00:00', 'complete'),
(6, 41, 1, '2023-07-12 11:00:00', 'complete'),
(7, 28, 2, '2023-07-25 12:00:00', 'complete'),
(8, 43, 2, '2023-07-09 11:00:00', 'complete'),
(9, 45, 2, '2023-07-19 10:30:00', 'complete'),
(11, 44, 5, '2023-07-10 11:00:00', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int NOT NULL,
  `bloodbank_id` int NOT NULL,
  `blood_group` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_notification` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire`
--

CREATE TABLE `questionnaire` (
  `questionnaire_id` int UNSIGNED NOT NULL,
  `donor_id` int UNSIGNED NOT NULL,
  `surgery` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ssn` varchar(30) DEFAULT NULL,
  `gender` varchar(6) NOT NULL,
  `age` int NOT NULL,
  `city` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `bloodgroup` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `lastDonation` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `lname`, `email`, `password`, `ssn`, `gender`, `age`, `city`, `address`, `bloodgroup`, `lastDonation`) VALUES
(21, 'salahhhhuishS', 'wahshhhhhLISGS', 'sall@g.com', '$2y$10$xNzLUdAZO7MejUIDUgrEJuw4rPLoa2XEdbWxdTxFn59i6GiR0VpAa', NULL, 'on', 21, 'cairoooooS', 'cairo, egypttttttSS', 'A', '2023-05-15'),
(22, 'naglaa', 'ali', 'n@g.com', '$2y$10$ufd09ZaHDZxPfj4tWqiO3.iP/eiXbxdSbPvmMWhxw5KAPFNluX/wS', NULL, 'female', 21, 'cairo', 'cairo, egypt', 'O', '2023-07-10'),
(23, 'hossam', 'badran', 'h@g.com', '$2y$10$WtHyROmomxNB6yV3hjoTvOcQdnBxkOpBuifCbsYpUxQU18.mzJa.K', NULL, 'male', 25, 'cairo', 'cairo, egypt', 'AB', '2023-03-20'),
(24, 'admin', 'admin', 'admin@gov.gov', '$2y$10$e5LW501GLDuBV/YPC5LiKOjV9CwKB8nKYALJspCfi4s7vAiZ20pIS', NULL, 'male', 33, 'cairo', 'address', 'O', '2023-02-05'),
(25, 'ali', 'ahmed', 'ali@g.com', '$2y$10$CscEySmr3t3tIZdcyVSPjO4QdE6xzhn7moWRyCxIIEqLVsBCLat2K', NULL, 'male', 0, 'cairo', 'cairo', 'AB', '2023-07-01'),
(27, 'youssef', 'abdelkarim', 'y@g.com', '$2y$10$j4ruTzyj6GlN9sBLPbb8Seh5qKeweRbi3TacVmshCK/Dqbqcrxqqa', NULL, 'male', 21, 'cairo', 'cairo, egypt', 'O', '2023-07-10'),
(28, 'fady', 'fady', 'fady@g', '$2y$10$vGGr9LFm90UcD2l24w0r6uUbSyMItwNLAUh2yZ/KJJUymujwdwrpm', NULL, 'male', 24, 'Cairo', 'Address', 'A+', '2023-07-10'),
(41, 'ammar', 'yasser', 'ammar@g.com', '$2y$10$WWzaCRGCwB3VU05VsmJBR.CgZJ1kMVgZfYByilCwq/99AOtw1XlHK', '11223344556677', 'male', 23, 'Cairo', 'El Obour', 'AB', '2023-07-10'),
(42, 'timo', 'tooty', 'timo@g', '$2y$10$UcA7WeoV6YXje.570GJLt.Bxd5n.nqdkG4pWfy4DfM64H7kqMu7mS', '12345678912345', 'male', 24, 'Cairo', 'DownTown city', 'AB+', NULL),
(43, 'Keemo', 'Shakwaw', 'keemo@g', '$2y$10$WD/wIrADymZTNEnk9l/Sl.CjdLzZR5ZhQ5xSJEKdMM9U6hTADSs2O', '12345678901234', 'male', 21, 'Cairo', 'Address', 'A+', '2023-07-10'),
(44, 'mosta', 'mosta', 'mosta@g', '$2y$10$LO1TGn.sjWQY4t.KF7Z./ueAN3KePF0gbGaxrRst9/KhRR/cluAPS', '12345678904561', 'male', 21, 'Cairo', 'Address', 'O-', '2023-07-10'),
(5, 'lara', 'ali', 'lara@g', '$2y$10$lkna2lqV9cd4bsq4ZnaO0.o7LzzoLyCxoEz72ZRBUsY0rqx9jcPqS', '12345678905678', 'female', 22, 'Cairo', 'Address', 'A+', '2023-07-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `B2B_requests`
--
ALTER TABLE `B2B_requests`
  ADD PRIMARY KEY (`B2B_id`);

--
-- Indexes for table `blood_bank`
--
ALTER TABLE `blood_bank`
  ADD PRIMARY KEY (`bloodbank_id`);

--
-- Indexes for table `donation_center`
--
ALTER TABLE `donation_center`
  ADD PRIMARY KEY (`donation_center_id`),
  ADD KEY `hospital_id` (`blood_bank_id`);

--
-- Indexes for table `donation_requests`
--
ALTER TABLE `donation_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`questionnaire_id`),
  ADD KEY `donor_id` (`donor_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `B2B_requests`
--
ALTER TABLE `B2B_requests`
  MODIFY `B2B_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `blood_bank`
--
ALTER TABLE `blood_bank`
  MODIFY `bloodbank_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `donation_center`
--
ALTER TABLE `donation_center`
  MODIFY `donation_center_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donation_requests`
--
ALTER TABLE `donation_requests`
  MODIFY `request_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `questionnaire_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
