@@ .. @@
 -- Структура таблицы `unitpay`
 --
 
+CREATE TABLE `yookassa` (
+  `id` int(10) UNSIGNED NOT NULL,
+  `shop_id` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
+  `secret_key` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
+) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
+
+--
+-- Структура таблицы `unitpay`
+--
+
 CREATE TABLE `unitpay` (
@@ .. @@
 -- Индексы таблицы `unitpay`
 --
+ALTER TABLE `yookassa`
+  ADD PRIMARY KEY (`id`);
+
+--
+-- Индексы таблицы `unitpay`
+--
 ALTER TABLE `unitpay`
@@ .. @@
 -- AUTO_INCREMENT для таблицы `unitpay`
 --
+ALTER TABLE `yookassa`
+  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
+
+--
+-- AUTO_INCREMENT для таблицы `unitpay`
+--
 ALTER TABLE `unitpay`