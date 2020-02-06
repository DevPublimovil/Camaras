-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-01-2020 a las 07:11:58
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mediacam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pantallas` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `abbreviation`, `image`, `pantallas`, `created_at`, `updated_at`) VALUES
(1, 'El Salvador', 'SV', 'images/sv.png', 40, NULL, NULL),
(2, 'Guatemala', 'GT', 'images/gt.png', 18, NULL, NULL),
(3, 'Costa Rica', 'CR', 'images/cr.png', 0, NULL, NULL),
(4, 'Honduras', 'HN', 'images/hn.png', 12, NULL, NULL),
(5, 'Panama', 'PAN', 'images/pn.png', 0, NULL, NULL),
(6, 'Nicaragua', 'NI', 'images/nc.png', 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `browse` tinyint(1) NOT NULL DEFAULT 1,
  `read` tinyint(1) NOT NULL DEFAULT 1,
  `edit` tinyint(1) NOT NULL DEFAULT 1,
  `add` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 1,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(2, 1, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, NULL, 3),
(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, NULL, 4),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, NULL, 5),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 6),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(8, 1, 'avatar', 'image', 'Avatar', 0, 1, 1, 1, 1, 1, NULL, 8),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":0}', 10),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 11),
(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, NULL, 12),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, '{}', 5),
(21, 1, 'role_id', 'text', 'Role', 1, 1, 1, 1, 1, 1, NULL, 9),
(22, 4, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(23, 4, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(25, 4, 'image', 'image', 'Image', 1, 1, 1, 1, 1, 1, '{}', 4),
(26, 4, 'location', 'text', 'Location', 0, 1, 1, 1, 1, 1, '{}', 5),
(27, 4, 'status', 'text', 'Status', 0, 1, 1, 1, 1, 1, '{}', 6),
(29, 4, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 8),
(30, 4, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
(31, 4, 'pantalla_hasone_country_relationship', 'relationship', 'countries', 0, 0, 1, 1, 1, 1, '{\"model\":\"App\\\\Country\",\"table\":\"countries\",\"type\":\"belongsTo\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"countries\",\"pivot\":\"0\",\"taggable\":\"0\"}', 10),
(32, 4, 'link', 'text', 'Link', 1, 0, 1, 1, 1, 1, '{}', 3),
(42, 7, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(43, 7, 'user_id', 'text', 'User Id', 1, 0, 0, 0, 1, 0, '{}', 2),
(44, 7, 'pantalla_id', 'text', 'Pantalla Id', 1, 0, 0, 0, 1, 0, '{}', 3),
(45, 7, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 4),
(46, 7, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
(47, 7, 'pantalla_cliente_hasmany_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"countries\",\"pivot\":\"0\",\"taggable\":\"0\"}', 6),
(48, 7, 'pantalla_cliente_hasmany_pantalla_relationship', 'relationship', 'pantallas', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Pantalla\",\"table\":\"pantallas\",\"type\":\"belongsTo\",\"column\":\"pantalla_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"countries\",\"pivot\":\"0\",\"taggable\":\"0\"}', 7),
(49, 8, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(50, 8, 'key', 'text', 'Key', 1, 1, 1, 1, 1, 1, '{}', 2),
(51, 8, 'table_name', 'text', 'Table Name', 0, 1, 1, 1, 1, 1, '{}', 3),
(52, 8, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 4),
(53, 8, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
(54, 4, 'country_id', 'text', 'Country Id', 1, 1, 1, 1, 1, 1, '{}', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_types`
--

CREATE TABLE `data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT 0,
  `server_side` tinyint(4) NOT NULL DEFAULT 0,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', '', 1, 0, NULL, '2020-01-18 10:42:38', '2020-01-18 10:42:38'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2020-01-18 10:42:38', '2020-01-18 10:42:38'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2020-01-18 10:42:38', '2020-01-25 02:54:52'),
(4, 'pantallas', 'pantallas', 'Pantalla', 'Pantallas', 'voyager-tv', 'App\\Pantalla', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2020-01-20 07:51:44', '2020-01-26 22:29:04'),
(7, 'pantalla_clientes', 'pantalla-clientes', 'Pantalla Cliente', 'Pantalla Clientes', NULL, 'App\\PantallaCliente', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2020-01-26 13:17:27', '2020-01-26 21:25:09'),
(8, 'permissions', 'permissions', 'Permission', 'Permissions', 'voyager-key', 'TCG\\Voyager\\Models\\Permission', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2020-01-26 21:30:18', '2020-01-26 21:30:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2020-01-18 10:42:40', '2020-01-18 10:42:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(2, 1, 'Media', '', '_self', 'voyager-images', '#ff5b0d', NULL, 6, '2020-01-18 10:42:40', '2020-01-26 22:30:51', 'voyager.media.index', 'null'),
(3, 1, 'Users', '', '_self', 'voyager-person', '#ff6b24', NULL, 5, '2020-01-18 10:42:40', '2020-01-26 22:30:51', 'voyager.users.index', 'null'),
(4, 1, 'Roles', '', '_self', 'voyager-lock', '#ff5b0d', NULL, 4, '2020-01-18 10:42:41', '2020-01-26 22:30:51', 'voyager.roles.index', 'null'),
(5, 1, 'Tools', '', '_self', 'voyager-tools', '#ff5f11', NULL, 7, '2020-01-18 10:42:41', '2020-01-26 22:30:51', NULL, ''),
(6, 1, 'Menu Builder', '', '_self', 'voyager-list', '#ff6f28', 5, 1, '2020-01-18 10:42:41', '2020-01-20 09:41:46', 'voyager.menus.index', 'null'),
(7, 1, 'Database', '', '_self', 'voyager-data', '#ff5c0f', 5, 2, '2020-01-18 10:42:41', '2020-01-20 09:42:00', 'voyager.database.index', 'null'),
(8, 1, 'Compass', '', '_self', 'voyager-compass', '#ff5c0f', 5, 3, '2020-01-18 10:42:41', '2020-01-20 09:42:12', 'voyager.compass.index', 'null'),
(9, 1, 'BREAD', '', '_self', 'voyager-bread', '#ff6317', 5, 4, '2020-01-18 10:42:41', '2020-01-20 09:42:39', 'voyager.bread.index', 'null'),
(10, 1, 'Settings', '', '_self', 'voyager-settings', '#ff5c0f', NULL, 8, '2020-01-18 10:42:41', '2020-01-26 22:30:51', 'voyager.settings.index', 'null'),
(11, 1, 'Hooks', '', '_self', 'voyager-hook', '#ff641a', 5, 5, '2020-01-18 10:42:45', '2020-01-20 09:42:53', 'voyager.hooks', 'null'),
(12, 1, 'Pantallas', '', '_self', 'voyager-tv', '#ff5b0d', NULL, 1, '2020-01-20 07:51:45', '2020-01-20 09:46:20', 'voyager.pantallas.index', 'null'),
(14, 1, 'Ventas', '', '_self', 'voyager-play', '#ff712d', NULL, 3, '2020-01-26 13:17:27', '2020-01-26 22:30:51', 'voyager.pantalla-clientes.index', 'null'),
(15, 1, 'Permissions', '', '_self', 'voyager-key', '#ff7b3c', NULL, 9, '2020-01-26 21:30:18', '2020-01-26 22:30:51', 'voyager.permissions.index', 'null'),
(16, 1, 'Camaras', 'mediacam/clients', '_self', 'voyager-video', '#ff702b', NULL, 2, '2020-01-26 22:30:28', '2020-01-26 22:32:50', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_01_000000_add_voyager_user_fields', 1),
(4, '2016_01_01_000000_create_data_types_table', 1),
(5, '2016_05_19_173453_create_menu_table', 1),
(6, '2016_10_21_190000_create_roles_table', 1),
(7, '2016_10_21_190000_create_settings_table', 1),
(8, '2016_11_30_135954_create_permission_table', 1),
(9, '2016_11_30_141208_create_permission_role_table', 1),
(10, '2016_12_26_201236_data_types__add__server_side', 1),
(11, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(12, '2017_01_14_005015_create_translations_table', 1),
(13, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(14, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(15, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(16, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(17, '2017_08_05_000000_add_group_to_settings_table', 1),
(18, '2017_11_26_013050_add_user_role_relationship', 1),
(19, '2017_11_26_015000_create_user_roles_table', 1),
(20, '2018_03_11_000000_add_user_settings', 1),
(21, '2018_03_14_000000_add_details_to_data_types_table', 1),
(22, '2018_03_16_000000_make_settings_value_nullable', 1),
(23, '2019_08_19_000000_create_failed_jobs_table', 1),
(24, '2020_01_20_014454_create_pantallas_table', 2),
(25, '2020_01_20_015501_create_constries_table', 3),
(26, '2020_01_20_020541_create_countries_table', 4),
(27, '2020_01_20_144845_create_pantalla_clientes_table', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pantallas`
--

CREATE TABLE `pantallas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT 'disponible',
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pantallas`
--

INSERT INTO `pantallas` (`id`, `name`, `link`, `image`, `location`, `status`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Pantalla 75 Av. Norte', 'https://g1.ipcamlive.com/player/player.php?alias=pantalla75av', 'pantallas\\January2020\\MbPgiGVGS4a0BJeTjXf9.png', 'ssss', 'disponible', 1, '2020-01-26 23:56:30', '2020-01-26 23:56:30'),
(2, 'Pantalla Frente a Monumento El Salvador del Mundo', 'https://g1.ipcamlive.com/player/player.php?alias=salvadordelmundo', 'pantallas\\January2020\\2PsHT73t4g4JjmdNZfFN.png', NULL, 'disponible', 1, '2020-01-26 23:59:13', '2020-01-26 23:59:13'),
(3, 'Pantalla hacia Hermano Lejano', 'https://g1.ipcamlive.com/player/player.php?alias=hermano', 'pantallas\\January2020\\k7lTpFAYlt5bZOxeRv4W.png', NULL, 'disponible', 1, '2020-01-27 00:01:58', '2020-01-27 12:07:31'),
(4, 'Pantalla Jerusalén, hacia Multiplaza', 'https://g1.ipcamlive.com/player/player.php?alias=pantallajerusalemamultiplaza', 'pantallas\\January2020\\CzgEbuHIr30zXrouqWqA.png', NULL, 'disponible', 1, '2020-01-27 00:03:48', '2020-01-27 00:03:48'),
(5, 'Pantalla  Jerusalén, hacia Redondel Masferrer', 'https://g1.ipcamlive.com/player/player.php?alias=jerusalemamasferrer', 'pantallas\\January2020\\JcRDS8K3AtGgx8stJ6HP.png', NULL, 'disponible', 1, '2020-01-27 00:05:07', '2020-01-27 00:05:07'),
(6, 'Pantalla 49 Avenida Sur frente a Autocentro', 'https://g1.ipcamlive.com/player/player.php?alias=autocentro', 'pantallas\\January2020\\L38HnVduwJXWgD8hKd2X.png', NULL, 'disponible', 1, '2020-01-27 00:06:13', '2020-01-27 00:06:13'),
(7, 'Pantalla Av. Masferrer Norte, hacia Redondel Luceiro', 'https://g1.ipcamlive.com/player/player.php?alias=masferrernorte', 'pantallas\\January2020\\vscv2VsuRyBTYgwg9EZe.png', NULL, 'disponible', 1, '2020-01-27 00:07:21', '2020-01-27 00:07:21'),
(8, 'Pantalla Blvd. Los Próceres fte a Torre Cuscatlán', 'https://g1.ipcamlive.com/player/player.php?alias=pantallablvdlosprocerestorrecusc', 'pantallas\\January2020\\YsDerAeLD0ZXkWp5qI7w.png', NULL, 'disponible', 1, '2020-01-27 00:08:26', '2020-01-27 00:08:26'),
(9, 'Pantalla Blvd. Los Próceres hacia Monumento Hermano Lejano', 'https://g1.ipcamlive.com/player/player.php?alias=pantallalosproceresasansalvador', 'pantallas\\January2020\\ZI4uJFc9R2B0nI7pjpal.png', NULL, 'disponible', 1, '2020-01-27 00:11:05', '2020-01-27 00:11:05'),
(10, 'Pantalla Blvd. de Los Héroes, fte. A China Wok', 'https://g1.ipcamlive.com/player/player.php?alias=chinawok', 'pantallas\\January2020\\aIx09CQlZYOKOVJETRED.png', NULL, 'disponible', 1, '2020-01-27 00:16:21', '2020-01-27 00:16:21'),
(11, 'Pantalla Calle Chiltiupan hacia Redondel Platillo', 'https://g1.ipcamlive.com/player/player.php?alias=pantallacallechiltiupanrotondael', 'pantallas\\January2020\\gVfU3dG0V91z6hab4RwN.png', NULL, 'disponible', 1, '2020-01-27 00:19:05', '2020-01-27 00:19:05'),
(12, 'Pantalla Fte. A Plaza Merliot', 'https://g1.ipcamlive.com/player/player.php?alias=pantallacallechiltiupanplazamerl', 'pantallas\\January2020\\GFDtOpoaYOWewfYAXp6U.png', NULL, 'disponible', 1, '2020-01-27 00:19:51', '2020-01-27 00:19:51'),
(13, 'Pantalla Carretera Panamericana fte a Gran  Vía', 'https://g1.ipcamlive.com/player/player.php?alias=pantallacarreterapanamericalagra', 'pantallas\\January2020\\vc5p7PkvF1Itx6osw6mY.png', NULL, 'disponible', 1, '2020-01-27 00:21:03', '2020-01-27 00:21:03'),
(14, 'Pantalla Carretera Panamericana, frente a SISA', 'https://g1.ipcamlive.com/player/player.php?alias=pantallasisa', 'pantallas\\January2020\\oNFPVYdeS5SGyYRIw8XE.png', NULL, 'disponible', 1, '2020-01-27 00:22:02', '2020-01-27 00:22:02'),
(15, 'Pantalla Carretera Panamericana, Hacienda Real', 'https://g1.ipcamlive.com/player/player.php?alias=pantallacarreterapanamericahacie', 'pantallas\\January2020\\zorfZj0ZZGYUyFCrheHa.png', NULL, 'disponible', 1, '2020-01-27 00:22:47', '2020-01-27 00:22:47'),
(16, 'Pantalla CC El Paseo,  hacía Salvador del Mundo', 'https://g1.ipcamlive.com/player/player.php?alias=pantallapaseo2', 'pantallas\\January2020\\Eu7dLEsnKgfkL7jcdZIg.png', NULL, 'disponible', 1, '2020-01-27 00:23:57', '2020-01-27 00:23:57'),
(17, 'Pantalla CC El Paseo, hacía Redondel Masferrer', 'https://g1.ipcamlive.com/player/player.php?alias=pantallacuracaopaseo', 'pantallas\\January2020\\pDJMW18PPjUsL5HLRJfM.png', NULL, 'disponible', 1, '2020-01-27 00:25:15', '2020-01-27 00:25:15'),
(18, 'Pantalla Blvd Orden de Malta, Fte. a Plaza Malta', 'https://g1.ipcamlive.com/player/player.php?alias=ordendemalta', 'pantallas\\January2020\\EkbDKHlX7gHe5lvq4Zlu.png', NULL, 'disponible', 1, '2020-01-27 00:25:53', '2020-01-27 00:25:53'),
(19, 'Pantalla frente a Ceiba de Guadalupe hacia CIFCO', 'https://g1.ipcamlive.com/player/player.php?alias=laceiba', 'pantallas\\January2020\\TMh4odLC4r5WiROrJBSa.png', NULL, 'disponible', 1, '2020-01-27 00:27:05', '2020-01-27 00:27:05'),
(20, 'Pantalla Paseo General Escalón Fte. a Colegio Sagrada Familia', 'https://g1.ipcamlive.com/player/player.php?alias=pantallapaseogeneralescalonsagra', 'pantallas\\January2020\\P9A9PdNspWxquLgZvB0A.png', NULL, 'disponible', 1, '2020-01-27 00:28:04', '2020-01-27 00:28:04'),
(21, 'Pantalla Fte UFG', 'https://g1.ipcamlive.com/player/player.php?alias=pantallaufg', 'pantallas\\January2020\\3vpQVbLC38DiwHxZTC9M.png', NULL, 'disponible', 1, '2020-01-27 00:29:17', '2020-01-27 00:29:17'),
(22, 'Pantalla Carretera Panamericana Fte a CC Feria Rosa', 'https://g1.ipcamlive.com/player/player.php?alias=pantallacarreterapanamericanafer', 'pantallas\\January2020\\SRUX8odH2wN4ykvyNXx1.png', NULL, 'disponible', 1, '2020-01-27 00:30:09', '2020-01-27 00:30:09'),
(23, 'Pantalla San Miguel Av. Roosevelt fte a Omnisport', 'https://g1.ipcamlive.com/player/player.php?alias=sanmiguel2', 'pantallas\\January2020\\98zTOSOEIei3fPcWu9lw.png', NULL, 'disponible', 1, '2020-01-27 00:31:39', '2020-01-27 00:31:39'),
(24, 'Pantalla Sonsonate contiguo a DIDELCO', 'https://g1.ipcamlive.com/player/player.php?alias=sonsonate', 'pantallas\\January2020\\PUKl0ozN3flyFzm2RnrA.png', NULL, 'disponible', 1, '2020-01-27 00:32:28', '2020-01-27 00:32:28'),
(25, 'Pantalla Alameda Manuel Enrique Araujo hacia San Salvador', 'https://g1.ipcamlive.com/player/player.php?alias=pantallacifcoasansalvador', 'pantallas\\January2020\\cT5vCWKRSxmN8CYyX0Ym.JPG', NULL, 'disponible', 1, '2020-01-27 00:33:26', '2020-01-27 00:33:26'),
(26, 'Pantalla Alameda Manuel Enrique Araujo hacia Santa Tecla', 'https://g1.ipcamlive.com/player/player.php?alias=pantallacifcoasantatecla', 'pantallas\\January2020\\0ANJnea5D3XA9oWtgJeg.png', NULL, 'disponible', 1, '2020-01-27 00:34:19', '2020-01-27 00:34:19'),
(27, 'Pantalla Blvd El Hipódromo Zona Rosa', 'https://g3.ipcamlive.com/player/player.php?alias=zonarosa', 'pantallas\\January2020\\0nPz5CnVJN0piIUckXwA.jpg', NULL, 'disponible', 1, '2020-01-27 00:38:16', '2020-01-27 00:38:16'),
(28, 'Pantalla Blvd. Los Héroes, frente a Metro Sur', 'https://g1.ipcamlive.com/player/player.php?alias=totemmetrocentro', 'pantallas\\January2020\\BXTrdFDUUQdbVHOnAcSn.png', NULL, 'disponible', 1, '2020-01-27 00:41:22', '2020-01-27 00:41:22'),
(29, 'Pantalla 49 Av. Sur fte a Estadio Mágico González', 'https://g1.ipcamlive.com/player/player.php?alias=pantalla49avnorteametrocentro', 'pantallas\\January2020\\w1HfxxtWjPyr2SJms6j5.png', NULL, 'disponible', 1, '2020-01-27 00:43:45', '2020-01-27 00:43:45'),
(30, 'Pantalla Alameda Juan Pablo II Fte Parque Infantil', 'https://g1.ipcamlive.com/player/player.php?alias=parqueinfantil', 'pantallas\\January2020\\TxIwlfVh6CQpHHIhGNBl.png', NULL, 'disponible', 1, '2020-01-27 00:44:27', '2020-01-27 00:44:27'),
(31, 'Pantalla Calle Antigua a Huizucar hacia Paso del Jaguar', 'https://g1.ipcamlive.com/player/player.php?alias=pantallalacima', 'pantallas\\January2020\\KeUysJulDZS0gQMv0UNZ.png', NULL, 'disponible', 1, '2020-01-27 00:46:37', '2020-01-27 00:46:37'),
(32, 'Pantalla Entrada principal a Santa Ana, frente a Metrocentro', 'https://g1.ipcamlive.com/player/player.php?alias=santaana', 'pantallas\\January2020\\VaTyS5tDbBooiUU2bhsh.png', NULL, 'disponible', 1, '2020-01-27 00:51:51', '2020-01-27 00:55:38'),
(35, 'Pantalla Av. Independencia, acera Metrocentro Santa Ana', 'https://g1.ipcamlive.com/player/player.php?alias=santaana2', 'pantallas\\January2020\\mBdTG9ogvh1nM6WZuNhX.png', NULL, 'disponible', 1, '2020-01-27 00:56:13', '2020-01-27 00:56:13'),
(36, 'Pantalla Blvd. del Ejército hacia Plaza Mundo', 'https://g1.ipcamlive.com/player/player.php?alias=pantallablvddelejercitosoyapango', 'pantallas\\January2020\\WuLdD7nZ1YFJ7VTlynIZ.png', NULL, 'disponible', 1, '2020-01-27 00:57:53', '2020-01-27 00:57:53'),
(37, 'Pantalla Carretera al Puerto de la Libertad Fte a CC La Joya', 'https://g1.ipcamlive.com/player/player.php?alias=lajoya', 'pantallas\\January2020\\iqSkpLWvxgmjFsVdswzA.png', NULL, 'disponible', 1, '2020-01-27 00:58:32', '2020-01-27 00:58:32'),
(38, 'Pantalla Masferrer Fte. A CC El Amate', 'https://g1.ipcamlive.com/player/player.php?alias=pantallaelamate', 'pantallas\\January2020\\h5XckayGWMtXuwiLNaAL.png', NULL, 'disponible', 1, '2020-01-27 00:59:20', '2020-01-27 00:59:20'),
(39, 'Pantalla Blvd. Constitución, La Gloria', 'https://g1.ipcamlive.com/player/player.php?alias=lagloria', 'pantallas\\January2020\\Fhid4lxSRUscwUGlLQ0c.png', NULL, 'disponible', 1, '2020-01-27 01:00:19', '2020-01-27 01:00:19'),
(40, 'Pantalla Fte. A Redondel Beethoven', 'https://g1.ipcamlive.com/player/player.php?alias=fuentesbethoven', 'pantallas\\January2020\\MM9w9UVWbBpd77sabDq0.png', NULL, 'disponible', 1, '2020-01-27 01:06:26', '2020-01-27 01:06:26'),
(41, 'Pantalla Blvd. Santa Elena hacia Embajada Americana', 'https://g1.ipcamlive.com/player/player.php?alias=santaelena', 'pantallas\\January2020\\l5pirJ7w9WU41nn2T3TS.png', NULL, 'disponible', 1, '2020-01-27 01:08:16', '2020-01-27 01:08:16'),
(42, 'Pantalla Blvd. Constitución', 'https://g1.ipcamlive.com/player/player.php?alias=pantallablvdconstitucion', 'pantallas\\January2020\\6BNsC8NbaJGrXXuXRhot.JPG', NULL, 'disponible', 1, '2020-01-27 01:09:05', '2020-01-27 01:09:05'),
(43, 'Pantalla Carretera Saliendo (KM 14 Carretera a El Salvador Saliendo de Guatemala)', 'http://ipcamlive.com/gtcarreteraasvsaliendo', 'pantallas\\January2020\\cCzBXLriJg9bhGelqcMH.JPG', NULL, 'disponible', 2, '2020-01-27 01:23:32', '2020-01-27 01:23:32'),
(44, 'Pantalla Carretera Entrando (KM 14 Carretera a El Salvador Entrando de Guatemala)', 'http://ipcamlive.com/gtcarretessventrando', 'pantallas\\January2020\\P01UVOwSSyZKAwiUuSNP.JPG', NULL, 'disponible', 2, '2020-01-27 01:35:50', '2020-01-27 01:35:58'),
(45, 'Pantalla Roosevelt Saliendo (Calzada Roosevelt Entrando a Mixco y Saliendo de Guatemala)', 'http://ipcamlive.com/gtcalzadarooseveltmixco', 'pantallas\\January2020\\JgjnIscNRKPAululJWsy.JPG', NULL, 'disponible', 2, '2020-01-27 01:37:00', '2020-01-27 01:37:00'),
(46, 'Pantalla Roosevelt Entrando (Calzada Roosevelt Entrando a Guatemala)', 'http://ipcamlive.com/gtcalzadarooseveltgt', 'pantallas\\January2020\\Rg4PpGRrs1qUAV1vl2VE.JPG', NULL, 'disponible', 2, '2020-01-27 01:38:15', '2020-01-27 01:38:15'),
(47, 'Pantalla Javier (Saliendo de Guatemala, Calzada Aguilar Batres y 39 Calle Zona 12)', 'http://ipcamlive.com/gtestacionjavier', 'pantallas\\January2020\\gWMThVG1dFIsZh3BZ5FW.JPG', NULL, 'disponible', 2, '2020-01-27 01:39:05', '2020-01-27 01:39:05'),
(48, 'Pantalla Montemaria (Entrando de Guatemala, Calzada Aguilar Batres)', 'http://ipcamlive.com/gtpantallamontemaria', 'pantallas\\January2020\\gx0mPJg7N9CFHOSsiaMC.JPG', NULL, 'disponible', 2, '2020-01-27 01:40:01', '2020-01-27 01:40:01'),
(49, 'Pantalla Boca Del Monte (Saliendo de Guatemala, 1Ave. 2 Calle Boca Del Monte Zona 1)', 'http://ipcamlive.com/gtpantallabocadelmonte', 'pantallas\\January2020\\NLXtlfxfxA1W35WhwhW1.JPG', NULL, 'disponible', 2, '2020-01-27 01:40:42', '2020-01-27 01:40:42'),
(50, 'Pantalla Frutal Saliendo (Bulevar El Frutal 14-00 zona 5 Villa Nueva C.C. El Frutal)', 'http://ipcamlive.com/gtelfrutala', 'pantallas\\January2020\\DNaj2a2pzFpiEoSTQOcz.JPG', NULL, 'disponible', 2, '2020-01-27 01:41:32', '2020-01-27 01:41:32'),
(51, 'Pantalla Trebol (Estación Transmetro Trebol Gradas Centrales )', 'http://ipcamlive.com/gtestacioneltrebol', 'pantallas\\January2020\\orIS9xPG2Edjuaf5obGP.JPG', NULL, 'disponible', 2, '2020-01-27 01:42:05', '2020-01-27 01:42:05'),
(52, 'Pantalla Mazatenango (Centro Comercial Pradera Mazatenango)', 'http://ipcamlive.com/camaramazate', 'pantallas\\January2020\\1mgk4U2QYGpMYFJe0kk7.jpg', NULL, 'disponible', 2, '2020-01-27 01:42:40', '2020-01-27 01:42:40'),
(53, 'Pantalla San Juan Saliendo (Calzada San Juan Colonia El Rodeo hacia C.C. Monserrat)', 'http://ipcamlive.com/gtsanjuanamixco', 'pantallas\\January2020\\Nnb3YmuDsltLzLDbR0gj.JPG', NULL, 'disponible', 2, '2020-01-27 01:43:15', '2020-01-27 01:43:15'),
(54, 'Pantalla San Juan Entrando (Calzada San Juan Colonia El Rodeo hacia el trebol)', 'http://ipcamlive.com/gtsanjuanaguatemala', 'pantallas\\January2020\\xs4IEl09mie3WclVeYyY.JPG', NULL, 'disponible', 2, '2020-01-27 01:43:58', '2020-01-27 01:43:58'),
(55, 'Pantalla San Cristobal Saliendo Fte a C.C. Mix, Ruta hacia Antigua Guatemala', 'http://ipcamlive.com/gtsancristobalsaliendo', 'pantallas\\January2020\\mV2Xr9PzFf5QrEtEngSR.jpg', NULL, 'disponible', 2, '2020-01-27 01:45:28', '2020-01-27 01:45:28'),
(56, 'Pantalla San Cristobal Entrando Fte a C.C. Mix, Ruta hacia el Blvd Principal', 'http://ipcamlive.com/gtsancristobalentrando', 'pantallas\\January2020\\NG5po9UbdokF1cBHRkHb.jpg', NULL, 'disponible', 2, '2020-01-27 01:46:00', '2020-01-27 01:46:00'),
(57, 'Pantalla Totem Pasaje Naranjo', 'http://ipcamlive.com/totemnaranjo', 'pantallas\\January2020\\B77kgb9EVASCel0vIG4q.JPG', NULL, 'disponible', 2, '2020-01-27 01:46:42', '2020-01-27 01:46:42'),
(58, 'Pantalla Totem Portales B', 'http://ipcamlive.com/portalesb', 'pantallas\\January2020\\Y1lSKJq2Rgq8E2YTz8AY.jpg', NULL, 'disponible', 2, '2020-01-27 01:47:17', '2020-01-27 01:47:17'),
(59, 'Pantalla Totem Portales A', 'http://ipcamlive.com/portalesa', 'pantallas\\January2020\\ppcfVU8IEBAKXIdnnHZM.jpg', NULL, 'disponible', 2, '2020-01-27 01:47:56', '2020-01-27 01:47:56'),
(60, 'Pantalla Centro Comercial Pradera', 'http://ipcamlive.com/pradera', 'pantallas\\January2020\\gbqbUsqRujd83TZfyc8J.jpg', NULL, 'disponible', 2, '2020-01-27 01:48:39', '2020-01-27 01:48:39'),
(61, 'Pantalla en Plaza Miraflores, Blvd C.A. Tegucigalpa', 'http://ipcamlive.com/hnmiraflores', 'pantallas\\January2020\\1uq7RQjCStKBm6YDpTX7.jpg', NULL, 'disponible', 4, '2020-01-27 01:52:09', '2020-01-27 01:52:09'),
(62, 'Pantalla Fte a Mega Larach, Colonia el Prado. Tegucigalpa', 'http://ipcamlive.com/hnlarach', 'pantallas\\January2020\\8CfLXT8UUvCe1QycaGjO.jpg', NULL, 'disponible', 4, '2020-01-27 01:52:48', '2020-01-27 01:52:48'),
(63, 'Pantalla El Patio. Tegucigalpa', 'http://ipcamlive.com/hnelpatio', 'pantallas\\January2020\\yPuH1kEcWsi1HTscR1Xi.JPG', NULL, 'disponible', 4, '2020-01-27 01:53:25', '2020-01-27 01:53:25'),
(64, 'Pantalla Boulevard del Sur, Puente Peatonal de La Gran Central de Buses, San Pedro Sula', 'http://ipcamlive.com/grancentral', 'pantallas\\January2020\\PbVVOMMp2Q4oUrHfh6GW.jpg', NULL, 'disponible', 4, '2020-01-27 01:54:01', '2020-01-27 01:54:01'),
(65, 'Pantalla Antojitos Mexicanos (Circunvalación), San Pedro Sula', 'http://ipcamlive.com/antojito', 'pantallas\\January2020\\2XToIWADROwae3mJkHQo.jpg', NULL, 'disponible', 4, '2020-01-27 01:54:39', '2020-01-27 01:54:39'),
(66, 'Pantalla 105 Brigada (Boulevard del Norte, Agencia Bancatlan), San Pedro Sula', 'http://ipcamlive.com/brigada105', 'pantallas\\January2020\\XMYWGZ6wcUZuFjtqVAg2.jpg', NULL, 'disponible', 4, '2020-01-27 01:55:16', '2020-01-27 01:55:16'),
(67, 'Pantalla El Ahorro (Boulevard Morazan, Farmacia El Ahorro), Tegucigalpa', 'http://ipcamlive.com/hnelahorro', 'pantallas\\January2020\\GeTX8e6QZq6IW8eCtHOC.jpg', NULL, 'disponible', 4, '2020-01-27 01:55:50', '2020-01-27 01:55:50'),
(68, 'Pantalla Megaplaza (Boulevard del Este, Frente a Mall Megaplaza), San Pedro Sula', 'http://ipcamlive.com/megaplaza', 'pantallas\\January2020\\qWFGB4vt0tiRjL1PvVzz.jpg', NULL, 'disponible', 4, '2020-01-27 01:56:17', '2020-01-27 01:56:17'),
(69, 'Pantalla Multiplaza (Boulevard del sur, Frente a Mall Multiplaza), San Pedro Sula', 'http://ipcamlive.com/multiplaza', 'pantallas\\January2020\\vEpsaV340Loc5bZalbNC.jpg', NULL, 'disponible', 4, '2020-01-27 01:56:49', '2020-01-27 01:56:49'),
(70, 'Pantalla Kielsa 105 (AV. Circunvalación, redondel 105 brigada), San Pedro Sula', 'http://ipcamlive.com/camarahnkielsa', 'pantallas\\January2020\\qsUQ1SPZxEvBn2lmiDa6.jpg', NULL, 'disponible', 4, '2020-01-27 01:57:22', '2020-01-27 01:57:22'),
(71, 'Pantalla Puma Jr (AV. Circunvalación, AV. Junior), San Pedro Sula', 'http://ipcamlive.com/camarapumajr', 'pantallas\\January2020\\cKh7jp1aP4g9XsCADtxp.jpg', NULL, 'disponible', 4, '2020-01-27 01:57:58', '2020-01-27 01:57:58'),
(72, 'Pantalla Galerias del Valle (Blvd Michelleti, Blvd Jardines del Valle), San Pedro Sula', 'http://ipcamlive.com/hngaleria', 'pantallas\\January2020\\7p1wGG8TsgAHxrnjphkQ.jpg', NULL, 'disponible', 4, '2020-01-27 01:58:30', '2020-01-27 01:58:30'),
(73, 'Pantalla Curacao Matagalpa', 'http://ipcamlive.com/matagalpani', 'pantallas\\January2020\\GqZhvBnkEJxP4GEdLI1Y.jpg', NULL, 'disponible', 6, '2020-01-27 01:59:35', '2020-01-27 01:59:35'),
(74, 'Pantalla UNO Esquipulas Esteli', 'http://ipcamlive.com/estelini', 'pantallas\\January2020\\YYYetU5MaRLuZG4uj08L.jpg', NULL, 'disponible', 6, '2020-01-27 02:00:50', '2020-01-27 02:00:50'),
(75, 'Pantalla Paso Desnivel Portezuelo', 'http://ipcamlive.com/portezueloni', 'pantallas\\January2020\\w4JUkm9czAcsGJYb1fSI.jpg', NULL, 'disponible', 6, '2020-01-27 02:01:20', '2020-01-27 02:01:20'),
(76, 'Pantalla Rotonda Fuerza Aerea', 'http://ipcamlive.com/fuerzaaereani', 'pantallas\\January2020\\1KpBCJWRhP3jCMtPop1i.jpg', NULL, 'disponible', 6, '2020-01-27 02:01:52', '2020-01-27 02:01:52'),
(77, 'Pantalla UNO Los Encuentros Chinandega', 'http://ipcamlive.com/chinandegani', 'pantallas\\January2020\\gc7VV4kMl4U1IzjlO73G.jpg', NULL, 'disponible', 6, '2020-01-27 02:02:25', '2020-01-27 02:02:25'),
(78, 'Pantalla Puma Granada', 'http://ipcamlive.com/granadani', 'pantallas\\January2020\\ltGx9Qm2cOcwVYkSTTcg.jpg', NULL, 'disponible', 6, '2020-01-27 02:03:17', '2020-01-27 02:03:17'),
(79, 'Pantalla Rotonda Centroamerica', 'http://ipcamlive.com/centroamericani', 'pantallas\\January2020\\I7VLVdi0GePGdBdH4o8x.jpg', NULL, 'disponible', 6, '2020-01-27 02:03:44', '2020-01-27 02:03:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pantalla_clientes`
--

CREATE TABLE `pantalla_clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pantalla_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2020-01-18 10:42:41', '2020-01-18 10:42:41'),
(2, 'browse_bread', NULL, '2020-01-18 10:42:41', '2020-01-18 10:42:41'),
(3, 'browse_database', NULL, '2020-01-18 10:42:41', '2020-01-18 10:42:41'),
(4, 'browse_media', NULL, '2020-01-18 10:42:41', '2020-01-18 10:42:41'),
(5, 'browse_compass', NULL, '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(6, 'browse_menus', 'menus', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(7, 'read_menus', 'menus', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(8, 'edit_menus', 'menus', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(9, 'add_menus', 'menus', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(10, 'delete_menus', 'menus', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(11, 'browse_roles', 'roles', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(12, 'read_roles', 'roles', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(13, 'edit_roles', 'roles', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(14, 'add_roles', 'roles', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(15, 'delete_roles', 'roles', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(16, 'browse_users', 'users', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(17, 'read_users', 'users', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(18, 'edit_users', 'users', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(19, 'add_users', 'users', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(20, 'delete_users', 'users', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(21, 'browse_settings', 'settings', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(22, 'read_settings', 'settings', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(23, 'edit_settings', 'settings', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(24, 'add_settings', 'settings', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(25, 'delete_settings', 'settings', '2020-01-18 10:42:42', '2020-01-18 10:42:42'),
(26, 'browse_hooks', NULL, '2020-01-18 10:42:45', '2020-01-18 10:42:45'),
(27, 'browse_pantallas', 'pantallas', '2020-01-20 07:51:44', '2020-01-20 07:51:44'),
(28, 'read_pantallas', 'pantallas', '2020-01-20 07:51:44', '2020-01-20 07:51:44'),
(29, 'edit_pantallas', 'pantallas', '2020-01-20 07:51:44', '2020-01-20 07:51:44'),
(30, 'add_pantallas', 'pantallas', '2020-01-20 07:51:44', '2020-01-20 07:51:44'),
(31, 'delete_pantallas', 'pantallas', '2020-01-20 07:51:45', '2020-01-20 07:51:45'),
(37, 'list_clients', 'users', NULL, NULL),
(38, 'store_clients', 'users', NULL, NULL),
(39, 'view_cameras', 'pantallas', NULL, NULL),
(40, 'browse_pantalla_clientes', 'pantalla_clientes', '2020-01-26 13:17:27', '2020-01-26 13:17:27'),
(41, 'read_pantalla_clientes', 'pantalla_clientes', '2020-01-26 13:17:27', '2020-01-26 13:17:27'),
(42, 'edit_pantalla_clientes', 'pantalla_clientes', '2020-01-26 13:17:27', '2020-01-26 13:17:27'),
(43, 'add_pantalla_clientes', 'pantalla_clientes', '2020-01-26 13:17:27', '2020-01-26 13:17:27'),
(44, 'delete_pantalla_clientes', 'pantalla_clientes', '2020-01-26 13:17:27', '2020-01-26 13:17:27'),
(45, 'browse_permissions', 'permissions', '2020-01-26 21:30:18', '2020-01-26 21:30:18'),
(46, 'read_permissions', 'permissions', '2020-01-26 21:30:18', '2020-01-26 21:30:18'),
(47, 'edit_permissions', 'permissions', '2020-01-26 21:30:18', '2020-01-26 21:30:18'),
(48, 'add_permissions', 'permissions', '2020-01-26 21:30:18', '2020-01-26 21:30:18'),
(49, 'delete_permissions', 'permissions', '2020-01-26 21:30:18', '2020-01-26 21:30:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(37, 4),
(38, 4),
(39, 1),
(39, 3),
(39, 4),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2020-01-18 10:42:41', '2020-01-18 10:42:41'),
(2, 'user', 'Normal User', '2020-01-18 10:42:41', '2020-01-18 10:52:12'),
(3, 'cliente', 'Cliente', '2020-01-20 08:58:09', '2020-01-20 08:58:09'),
(4, 'trafico', 'Trafico', '2020-01-20 09:47:23', '2020-01-20 09:47:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Site Title', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Site Description', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', '', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', '', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'mediacam', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Welcome to Voyager. The Missing Admin for Laravel', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', '', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', 'settings\\January2020\\aWZJeHxGn9VY76GhQBJU.png', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 1, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`, `country_id`, `status`, `fecha_fin`) VALUES
(1, 1, 'publimovil', 'jose@admin.com', 'users/default.png', NULL, '$2y$10$VJ.j0SZ6TvzT4J2aAqrPI.wwVqLg2S.2Z.jGSG/qXpl5lFBjJE52S', NULL, '{\"locale\":\"en\"}', '2020-01-18 10:47:30', '2020-01-20 10:10:39', 1, 'activo', NULL),
(2, 3, 'cliente', 'cliente@publimovil.com', 'users/default.png', NULL, '$2y$10$ttv3TMYcxi42BAgeQsz8Z.w.0I3k3zf0sdHzCh51sKkGiaNlHmqG2', NULL, '{\"locale\":\"en\"}', '2020-01-20 09:06:08', '2020-01-29 12:02:48', 1, 'activo', '2020-02-03'),
(5, 4, 'trafico', 'trafico@publimovil.com', 'users/default.png', NULL, '$2y$10$K7AQEASXBrdnh7g3idm55Ouh3YV1qmXLp3FlQmN6O9xP9PCHAZlnO', NULL, '{\"locale\":\"es\"}', '2020-01-20 09:48:19', '2020-01-29 12:00:48', 1, 'activo', NULL),
(11, 3, 'jose marvin', 'joseescobar@gmail.com', 'users/default.png', NULL, '$2y$10$vb9XrbEwdYK/oS6.VSdk6OdNOByQogzWYXd5J17pzELFIKfOiCAXq', NULL, NULL, '2020-01-29 12:06:24', '2020-01-29 12:06:24', 1, 'activo', '2020-02-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indices de la tabla `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indices de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pantallas`
--
ALTER TABLE `pantallas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pantallas_name_unique` (`name`),
  ADD UNIQUE KEY `pantallas_url_unique` (`link`),
  ADD KEY `pantallas_country_id_foreign` (`country_id`);

--
-- Indices de la tabla `pantalla_clientes`
--
ALTER TABLE `pantalla_clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pantalla_clientes_user_id_foreign` (`user_id`),
  ADD KEY `pantalla_clientes_pantalla_id_foreign` (`pantalla_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indices de la tabla `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_country_id_foreign` (`country_id`);

--
-- Indices de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_roles_user_id_index` (`user_id`),
  ADD KEY `user_roles_role_id_index` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `pantallas`
--
ALTER TABLE `pantallas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `pantalla_clientes`
--
ALTER TABLE `pantalla_clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `data_rows`
--
ALTER TABLE `data_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pantallas`
--
ALTER TABLE `pantallas`
  ADD CONSTRAINT `pantallas_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pantalla_clientes`
--
ALTER TABLE `pantalla_clientes`
  ADD CONSTRAINT `pantalla_clientes_pantalla_id_foreign` FOREIGN KEY (`pantalla_id`) REFERENCES `pantallas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pantalla_clientes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
