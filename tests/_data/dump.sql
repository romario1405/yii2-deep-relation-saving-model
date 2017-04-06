DROP TABLE IF EXISTS `article_translate`;
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id`         INTEGER PRIMARY KEY AUTOINCREMENT,
  `created_at` INTEGER             DEFAULT NULL,
  `updated_at` INTEGER             DEFAULT NULL,
  `author_id`  INTEGER             DEFAULT NULL,
  `updater_id` INTEGER             DEFAULT NULL,
  `status`     INTEGER             DEFAULT NULL
);
CREATE TABLE `article_translate` (
  `id`         INTEGER PRIMARY KEY AUTOINCREMENT,
  `language`   TEXT    NOT NULL,
  `title`      TEXT    NOT NULL,
  `body`       TEXT    NOT NULL,
  `slug`       TEXT    NOT NULL,
  `article_id` INTEGER NOT NULL,
  `author_id`  INTEGER             DEFAULT NULL,
  `updater_id` INTEGER,
  `created_at` INTEGER             DEFAULT NULL,
  `updated_at` INTEGER
);