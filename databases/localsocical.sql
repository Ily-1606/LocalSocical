-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 14, 2020 lúc 03:57 PM
-- Phiên bản máy phục vụ: 10.4.13-MariaDB
-- Phiên bản PHP: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `localsocical`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_account`
--

CREATE TABLE `table_account` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT '/assets/img/male.png',
  `phone_number` varchar(30) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `table_account`
--

INSERT INTO `table_account` (`id`, `first_name`, `last_name`, `email`, `password`, `avatar`, `phone_number`, `gender`, `create_time`) VALUES
(1, 'Nguyen', 'Nguyen', 'khuonmatdangthuong45@gmail.com', '6d590d0d8702e8132a77913bf707de45', '/assets/img/male.png', '0328267412', 1, '2020-11-07 16:21:42'),
(2, 'Nguyễn', 'Nguyên', 'no1.ily1606@gmail.com', '6d590d0d8702e8132a77913bf707de45', '/assets/img/male.png', '0328267412', 1, '2020-11-11 14:14:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_messages`
--

CREATE TABLE `table_messages` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `message_text` text DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `user_send` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `hidden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `table_messages`
--

INSERT INTO `table_messages` (`id`, `thread_id`, `message_text`, `attachment`, `user_send`, `create_time`, `hidden`) VALUES
(1, 2, '1', NULL, 1, '2020-11-14 12:01:51', 1),
(2, 2, '2', NULL, 1, '2020-11-14 12:01:53', 0),
(3, 2, '3', NULL, 1, '2020-11-14 12:01:55', 0),
(4, 2, '4', NULL, 1, '2020-11-14 12:02:00', 0),
(5, 2, '5', NULL, 1, '2020-11-14 12:02:01', 0),
(6, 2, '6', NULL, 1, '2020-11-14 12:02:01', 0),
(7, 2, '7', NULL, 1, '2020-11-14 12:02:02', 0),
(8, 2, '8', NULL, 1, '2020-11-14 12:02:03', 0),
(9, 2, '9', NULL, 1, '2020-11-14 12:02:04', 0),
(10, 2, '10', NULL, 1, '2020-11-14 12:02:05', 0),
(11, 2, '11', NULL, 1, '2020-11-14 12:02:06', 0),
(12, 2, '12', NULL, 1, '2020-11-14 12:02:07', 0),
(13, 2, '13', NULL, 1, '2020-11-14 12:02:08', 0),
(14, 2, '14', NULL, 1, '2020-11-14 12:02:09', 0),
(15, 2, '15', NULL, 1, '2020-11-14 12:02:10', 0),
(16, 2, 'test', NULL, 2, '2020-11-14 12:21:14', 1),
(17, 2, '16', NULL, 1, '2020-11-14 12:53:34', 0),
(18, 2, '17', NULL, 1, '2020-11-14 12:53:37', 0),
(19, 2, '18', NULL, 1, '2020-11-14 12:53:38', 0),
(20, 2, '19', NULL, 1, '2020-11-14 12:53:40', 0),
(21, 2, '20', NULL, 1, '2020-11-14 12:53:41', 0),
(22, 2, '21', NULL, 1, '2020-11-14 12:53:42', 0),
(23, 2, '22', NULL, 1, '2020-11-14 12:53:43', 0),
(24, 2, '23', NULL, 1, '2020-11-14 12:53:44', 0),
(25, 2, '24', NULL, 1, '2020-11-14 12:53:45', 0),
(26, 2, '25', NULL, 1, '2020-11-14 12:53:46', 0),
(27, 2, '26', NULL, 1, '2020-11-14 12:53:47', 0),
(28, 2, '27', NULL, 1, '2020-11-14 12:53:48', 1),
(29, 2, '28', NULL, 1, '2020-11-14 12:53:51', 1),
(30, 2, '29', NULL, 1, '2020-11-14 12:53:52', 1),
(31, 2, '30', NULL, 1, '2020-11-14 12:53:53', 1),
(32, 2, '31', NULL, 1, '2020-11-14 12:53:54', 1),
(33, 2, '32', NULL, 1, '2020-11-14 13:43:52', 1),
(34, 2, '33', NULL, 1, '2020-11-14 14:08:56', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_thread`
--

CREATE TABLE `table_thread` (
  `id` int(11) NOT NULL,
  `type` varchar(30) DEFAULT 'per_to_per',
  `member_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`member_list`)),
  `adminnitranstor` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`adminnitranstor`)),
  `name_room` varchar(255) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `table_thread`
--

INSERT INTO `table_thread` (`id`, `type`, `member_list`, `adminnitranstor`, `name_room`, `create_time`) VALUES
(1, 'per_to_per', '[\"1\",\"1\"]', NULL, NULL, '2020-11-12 01:35:08'),
(2, 'per_to_per', '[\"1\",\"2\"]', NULL, NULL, '2020-11-12 01:36:38'),
(4, 'group', '[\"1\",\"2\"]', '[\"1\"]', 'Test', '2020-11-12 14:31:34');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `table_account`
--
ALTER TABLE `table_account`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_messages`
--
ALTER TABLE `table_messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_thread`
--
ALTER TABLE `table_thread`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `table_account`
--
ALTER TABLE `table_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `table_messages`
--
ALTER TABLE `table_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `table_thread`
--
ALTER TABLE `table_thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
