create database hexabe;
use hexabe;

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
);

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
);

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
);

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_available_at_index` (`queue`,`reserved_at`,`available_at`)
);

CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
);

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
);

CREATE TABLE business(
	`id` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name varchar(255),
    `created_at` timestamp NULL DEFAULT now(),
	`updated_at` timestamp NULL DEFAULT now(),
	`deleted_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `phone_code` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `position` varchar(191) DEFAULT NULL,
  `role` varchar(191) DEFAULT NULL, -- SUPER, ADMIN, USER, EXTERNAL
  `social_id` varchar(191) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED null,
  `media_id` bigint(20) UNSIGNED NULL,  -- avatar
  `status` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `business_id` bigint(20) unsigned null,
  `created_at` timestamp NULL DEFAULT now(),
  `updated_at` timestamp NULL DEFAULT now(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  foreign key(parent_id) references users(id) on delete cascade on update no action,
  foreign key(business_id) references business(id) on delete cascade on update no action
);

CREATE TABLE medias(
	`id` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name varchar(255),
    path varchar(255),
    mime varchar(100),
    size int,
    user_id bigint(20) unsigned null,
    business_id bigint(20) unsigned,
    created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
    deleted_at timestamp NULL DEFAULT NULL,
    foreign key (user_id) references users(id) on delete set null on update no action,
    foreign key(business_id) references business(id) on delete cascade on update no action
);

CREATE TABLE brands(
	`id` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name varchar(255),
    industry varchar(255),
    status varchar(100), -- ACTIVE, DEACTIVE
    description TEXT null,
    media_id bigint(20) unsigned null,
    user_id  bigint(20) unsigned null, -- user created
    business_id bigint(20) unsigned,
    created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
    deleted_at timestamp NULL DEFAULT NULL,
    foreign key(media_id) references medias(id) on delete set null on update no action,
    foreign key (user_id) references users(id) on delete set null on update no action,
    foreign key(business_id) references business(id) on delete cascade on update no action
);

CREATE TABLE teams(
	`id` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name varchar(255),
    status varchar(100), -- ACTIVE, DEACTIVE
    description TEXT null,
    media_id bigint(20) unsigned null,
    user_id  bigint(20) unsigned null, -- user created
    business_id bigint(20) unsigned,
    created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
    deleted_at timestamp NULL DEFAULT NULL,
    foreign key (user_id) references users(id) on delete set null on update no action,
    foreign key(business_id) references business(id) on delete cascade on update no action
);

CREATE TABLE team_users(
	 `id` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	 team_id bigint(20) UNSIGNED,
	 user_id bigint(20) UNSIGNED,
	 created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
	 foreign key (team_id) references teams(id) on delete cascade on update no action,
	 foreign key (user_id) references users(id) on delete cascade on update no action
);

CREATE TABLE team_brands(
	 `id` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	 team_id bigint(20) UNSIGNED,
	 brand_id bigint(20) UNSIGNED,
	 created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
	 foreign key (brand_id) references brands(id) on delete cascade on update no action,
	 foreign key (team_id) references teams(id) on delete cascade on update no action
);

CREATE TABLE team_invitations(
	 `id` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	 team_id bigint(20) UNSIGNED,
	 email VARCHAR(255),
	 role VARCHAR(100),
	 token VARCHAR(255),
	 user_id bigint(20) UNSIGNED,
	 error TEXT NULL,
	 accepted_at timestamp NULL,
	 created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
	 foreign key (user_id) references users(id) on delete cascade on update no action,
	 foreign key (team_id)  references teams(id) on delete cascade on update no action
);

CREATE TABLE tasks(
	 id bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title varchar(255),
    description text,
    date_delivery date,
    priority varchar(100), -- low, medium, high
    status varchar(100), -- TOSTART, PROCESS, DELAY, PAUSED, FINALIZED
    user_id bigint(20) UNSIGNED, -- user created
    user_assign bigint(20) UNSIGNED,
    brand_id bigint(20) UNSIGNED null,
    parent_id bigint(20) UNSIGNED null,
    business_id bigint(20) unsigned,
    color VARCHAR(10) NULL,
    position INT NULL,
	 created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
    deleted_at timestamp NULL DEFAULT NULL,
    foreign key(user_id) references users(id) on delete cascade on update no action,
    foreign key(user_assign) references users(id) on delete cascade on update no action,
    foreign key(brand_id) references brands(id) on delete set null on update no action,
    foreign key(parent_id) references tasks(id) on delete cascade on update no action,
    foreign key(business_id) references business(id) on delete cascade on update no action
);
ALTER TABLE tasks ADD COLUMN position INT NULL AFTER business_id;
ALTER TABLE tasks ADD COLUMN color VARCHAR(10) NULL AFTER business_id;

CREATE TABLE tasks_info(
	 id bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	 task_dependency_id bigint(20) UNSIGNED NULL,
	 task_id bigint(20) UNSIGNED,
	 created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT NOW(),
    deleted_at timestamp NULL DEFAULT NULL,
    foreign key(task_id) references tasks(id) on delete cascade on update no ACTION,
    foreign key(task_dependency_id) references tasks(id) on delete set null on update no action,
);

CREATE TABLE task_medias(
	 id bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    task_id bigint(20) UNSIGNED,
    media_id bigint(20) UNSIGNED,
    created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
    foreign key (task_id) references tasks(id) on delete cascade on update no action,
    foreign key (media_id) references medias(id) on delete cascade on update no action
);

CREATE TABLE task_links(
	 id bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	 url VARCHAR(255),
    task_id bigint(20) UNSIGNED,
    user_id bigint(20) UNSIGNED,
    created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
    foreign key (task_id) references tasks(id) on delete cascade on update no action,
    foreign key (user_id) references users(id) on delete cascade on update no action
);


CREATE TABLE task_collaborators(
	 id bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    task_id bigint(20) UNSIGNED,
    user_id bigint(20) UNSIGNED,
    created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
    foreign key (task_id) references tasks(id) on delete cascade on update no action,
    foreign key (user_id) references users(id) on delete cascade on update no action
);

CREATE TABLE comments(
	 id bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	 description text,
	 task_id bigint(20) UNSIGNED,
	 user_id bigint(20) UNSIGNED,
	 created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
    foreign key (task_id) references tasks(id) on delete cascade on update no action,
    foreign key (user_id) references users(id) on delete cascade on update no action
);

CREATE TABLE comment_medias(
	 id bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	 media_id bigint(20) UNSIGNED,
	 comment_id bigint(20) UNSIGNED,
	 task_id bigint(20) UNSIGNED,
	 created_at timestamp NULL DEFAULT now(),
	 updated_at timestamp NULL DEFAULT now(),
	 foreign key (media_id) references medias(id) on delete cascade on update no ACTION,
    foreign key (comment_id) references comments(id) on delete cascade on update no ACTION,
    foreign key (task_id) references tasks(id) on delete cascade on update no action
);

-- DROP TABLE task_medias;
-- INSERT USERS
insert into users(name, last_name, email, password, role, status) values
('deiby', 'loayza', 'dloayza@sofopolis.com', '$2y$12$fX6ExEKahoArXVPFMYhW5uDpTkDv1nW6DxzAocGRis67ZSNM19RiO', 'ADMIN', 'ACTIVE'); -- 123123
insert into business (name) values ('Fobo');
update users set business_id = 1 where id=1;

insert into roles(name, guard_name, created_at, updated_at) values 
('SUPER', 'web', NOW(), NOW()),
('ADMIN', 'web', NOW(), NOW()),
('STAFF', 'web', NOW(), NOW()),
('VISIT', 'web', NOW(), NOW());

insert into model_has_roles(role_id, model_type, model_id) values
(2, 'App\Models\User', 1);

select *from users;
select *from business;
