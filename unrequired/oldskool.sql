-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2021 at 12:52 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skoolyard`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_task`
--

CREATE TABLE `accepted_task` (
  `id` bigint(50) NOT NULL,
  `c_id` bigint(50) NOT NULL,
  `t_id` bigint(50) NOT NULL,
  `b_id` bigint(50) NOT NULL,
  `review` text NOT NULL,
  `job_success` int(11) NOT NULL,
  `recomendation` int(11) NOT NULL,
  `on_time` int(11) NOT NULL,
  `on_budget` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ratings` float DEFAULT NULL,
  `statu` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `adm_id` bigint(20) DEFAULT NULL,
  `emp_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accepted_task`
--

INSERT INTO `accepted_task` (`id`, `c_id`, `t_id`, `b_id`, `review`, `job_success`, `recomendation`, `on_time`, `on_budget`, `time_stamp`, `ratings`, `statu`, `price`, `adm_id`, `emp_status`) VALUES
(5, 8, 6, 2, 'The best worker for every task.', 1, 0, 1, 0, '2021-04-09 18:43:40', 4.5, 1, NULL, 16, NULL),
(14, 8, 4, 8, 'Good', 1, 1, 1, 1, '2021-05-01 15:37:55', 5, 1, 100, 16, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `adm`
--

CREATE TABLE `adm` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `stat` text DEFAULT NULL,
  `fir_name` text DEFAULT NULL,
  `las_name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `ph_no` text DEFAULT NULL,
  `username` text DEFAULT NULL,
  `pass` text DEFAULT NULL,
  `adm` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adm`
--

INSERT INTO `adm` (`id`, `u_id`, `stat`, `fir_name`, `las_name`, `email`, `ph_no`, `username`, `pass`, `adm`) VALUES
(1, 2, '2', NULL, NULL, NULL, NULL, NULL, NULL, '00'),
(2, 2, '2', NULL, NULL, NULL, NULL, NULL, NULL, '01'),
(3, 6, '2', 'Vansh', 'Patpatia', 'vansh10patpatia@gmail.com', '+918449129069', 'vanshpatpatia', '12341234', '00'),
(4, 6, '2', 'Sankalp', 'Rai', 'itsraisankalp@gmail.com', '+91893880699', 'sankyrai', '12341234', '01'),
(5, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0'),
(6, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(7, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0'),
(8, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(9, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00'),
(10, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01'),
(11, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00'),
(12, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `method` text DEFAULT NULL,
  `acc_no` bigint(20) DEFAULT NULL,
  `routing_no` bigint(20) DEFAULT NULL,
  `card_no` bigint(20) DEFAULT NULL,
  `name_card` text DEFAULT NULL,
  `username` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `u_id`, `method`, `acc_no`, `routing_no`, `card_no`, `name_card`, `username`, `time_stamp`, `stat`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-02 11:34:54', 2),
(2, 8, 'PayPal', NULL, NULL, NULL, NULL, 'pancham_sheroan', '2021-04-02 11:35:05', 1),
(3, 6, 'Cashapp', NULL, NULL, NULL, NULL, 'rahulchand', '2021-04-02 11:35:00', 2),
(4, 15, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-02 11:35:13', 1),
(5, 17, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-09 20:42:33', 3),
(6, 18, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-09 20:46:28', 3),
(7, 19, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 08:53:38', 5),
(8, 20, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 08:56:31', 2),
(9, 21, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 09:01:53', 3),
(10, 22, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 09:25:59', 3),
(11, 23, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 13:58:49', 3),
(12, 24, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:02:54', 3),
(13, 25, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:05:55', 3),
(14, 26, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:07:55', 3),
(15, 27, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:08:32', 3),
(16, 28, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:11:46', 5),
(17, 29, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:12:20', 2),
(18, 31, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:22:15', 2),
(19, 33, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:24:00', 2),
(20, 34, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:28:34', 3),
(21, 35, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:29:52', 3),
(22, 36, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:32:34', 3),
(23, 37, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:33:37', 3),
(24, 42, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 14:54:24', 3),
(25, 43, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-10 15:17:22', 3);

-- --------------------------------------------------------

--
-- Table structure for table `bidding`
--

CREATE TABLE `bidding` (
  `id` bigint(50) NOT NULL,
  `t_id` bigint(50) NOT NULL,
  `c_id` bigint(50) NOT NULL,
  `bid_expected` bigint(50) NOT NULL,
  `time_no` bigint(50) NOT NULL,
  `time_type` bigint(50) NOT NULL,
  `description` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bidding`
--

INSERT INTO `bidding` (`id`, `t_id`, `c_id`, `bid_expected`, `time_no`, `time_type`, `description`, `time_stamp`, `stat`) VALUES
(2, 4, 2, 2000, 2, 2, 'i am worst', '2021-04-05 07:00:41', 0),
(6, 8, 8, 54, 4, 2, 'i am boss of my own and i love nothing', '2021-04-05 07:00:45', 0),
(7, 4, 8, 400, 12, 2, 'I am the best in bussiness . I will asure you each task will be completed in the best manner it can be done .', '2021-04-05 07:01:15', 1),
(8, 6, 8, 100, 10, 2, 'Ready to work on this!', '2021-04-12 15:54:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bid_request`
--

CREATE TABLE `bid_request` (
  `id` bigint(50) NOT NULL,
  `b_id` bigint(50) NOT NULL,
  `request` bigint(50) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `t_id` bigint(50) NOT NULL,
  `f_id` bigint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `u_id`, `t_id`, `f_id`) VALUES
(16, 8, 4, 0),
(34, 6, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `completed`
--

CREATE TABLE `completed` (
  `id` bigint(20) NOT NULL,
  `description` text DEFAULT NULL,
  `img1` text DEFAULT NULL,
  `img2` text DEFAULT NULL,
  `task_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `completed`
--

INSERT INTO `completed` (`id`, `description`, `img1`, `img2`, `task_id`, `user_id`) VALUES
(2, 'Very Good', '1618319810_blog-03a.jpg', NULL, 4, 8),
(8, 'I have Done My Work', '1618325704_home-background.jpg', NULL, 8, 8),
(23, 'I have done My work', 'TIME TABLE_offline.pdf', '1618314383_blog-01a.jpg', 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `employer_reviews`
--

CREATE TABLE `employer_reviews` (
  `id` int(11) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `t_id` int(11) DEFAULT NULL,
  `speci` int(11) DEFAULT NULL,
  `comm` int(11) DEFAULT NULL,
  `payment` int(11) DEFAULT NULL,
  `profess` int(11) DEFAULT NULL,
  `ratings` float DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `review` text DEFAULT NULL,
  `u_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employer_reviews`
--

INSERT INTO `employer_reviews` (`id`, `c_id`, `t_id`, `speci`, `comm`, `payment`, `profess`, `ratings`, `time_stamp`, `review`, `u_id`) VALUES
(1, 6, 4, 5, 4, 5, 4, 5, '2021-04-01 13:26:00', 'Good Behaviour', 8),
(2, 6, 6, 4, 4, 4, 5, 5, '2021-04-01 13:25:51', 'Good boy', 8),
(3, 16, 6, 5, 5, 5, 5, 5, '2021-04-09 20:17:02', 'Vansh Patpatia is very nice guy!<3', 6);

-- --------------------------------------------------------

--
-- Table structure for table `insurance`
--

CREATE TABLE `insurance` (
  `id` bigint(20) NOT NULL,
  `u_id` bigint(20) DEFAULT NULL,
  `in_company` text DEFAULT NULL,
  `policy_no` bigint(20) DEFAULT NULL,
  `document` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance`
--

INSERT INTO `insurance` (`id`, `u_id`, `in_company`, `policy_no`, `document`) VALUES
(1, 6, 'LIC', 1255881, '1617987846_PPH_N_25_VANSH_PATPATIA.pdf'),
(2, 20, NULL, NULL, NULL),
(3, 29, NULL, NULL, NULL),
(4, 31, NULL, NULL, NULL),
(5, 33, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_tags`
--

CREATE TABLE `job_tags` (
  `id` bigint(50) NOT NULL,
  `j_id` bigint(50) NOT NULL,
  `tag` bigint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_tags`
--

INSERT INTO `job_tags` (`id`, `j_id`, `tag`) VALUES
(1, 8, 0),
(2, 3, 0),
(3, 6, 0),
(4, 8, 0),
(5, 9, 0),
(6, 9, 0),
(7, 9, 0),
(8, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` bigint(50) NOT NULL,
  `for_id` bigint(50) NOT NULL,
  `from_id` bigint(50) NOT NULL,
  `msg` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `for_id`, `from_id`, `msg`, `time_stamp`) VALUES
(1, 6, 6, 'test', '2021-04-12 10:12:32');

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE `milestones` (
  `id` bigint(20) NOT NULL,
  `task_id` bigint(20) DEFAULT NULL,
  `cus_id` bigint(20) DEFAULT NULL,
  `emp_id` bigint(20) DEFAULT NULL,
  `mil_title` text DEFAULT NULL,
  `mil_desc` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `due_date` date DEFAULT NULL,
  `pay_status` bigint(20) DEFAULT 0,
  `mil_status` bigint(20) DEFAULT 0,
  `price` bigint(20) DEFAULT NULL,
  `complete` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `milestones`
--

INSERT INTO `milestones` (`id`, `task_id`, `cus_id`, `emp_id`, `mil_title`, `mil_desc`, `time_stamp`, `due_date`, `pay_status`, `mil_status`, `price`, `complete`) VALUES
(1, 4, 16, 8, 'Create a mockup!!!!!!!', 'Happy Diwali', '2021-05-01 10:46:59', '2021-04-30', 0, 0, 300, 23),
(2, 4, 16, 8, 'Create UI designs', 'Show the UI design of the website as mentioned in the project details', '2021-05-01 16:41:40', '2021-05-14', 1, 0, 200, 0),
(6, 4, 16, 6, 'Back-end Connection ', 'Do this', '2021-05-01 15:37:03', '2021-05-08', NULL, NULL, 100, 0),
(14, 6, 16, 8, 'Back-end ', 'kr bhai isse', '2021-05-01 15:53:05', '2021-12-25', NULL, 0, 120, 0),
(16, 4, 16, 8, 'Kaam kr biro', 'kaam kr rha hai ki nhi', '2021-05-01 15:51:28', '2021-09-28', NULL, NULL, 512, 0),
(17, 6, 16, 8, 'Kaam kr biro', 'Please biro', '2021-05-01 15:52:08', '2021-06-14', NULL, NULL, 142, 0),
(18, 4, 16, 8, 'hello biro', 'kese ho?', '2021-05-01 16:01:17', '2021-06-01', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `milestones_payment`
--

CREATE TABLE `milestones_payment` (
  `id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `payment_ref` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'Failed',
  `user_id` varchar(10) NOT NULL,
  `project_id` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `milestones_payment`
--

INSERT INTO `milestones_payment` (`id`, `milestone_id`, `payment_ref`, `description`, `amount`, `status`, `user_id`, `project_id`, `timestamp`) VALUES
(1, 4, '4329621', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:25:20'),
(2, 4, '4460004', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:34:14'),
(3, 4, '4504544', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:34:51'),
(4, 4, '4943795', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:36:55'),
(5, 4, '4550044', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:39:26'),
(6, 4, '4678304', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:40:39'),
(7, 4, '4815947', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:41:04'),
(8, 4, '4764474', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:41:41'),
(9, 4, '4566586', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:47:57'),
(10, 4, '4118787', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:48:23'),
(11, 4, '4557459', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:49:00'),
(12, 4, '4739715', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:50:19'),
(13, 4, '4165070', 'Milestone- First Payment', 500, 'succeeded', '44', '14', '2021-05-03 12:51:09'),
(14, 4, '4309482', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-03 12:59:30'),
(15, 4, '4145648', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 05:58:52'),
(16, 4, '4385245', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:03:53'),
(17, 4, '4392401', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:08:45'),
(18, 4, '4210950', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:15:06'),
(19, 4, '4606247', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:15:49'),
(20, 4, '4599791', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:16:57'),
(21, 4, '4765780', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:20:59'),
(22, 4, '4578126', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:21:26'),
(23, 4, '4323856', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:34:31'),
(24, 4, '4534234', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 06:39:06'),
(25, 4, '4816727', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 07:24:06'),
(26, 4, '4681652', 'Milestone- First Payment', 5, 'succeeded', '44', '14', '2021-05-04 07:27:26');

-- --------------------------------------------------------

--
-- Table structure for table `milestones_transaction`
--

CREATE TABLE `milestones_transaction` (
  `id` int(11) NOT NULL,
  `contractor_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `transaction_detail` varchar(300) NOT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `status` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `milestones_transaction`
--

INSERT INTO `milestones_transaction` (`id`, `contractor_id`, `customer_id`, `transaction_id`, `transaction_detail`, `amount`, `status`, `timestamp`) VALUES
(1, 45, 44, '4392401', 'Milestone- First Payment', 5, 0, '2021-05-04 06:08:49'),
(2, 45, 44, '4578126', 'Milestone- First Payment', 5, 0, '2021-05-04 06:21:29'),
(3, 45, 44, '4323856', 'Milestone- First Payment', 5, 0, '2021-05-04 06:34:34'),
(4, 45, 44, '4534234', 'Milestone- First Payment', 5, 0, '2021-05-04 06:39:09'),
(5, 45, 44, '4816727', 'Milestone- First Payment', 5, 0, '2021-05-04 07:24:09'),
(6, 45, 44, '4681652', 'Milestone- First Payment', 5, 0, '2021-05-04 07:27:29');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `description` text NOT NULL,
  `priority` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `u_id`, `description`, `priority`, `time_stamp`) VALUES
(2, 6, 'Meeting with candidate at 3pm who applied for Bilingual Event Support Specialist', 'high', '2021-04-11 13:47:24'),
(12, 16, 'test', 'low', '2021-04-12 17:03:08');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(50) NOT NULL,
  `msg` text NOT NULL,
  `link` text NOT NULL,
  `for_id` bigint(50) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1-unread 2-read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `msg`, `link`, `for_id`, `status`) VALUES
(1, 'You have a new bid', 'manage_bidder.php?token=11', 44, 1),
(2, 'You have a new bid', 'manage_bidder.php?token=12', 44, 1),
(3, 'You have a new bid', 'manage_bidder.php?token=14', 44, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_job`
--

CREATE TABLE `post_job` (
  `id` bigint(50) NOT NULL,
  `e_id` bigint(50) NOT NULL,
  `j_title` text NOT NULL,
  `j_type` text NOT NULL,
  `end_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `catagory` text NOT NULL,
  `location` text NOT NULL,
  `min_salary` bigint(50) NOT NULL,
  `max_salary` bigint(50) NOT NULL,
  `j_description` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_job`
--

INSERT INTO `post_job` (`id`, `e_id`, `j_title`, `j_type`, `end_date`, `catagory`, `location`, `min_salary`, `max_salary`, `j_description`, `time_stamp`, `status`) VALUES
(4, 6, 'Web development', 'Freelance', '2021-02-27 18:30:00', 'Counseling', '', 2, 3, '3333', '2021-02-19 06:16:29', 1),
(8, 6, 'Nothing', 'Freelance', '2021-02-20 18:30:00', 'Clerical & Data Entry', '', 12, 22, 'Man with no talent', '2021-02-19 06:37:30', 3),
(9, 20, 'jobtest', 'Full Time', '2021-04-19 18:30:00', 'Investigative', '', 13, 133, 'descriptiontest', '2021-04-10 08:58:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_task`
--

CREATE TABLE `post_task` (
  `id` bigint(50) NOT NULL,
  `e_id` bigint(50) NOT NULL,
  `t_name` text NOT NULL,
  `t_catagory` text NOT NULL,
  `end_date` date DEFAULT NULL,
  `location` text NOT NULL,
  `min_salary` bigint(50) NOT NULL,
  `max_salary` bigint(50) NOT NULL,
  `t_description` text NOT NULL,
  `pay_type` bigint(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cat_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_task`
--

INSERT INTO `post_task` (`id`, `e_id`, `t_name`, `t_catagory`, `end_date`, `location`, `min_salary`, `max_salary`, `t_description`, `pay_type`, `status`, `time_stamp`, `cat_type`) VALUES
(4, 16, 'Bugs freeee', '2', '2021-04-09', 'Pakistan', 1, 100, 'You must be perfect in all fields and a well educated person', 1, 4, '2021-04-12 15:57:17', 1),
(6, 16, 'Web Development', '1', '2021-04-03', 'USA', 12, 15, 'Man with good sence of humor', 2, 3, '2021-04-11 10:13:46', 2),
(8, 16, 'Pubg', '2', '2021-04-03', 'India', 200, 2000, 'I want pubg', 1, 1, '2021-04-12 15:57:58', 1),
(10, 16, 'Time Pass app', 'IT & Networking', '2021-03-30', '', 23, 45, 'this is the international project', 1, 1, '2021-04-12 15:58:02', 2);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `bid_amount` text NOT NULL,
  `assigned_to` bigint(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `u_id`, `title`, `description`, `bid_amount`, `assigned_to`, `status`) VALUES
(1, 2, 'p1', 'hello', '54632', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `t_id` bigint(11) NOT NULL,
  `rating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `u_id`, `t_id`, `rating`) VALUES
(2, 8, 6, 4.8),
(3, 8, 4, 4.4),
(4, 6, 0, 3.2),
(5, 6, 0, 4.7),
(6, 8, 0, 3.8),
(7, 8, 5, 3.8),
(8, 6, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `removed_users`
--

CREATE TABLE `removed_users` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `c_id` bigint(50) NOT NULL,
  `p_id` bigint(50) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `skill` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `u_id`, `skill`) VALUES
(8, 8, 'Nothing'),
(9, 8, 'Drinking'),
(12, 8, 'Running');

-- --------------------------------------------------------

--
-- Table structure for table `skill_tasks`
--

CREATE TABLE `skill_tasks` (
  `id` bigint(50) NOT NULL,
  `t_id` bigint(50) NOT NULL,
  `skills` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skill_tasks`
--

INSERT INTO `skill_tasks` (`id`, `t_id`, `skills`) VALUES
(12, 6, 'lo'),
(14, 6, 'fucking'),
(15, 4, 'nothing'),
(16, 4, 'React'),
(17, 8, 'Web development'),
(18, 4, 'Android developer'),
(19, 8, 'Fattu'),
(20, 8, 'Nalla'),
(21, 10, 'time-passer'),
(22, 10, 'bewakuf');

-- --------------------------------------------------------

--
-- Table structure for table `socialmedia_links`
--

CREATE TABLE `socialmedia_links` (
  `id` bigint(50) NOT NULL,
  `platform` text NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `socialmedia_links`
--

INSERT INTO `socialmedia_links` (`id`, `platform`, `link`) VALUES
(1, 'instaa', 'abcde');

-- --------------------------------------------------------

--
-- Table structure for table `task_category`
--

CREATE TABLE `task_category` (
  `id` bigint(50) NOT NULL,
  `category` text NOT NULL,
  `icon` text NOT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_category`
--

INSERT INTO `task_category` (`id`, `category`, `icon`, `type`) VALUES
(1, 'Grass Cutting', 'https://img.icons8.com/plasticine/100/000000/lawn-mower.png', 1),
(2, 'Snow shoveling', 'https://img.icons8.com/officel/100/000000/interstate-plow-truck.png', 1),
(3, 'Snow plowing', 'https://img.icons8.com/ultraviolet/100/000000/interstate-plow-truck.png', 2),
(4, 'Junk Removal', 'https://img.icons8.com/dusk/100/000000/dump-truck.png', 1),
(5, 'Tree Removal', 'https://img.icons8.com/fluent/100/000000/deforestation.png', 2),
(6, 'Water Restoration', 'https://img.icons8.com/dusk/100/000000/water.png', 2),
(7, 'Vehicle Towing', 'https://img.icons8.com/officel/100/000000/tow-truck.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `task_tags`
--

CREATE TABLE `task_tags` (
  `id` bigint(50) NOT NULL,
  `j_id` bigint(50) NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(50) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_documents`
--

CREATE TABLE `uploaded_documents` (
  `id` bigint(50) NOT NULL,
  `t_id` bigint(50) NOT NULL,
  `document` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uploaded_documents`
--

INSERT INTO `uploaded_documents` (`id`, `t_id`, `document`) VALUES
(4, 4, '1617986761_Front_Page_PME.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type`) VALUES
(1, 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1),
(2, 'c1@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 2),
(4, 'user1@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(6, 'rahul@gmail.com', 'ed2b1f468c5f915f3f1cf75d7068baae', 2),
(7, 'rohit@gmail.com', '25f9e794323b453885f5181f1b624d0b', 0),
(8, 'pancham@gmail.com', 'ed2b1f468c5f915f3f1cf75d7068baae', 3),
(15, 'akshat@gmail.com', 'ed2b1f468c5f915f3f1cf75d7068baae', 3),
(16, 'vansh10patpatia@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 5),
(18, 'vansh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3),
(19, 'rashikhatri0013@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 5),
(20, 'r@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 2),
(21, 'rcontract@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(22, 'remp@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(23, 'hjsa@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(24, 'sdc@gmail.com', '202cb962ac59075b964b07152d234b70', 3),
(25, 'rep@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(26, 'rq@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3),
(27, 'ghjk@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(28, 'new@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 5),
(29, 'check@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 2),
(31, 'remp2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 2),
(33, 'emp@gmail.com', '25d55ad283aa400af464c76d713c07ad', 2),
(34, 'check2@gmail.com', '25d55ad283aa400af464c76d713c07ad', 3),
(35, 'test@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(36, 'test3@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(37, 'testfinal@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(42, 'rempnew@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(43, 'user@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `document` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` bigint(50) NOT NULL,
  `u_id` bigint(50) NOT NULL,
  `f_name` text NOT NULL,
  `l_name` text NOT NULL,
  `avtar` text NOT NULL,
  `mobile` text NOT NULL,
  `address` text NOT NULL,
  `hourly_rate` bigint(50) NOT NULL,
  `tagline` text NOT NULL,
  `nationality` text NOT NULL,
  `intro` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `u_id`, `f_name`, `l_name`, `avtar`, `mobile`, `address`, `hourly_rate`, `tagline`, `nationality`, `intro`, `status`) VALUES
(1, 2, 'Ocean', 'Negi', 'uploads/1615971240_bajrangbali.jpg', '1234567890', 'harrawala', -200, '', 'UK', 'mai garib hu', 2),
(3, 8, 'Pancham', 'Sheoran', 'uploads/1616598770_IMG-20190824-WA0010-01-01.jpeg', '8126828531', 'neww', 21, 'I am a developer', 'US', 'Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.\r\n\r\nCapitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.', 1),
(5, 6, 'Rahul', 'Chand', 'uploads/1615966394_1614140611914-01.jpeg', '8109716921', 'Dehradun', 84, 'nothing', 'US', 'Best of best', 2),
(9, 15, 'Akshat', 'Tripathi', 'uploads/1615971240_bajrangbali.jpg', '8109716921', 'ghr p', 134, 'lucky', 'IN', 'I am me', 0),
(10, 16, 'Vansh', 'Patpatia', 'uploads/111.jpeg', '8449089069', 'Hawa Mahal lane no. 5 Dhaka, Bangladesh', 50, 'Cyber Flow : The flow of code!!', 'US', 'I am a student who is at present developing his skills just to make a better career!', 5),
(11, 17, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(12, 18, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(13, 19, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(14, 20, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 2),
(15, 21, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(16, 22, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(17, 23, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(18, 24, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(19, 25, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(20, 26, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(21, 27, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(22, 28, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(23, 29, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(24, 31, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(25, 33, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(26, 34, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(27, 35, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(28, 36, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(29, 37, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(30, 42, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0),
(31, 43, '', '', 'images/user-avatar-placeholder.png', '', '', 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `website_details`
--

CREATE TABLE `website_details` (
  `id` bigint(50) NOT NULL,
  `title` text NOT NULL,
  `sub_title` text NOT NULL,
  `about` text NOT NULL,
  `email` text NOT NULL,
  `mobile` text NOT NULL,
  `address` text NOT NULL,
  `logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `website_details`
--

INSERT INTO `website_details` (`id`, `title`, `sub_title`, `about`, `email`, `mobile`, `address`, `logo`) VALUES
(1, 'abc', 'abcd', '     jsdkcnmx ', 'abc@gmail.com', '123456', 'Gayatri puram miyanwala dehradun', ''),
(5, 'jksxh', 'sxcv b', '   jksan', 'Mananryan1234@gmail.com', '4637389922', 'Gayatri puram miyanwala dehradun', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_task`
--
ALTER TABLE `accepted_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bidding`
--
ALTER TABLE `bidding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bid_request`
--
ALTER TABLE `bid_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `completed`
--
ALTER TABLE `completed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer_reviews`
--
ALTER TABLE `employer_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance`
--
ALTER TABLE `insurance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_tags`
--
ALTER TABLE `job_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_job`
--
ALTER TABLE `post_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_task`
--
ALTER TABLE `post_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `removed_users`
--
ALTER TABLE `removed_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill_tasks`
--
ALTER TABLE `skill_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socialmedia_links`
--
ALTER TABLE `socialmedia_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_category`
--
ALTER TABLE `task_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_tags`
--
ALTER TABLE `task_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploaded_documents`
--
ALTER TABLE `uploaded_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `website_details`
--
ALTER TABLE `website_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_task`
--
ALTER TABLE `accepted_task`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `adm`
--
ALTER TABLE `adm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `bidding`
--
ALTER TABLE `bidding`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bid_request`
--
ALTER TABLE `bid_request`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `completed`
--
ALTER TABLE `completed`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `employer_reviews`
--
ALTER TABLE `employer_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `insurance`
--
ALTER TABLE `insurance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_tags`
--
ALTER TABLE `job_tags`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_job`
--
ALTER TABLE `post_job`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `post_task`
--
ALTER TABLE `post_task`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `removed_users`
--
ALTER TABLE `removed_users`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `skill_tasks`
--
ALTER TABLE `skill_tasks`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `socialmedia_links`
--
ALTER TABLE `socialmedia_links`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_category`
--
ALTER TABLE `task_category`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `task_tags`
--
ALTER TABLE `task_tags`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uploaded_documents`
--
ALTER TABLE `uploaded_documents`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `website_details`
--
ALTER TABLE `website_details`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
