ALTER TABLE `category` ADD `preference` INT NOT NULL AFTER `id`;

ALTER TABLE `category` CHANGE `preference` `preference` INT(11) NOT NULL DEFAULT '0';

-- 21-03-2021

CREATE TABLE `custome_banner` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) DEFAULT NULL,
 `description` varchar(255) DEFAULT NULL,
 `imageurl` varchar(255) DEFAULT NULL,
 `status` int(11) NOT NULL DEFAULT 1,
 `created_at` datetime NOT NULL,
 `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `custome_banner` ADD `link` TEXT NULL AFTER `description`;

ALTER TABLE `post_video` ADD `watermark_status` INT NOT NULL AFTER `video_type`;


-- ================================================================================= --
-- ................................ New Version 13 ................................. --
-- ================================================================================= --

-- Drop old user Table 
CREATE TABLE `user` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `uid` varchar(255) DEFAULT NULL,
 `name` varchar(255) DEFAULT NULL,
 `email` varchar(255) DEFAULT NULL,
 `mobile` varchar(20) DEFAULT NULL,
 `photoUrl` varchar(255) DEFAULT NULL,
 `login_type` enum('google','normal','facebook') NOT NULL DEFAULT 'google',
 `status` int(11) NOT NULL DEFAULT 1,
 `created_at` datetime NOT NULL,
 `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `likes` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `video_id` int(11) NOT NULL,
 `video_type` enum('status','comedy') NOT NULL,
 `is_like` enum('like','unlike') NOT NULL,
 `created_at` datetime NOT NULL,
 `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`),
 KEY `user_id` (`user_id`),
 KEY `video_id` (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

///////////////////////////////////////////////////////////////


CREATE TABLE `user_subscription` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `subscription_plan_id` int(11) NOT NULL,
 `product_id` varchar(255) DEFAULT NULL,
 `expiry` date NOT NULL,
 `status` int(11) NOT NULL DEFAULT 0,
 `created_at` datetime NOT NULL,
 `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`),
 KEY `user_id` (`user_id`),
 KEY `subscription_plan_id` (`subscription_plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;