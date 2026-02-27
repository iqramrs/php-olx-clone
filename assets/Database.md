CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(50)  NOT NULL UNIQUE,
  `whatsapp` VARCHAR(15) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `icon` VARCHAR(100),
  PRIMARY KEY (`id`)
);

CREATE TABLE `ads` (
  `id` INT AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `slug` VARCHAR(255),
  `description` TEXT NOT NULL,
  `price` DECIMAL(15,2) NOT NULL,
  `location` VARCHAR(100),
  `user_id` INT,
  `category_id` INT,
  `release_at` TIMESTAMP CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`)
      REFERENCES `categories`(`id`),
  FOREIGN KEY (`user_id`)
      REFERENCES `users`(`id`)
);

CREATE TABLE `ad_images` (
  `id` INT AUTO_INCREMENT,
  `ad_id` INT,
  `image` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`ad_id`)
      REFERENCES `ads`(`id`)
);

