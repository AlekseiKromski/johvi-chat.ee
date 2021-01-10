-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 10 2021 г., 23:18
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `looechat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chat_privates`
--

CREATE TABLE `chat_privates` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_2` int(10) UNSIGNED NOT NULL,
  `channel_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chat_privates`
--

INSERT INTO `chat_privates` (`id`, `user_id`, `user_2`, `channel_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 5, 1, '2021-01-10 19:31:30', '2021-01-10 19:31:30', NULL),
(2, 5, 1, 1, '2021-01-10 19:37:29', '2021-01-10 19:37:29', NULL),
(3, 5, 4, 2, '2021-01-10 20:15:22', '2021-01-10 20:15:22', NULL),
(4, 4, 5, 2, '2021-01-10 20:15:22', '2021-01-10 20:15:22', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_private_channels`
--

CREATE TABLE `chat_private_channels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chat_private_channels`
--

INSERT INTO `chat_private_channels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'test.1', '2021-01-10 19:31:15', NULL),
(2, 'test.2', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_private_messages`
--

CREATE TABLE `chat_private_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `channel_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_2` int(10) UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chat_private_messages`
--

INSERT INTO `chat_private_messages` (`id`, `channel_id`, `user_id`, `user_2`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 1, 5, 'sas', '2021-01-10 20:11:14', '2021-01-10 20:11:14', NULL),
(3, 1, 1, 5, 'sasasdasd', '2021-01-10 20:11:32', '2021-01-10 20:11:32', NULL),
(4, 1, 1, 5, 'aasdads', '2021-01-10 20:11:50', '2021-01-10 20:11:50', NULL),
(5, 1, 1, 5, 'asdasd', '2021-01-10 20:12:26', '2021-01-10 20:12:26', NULL),
(6, 1, 1, 5, 'asdasdasdasd', '2021-01-10 20:12:32', '2021-01-10 20:12:32', NULL),
(7, 1, 1, 5, 'asdasd', '2021-01-10 20:13:26', '2021-01-10 20:13:26', NULL),
(8, 1, 1, 5, 'TEST', '2021-01-10 20:13:39', '2021-01-10 20:13:39', NULL),
(9, 1, 5, 1, 'Hi', '2021-01-10 20:14:07', '2021-01-10 20:14:07', NULL),
(10, 1, 1, 5, 'Yeeez', '2021-01-10 20:14:11', '2021-01-10 20:14:11', NULL),
(11, 2, 5, 4, 'Hi', '2021-01-10 20:16:17', '2021-01-10 20:16:17', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'ALPHA TEST SERVER', NULL, '2021-01-05 16:14:27', '2021-01-08 13:30:40'),
(2, 'ALPHA TEST SERVER 2', NULL, '2021-01-06 11:18:39', '2021-01-08 13:30:33');

-- --------------------------------------------------------

--
-- Структура таблицы `chat_room_members`
--

CREATE TABLE `chat_room_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `chat_room_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chat_room_members`
--

INSERT INTO `chat_room_members` (`id`, `user_id`, `chat_room_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2021-01-08 15:30:18', '2021-01-08 15:30:18', NULL),
(2, 1, 2, '2021-01-08 15:30:20', '2021-01-08 15:30:20', NULL),
(3, 5, 1, '2021-01-08 15:35:56', '2021-01-08 15:35:56', NULL),
(4, 5, 2, '2021-01-08 15:35:59', '2021-01-08 15:35:59', NULL),
(5, 6, 1, '2021-01-08 18:38:54', '2021-01-08 18:38:54', NULL),
(6, 6, 2, '2021-01-08 18:38:55', '2021-01-08 18:38:55', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_room_messages`
--

CREATE TABLE `chat_room_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `chat_room_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chat_room_messages`
--

INSERT INTO `chat_room_messages` (`id`, `chat_room_id`, `user_id`, `message`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 1, 1, 'Test', '2021-01-08 13:59:51', NULL, '2021-01-08 13:59:51'),
(2, 2, 1, 'Чат для нормальной переписки', '2021-01-08 15:31:50', NULL, '2021-01-08 15:31:50'),
(3, 1, 1, 'ТЕСТОВЫЙ ЧАТ', '2021-01-08 15:32:42', NULL, '2021-01-08 15:32:42'),
(4, 1, 5, 'Понял', '2021-01-08 15:36:10', NULL, '2021-01-08 15:36:10'),
(5, 2, 5, 'Кароче, напишите сюда просто что-нибудь ради теста', '2021-01-08 15:39:26', NULL, '2021-01-08 15:39:26'),
(6, 1, 6, 'Йоу', '2021-01-08 18:39:21', NULL, '2021-01-08 18:39:21'),
(7, 2, 1, 'Дороу, lia 👽', '2021-01-08 18:39:34', NULL, '2021-01-08 18:39:34'),
(8, 2, 1, 'Оооооо, ты в чате', '2021-01-08 18:41:51', NULL, '2021-01-08 18:41:51'),
(9, 1, 1, 'Йоу', '2021-01-08 18:42:27', NULL, '2021-01-08 18:42:27'),
(10, 1, 1, '👽👽👽👽', '2021-01-08 18:42:32', NULL, '2021-01-08 18:42:32'),
(11, 1, 1, 'sadasd', '2021-01-10 18:15:02', NULL, '2021-01-10 18:15:02');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(26, '2021_01_10_205849_create_chat_private_channels_table', 1),
(27, '2021_01_10_173937_create_chat_private_messages_table', 2),
(28, '2021_01_11_173107_create_chat_privates_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ryk', 'ryk', '$2y$10$aU.wLdG/mGNC4omPEKaO0uZE38FJ0hC1v3uxP0SGXIGNX/BwUrbae', '85Dqqj3cqHolAOq1wikLF9AcpNMRWXhk5fPjPaXB4WvXGlFHTpXSl1C2YCvR', '2021-01-04 11:55:25', '2021-01-04 11:55:25'),
(3, 'Veeryliu', 'Veeryliu', '$2y$10$wy3qdP6Y7O2HpEXNcKfa8.jaPhOz872Wn70S8g42hgZ.bwgc/bqg.', NULL, '2021-01-04 19:56:48', '2021-01-04 19:56:48'),
(4, 'un1xs', 'un1xs', '$2y$10$mQZ1aovWnFJRlDvGDbX4repgII1A/fGuz5P.ngF0Rzh2B8p65aysq', NULL, '2021-01-05 07:00:38', '2021-01-05 07:00:38'),
(5, 'root', 'root', '$2y$10$4hl1QAxDZda83ruhFjAf9ewgnzFL2Z1UxJ5H7IDjn4wTm5XoBZNyy', NULL, '2021-01-05 14:53:32', '2021-01-05 14:53:32'),
(6, 'Liia', 'Liia', '$2y$10$gt6MvROQ1lIddpFW0lcdKui0xmL.vAoKI2xMpBBZSVigvFPVvkqYC', NULL, '2021-01-08 18:38:01', '2021-01-08 18:38:01');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chat_privates`
--
ALTER TABLE `chat_privates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_privates_user_id_foreign` (`user_id`),
  ADD KEY `chat_privates_user_2_foreign` (`user_2`),
  ADD KEY `chat_privates_channel_id_foreign` (`channel_id`);

--
-- Индексы таблицы `chat_private_channels`
--
ALTER TABLE `chat_private_channels`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_private_messages`
--
ALTER TABLE `chat_private_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_private_messages_channel_id_foreign` (`channel_id`),
  ADD KEY `chat_private_messages_user_id_foreign` (`user_id`),
  ADD KEY `chat_private_messages_user_2_foreign` (`user_2`);

--
-- Индексы таблицы `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_room_members`
--
ALTER TABLE `chat_room_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_room_members_user_id_foreign` (`user_id`),
  ADD KEY `chat_room_members_chat_room_id_foreign` (`chat_room_id`);

--
-- Индексы таблицы `chat_room_messages`
--
ALTER TABLE `chat_room_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_room_messages_chat_room_id_foreign` (`chat_room_id`),
  ADD KEY `chat_room_messages_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_login_index` (`login`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chat_privates`
--
ALTER TABLE `chat_privates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `chat_private_channels`
--
ALTER TABLE `chat_private_channels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `chat_private_messages`
--
ALTER TABLE `chat_private_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `chat_room_members`
--
ALTER TABLE `chat_room_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `chat_room_messages`
--
ALTER TABLE `chat_room_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `chat_privates`
--
ALTER TABLE `chat_privates`
  ADD CONSTRAINT `chat_privates_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `chat_private_channels` (`id`),
  ADD CONSTRAINT `chat_privates_user_2_foreign` FOREIGN KEY (`user_2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chat_privates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `chat_private_messages`
--
ALTER TABLE `chat_private_messages`
  ADD CONSTRAINT `chat_private_messages_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `chat_private_channels` (`id`),
  ADD CONSTRAINT `chat_private_messages_user_2_foreign` FOREIGN KEY (`user_2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chat_private_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `chat_room_members`
--
ALTER TABLE `chat_room_members`
  ADD CONSTRAINT `chat_room_members_chat_room_id_foreign` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`),
  ADD CONSTRAINT `chat_room_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `chat_room_messages`
--
ALTER TABLE `chat_room_messages`
  ADD CONSTRAINT `chat_room_messages_chat_room_id_foreign` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`),
  ADD CONSTRAINT `chat_room_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
