-- 
-- Structure for table `_user_badge`
-- 

DROP TABLE IF EXISTS `_user_badge`;
CREATE TABLE IF NOT EXISTS `_user_badge` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `badge_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`badge_id`),
  KEY `_user_badge_badge_id_fkey` (`badge_id`),
  CONSTRAINT `_user_badge_badge_id_fkey` FOREIGN KEY (`badge_id`) REFERENCES `badge` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Data for table `_user_badge`
-- 

INSERT INTO `_user_badge` (`user_id`, `badge_id`) VALUES
  ('17', '1');

-- 
-- Structure for table `badge`
-- 

DROP TABLE IF EXISTS `badge`;
CREATE TABLE IF NOT EXISTS `badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `desc` text,
  `exp` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `user_count` int(11) DEFAULT '0',
  `t_insert` datetime DEFAULT NULL,
  `t_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `badge_slug_ukey` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 
-- Data for table `badge`
-- 

INSERT INTO `badge` (`id`, `name`, `slug`, `desc`, `exp`, `active`, `user_count`, `t_insert`, `t_update`) VALUES
  ('1', 'First login', 'login-first', 'Logged for the first time', '0', '1', '1', NULL, NULL),
  ('2', 'List viewer', 'list-my', 'View my badges', '0', '1', '0', NULL, NULL);

-- 
-- Structure for table `tbl_attachments`
-- 

DROP TABLE IF EXISTS `tbl_attachments`;
CREATE TABLE IF NOT EXISTS `tbl_attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT NULL,
  `object_type` enum('product_image','certificate') DEFAULT NULL,
  `file` varchar(250) DEFAULT NULL,
  `file_origin` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_attachments`
-- 

INSERT INTO `tbl_attachments` (`id`, `object_id`, `object_type`, `file`, `file_origin`) VALUES
  ('4', '1', 'product_image', '4.jpg', 'handegg.jpg'),
  ('3', '1', 'certificate', '3.jpg', 'jag_lotta.jpg');

-- 
-- Structure for table `tbl_authassignment`
-- 

DROP TABLE IF EXISTS `tbl_authassignment`;
CREATE TABLE IF NOT EXISTS `tbl_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `tbl_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_authassignment`
-- 

INSERT INTO `tbl_authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
  ('Admin', '1', NULL, 'N;'),
  ('Authenticated', '17', NULL, 'N;'),
  ('Authenticated', '2', NULL, 'N;');

-- 
-- Structure for table `tbl_authitem`
-- 

DROP TABLE IF EXISTS `tbl_authitem`;
CREATE TABLE IF NOT EXISTS `tbl_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_authitem`
-- 

INSERT INTO `tbl_authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
  ('Admin', '2', NULL, NULL, 'N;'),
  ('Authenticated', '2', 'Authenticated user', NULL, 'N;'),
  ('Comment.*', '1', 'Access all comment actions', NULL, 'N;'),
  ('Comment.Approve', '0', 'Approve comments', NULL, 'N;'),
  ('Comment.Delete', '0', 'Delete comments', NULL, 'N;'),
  ('Comment.Update', '0', 'Update comments', NULL, 'N;'),
  ('CommentAdministration', '1', 'Administration of comments', NULL, 'N;'),
  ('Guest', '2', 'Guest user', NULL, 'N;'),
  ('Howto.*', '1', 'Access all howto actions', NULL, 'N;'),
  ('Howto.Create', '0', 'Create Howtos', NULL, 'N;'),
  ('Howto.Update', '0', 'Update howtos', NULL, 'N;'),
  ('HowtoAdministrator', '1', 'Administration of Howtos', NULL, 'N;'),
  ('HowtoCreateUpdate', '1', 'User who can update and create howtos', '!Yii::app()->user->isGuest', 'N;'),
  ('Post.Admin', '0', 'Administer posts', NULL, 'N;'),
  ('Post.Delete', '0', 'Delete posts', NULL, 'N;'),
  ('Post.View', '0', 'View posts', NULL, 'N;'),
  ('PostUpdateOwn', '0', 'Update own posts', 'return Yii::app()->user->id==$params[\"userid\"];', 'N;'),
  ('User.Register', '0', 'Register for an account', 'Yii::app()->user->isGuest', 'N;'),
  ('User.View', '0', NULL, NULL, 'N;');

-- 
-- Structure for table `tbl_authitemchild`
-- 

DROP TABLE IF EXISTS `tbl_authitemchild`;
CREATE TABLE IF NOT EXISTS `tbl_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_authitemchild`
-- 

INSERT INTO `tbl_authitemchild` (`parent`, `child`) VALUES
  ('Editor', 'Authenticated'),
  ('CommentAdministration', 'Comment.*'),
  ('Editor', 'CommentAdministration'),
  ('Authenticated', 'CommentUpdateOwn'),
  ('Authenticated', 'Guest'),
  ('HowtoCreateUpdate', 'Howto.Create'),
  ('HowtoCreateUpdate', 'Howto.Update'),
  ('Authenticated', 'HowtoCreateUpdate'),
  ('PostAdministrator', 'Post.*'),
  ('PostAdministrator', 'Post.Admin'),
  ('Authenticated', 'Post.Create'),
  ('PostAdministrator', 'Post.Create'),
  ('PostAdministrator', 'Post.Delete'),
  ('PostAdministrator', 'Post.Update'),
  ('Guest', 'Post.View'),
  ('Editor', 'PostAdministrator'),
  ('Authenticated', 'PostUpdateOwn'),
  ('Guest', 'Register'),
  ('Guest', 'User.Register'),
  ('Authenticated', 'User.View'),
  ('Guest', 'User.View');

-- 
-- Structure for table `tbl_bookmark`
-- 

DROP TABLE IF EXISTS `tbl_bookmark`;
CREATE TABLE IF NOT EXISTS `tbl_bookmark` (
  `user_id` int(11) NOT NULL,
  `howto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_bookmark`
-- 

INSERT INTO `tbl_bookmark` (`user_id`, `howto_id`) VALUES
  ('1', '2'),
  ('1', '1');

-- 
-- Structure for table `tbl_category`
-- 

DROP TABLE IF EXISTS `tbl_category`;
CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `parent` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_category`
-- 

INSERT INTO `tbl_category` (`id`, `name`, `parent`) VALUES
  ('5', 'Technology', 'no parent'),
  ('6', 'Computers', 'Technology'),
  ('7', 'Tablets', 'Technology'),
  ('8', 'Mp3 players', 'Technology'),
  ('9', 'Mobile Phones', 'Technology'),
  ('10', 'Windows', 'Technology'),
  ('11', 'Linux', 'Technology'),
  ('12', 'Android', 'Technology'),
  ('13', 'IOS', 'Technology'),
  ('14', 'Cameras', 'Technology'),
  ('15', 'Software', 'Technology'),
  ('16', 'Photoshop', 'Technology'),
  ('17', 'Web developement', 'Technology'),
  ('18', 'Audio', 'Technology'),
  ('19', 'Vehicles', 'no parent'),
  ('20', 'Cars', 'Vehicles'),
  ('21', 'Motorcycles', 'Vehicles'),
  ('22', 'Boats', 'Vehicles'),
  ('23', 'Trucks', 'Vehicles'),
  ('24', 'Bikes', 'Vehicles'),
  ('25', 'Software developement', 'Technology');

-- 
-- Structure for table `tbl_comment`
-- 

DROP TABLE IF EXISTS `tbl_comment`;
CREATE TABLE IF NOT EXISTS `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `author` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `howto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comment_post` (`howto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_comment`
-- 

INSERT INTO `tbl_comment` (`id`, `content`, `status`, `create_time`, `author`, `email`, `url`, `howto_id`) VALUES
  ('1', 'This is a test comment.', '2', '1230952187', 'Tester', 'tester@example.com', NULL, '2'),
  ('2', '<span style=\"font-weight:bold\">Some</span> <span style=\"font-style:italic\">test</span> <span style=\"text-decoration:underline\">post</span> <span style=\"text-decoration:line-through\">showing</span> <sub>some </sub><sup>formatting</sup>', '2', '1331139070', 'Daniel', 'tester@examplec.com', '', '1');

-- 
-- Structure for table `tbl_howto`
-- 

DROP TABLE IF EXISTS `tbl_howto`;
CREATE TABLE IF NOT EXISTS `tbl_howto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `tags` text,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `rating_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_author` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_howto`
-- 

INSERT INTO `tbl_howto` (`id`, `title`, `content`, `tags`, `status`, `create_time`, `update_time`, `author_id`, `rating_id`) VALUES
  ('1', 'Welcome!', ' dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.							', 'yii, blog', '2', '1230952187', '1338232387', '1', '1'),
  ('2', 'A Test Post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'test', '2', '1230952187', '1331631165', '1', '2'),
  ('3', 'Howto', 'Videotestin', '', '2', '1336165279', '1336165279', '1', '4'),
  ('4', 'eaieai', 'aeiaei', '', '2', '1336209038', '1336209038', '1', '5'),
  ('5', 'eaieai', 'aeiaei', '', '2', '1336209053', '1336209053', '1', '6'),
  ('6', 'eaieai', 'aeiaei', '', '2', '1336209082', '1336209082', '1', '7'),
  ('7', 'eaieai', 'aeiaei', '', '2', '1336209132', '1336209132', '1', '8'),
  ('8', 'eaieai', 'aeiaei', '', '2', '1336209239', '1336209239', '1', '9'),
  ('9', 'eaieai', 'aeiaei', '', '2', '1336209260', '1336209260', '1', '10'),
  ('10', 'eaieai', 'aeiaei', '', '2', '1336209348', '1336209348', '1', '11'),
  ('11', 'eaieai', 'aeiaei', '', '2', '1336209394', '1336209394', '1', '12'),
  ('12', 'eaieai', 'aeiaei', '', '2', '1336209421', '1336209421', '1', '13'),
  ('13', 'eaieai', 'aeiaei', '', '2', '1336209423', '1336209423', '1', '14'),
  ('14', 'eaieai', 'aeiaei', '', '2', '1336209483', '1336209483', '1', '15'),
  ('15', 'eaieai', 'aeiaei', '', '2', '1336209890', '1336209890', '1', '16'),
  ('16', 'eaieai', 'aeiaei', '', '2', '1336209995', '1336209995', '1', '17'),
  ('18', 'aeia', 'aei', '', '2', '1336210260', '1336210260', '1', '19'),
  ('19', 'aeia', 'aei', '', '2', '1336210304', '1336210304', '1', '20'),
  ('20', 'aeia', 'aei', '', '2', '1336210336', '1336210336', '1', '21'),
  ('21', 'aeia', 'aei', '', '2', '1336210361', '1336210361', '1', '22'),
  ('22', 'aeia', 'aei', '', '2', '1336210373', '1336210373', '1', '23'),
  ('23', 'aeia', 'aei', '', '2', '1336210401', '1336210401', '1', '24'),
  ('24', 'aeia', 'aei', '', '2', '1336210494', '1336210494', '1', '25'),
  ('25', 'aeiaeia', 'aei', '', '2', '1336210522', '1336210522', '1', '26'),
  ('26', 'aeiaeia', 'aei', '', '2', '1336210575', '1336210575', '1', '27'),
  ('27', 'aeiaeia', 'aei', '', '2', '1336210633', '1336210633', '1', '28'),
  ('28', 'aeiaeia', 'aei', '', '2', '1336210650', '1336210650', '1', '29'),
  ('29', 'aeiaeia', 'aei', '', '2', '1336210685', '1336210685', '1', '30'),
  ('30', 'aeiaeia', 'aei', '', '2', '1336210702', '1336210702', '1', '31'),
  ('31', 'aeiaeia', 'aei', '', '2', '1336210718', '1336210718', '1', '32'),
  ('32', 'aeiaeia', 'aei', '', '2', '1336210741', '1336210741', '1', '33'),
  ('33', 'aeiaeia', 'aei', '', '2', '1336210756', '1336210756', '1', '34'),
  ('34', 'aeiaeia', 'aei', '', '2', '1336210801', '1336210801', '1', '35'),
  ('35', 'aeiaeia', 'aei', '', '2', '1336210877', '1336210877', '1', '36'),
  ('36', 'aeiaeia', 'aei', '', '2', '1336210909', '1336210909', '1', '37'),
  ('37', 'aeiaeia', 'aei', '', '2', '1336211078', '1336211078', '1', '38'),
  ('38', 'aeiaeia', 'aei', '', '2', '1336211254', '1336211254', '1', '39'),
  ('39', 'aeiaeia', 'aei', '', '2', '1336211278', '1336211278', '1', '40'),
  ('40', 'aeiaeia', 'aei', '', '2', '1336211304', '1336211304', '1', '41'),
  ('41', 'aeiaeia', 'aei', '', '2', '1336211325', '1336211325', '1', '42'),
  ('42', 'aeiaeia', 'aei', '', '2', '1336211381', '1336211381', '1', '43'),
  ('43', 'aeiaeia', 'aei', '', '2', '1336211460', '1336211460', '1', '44'),
  ('44', 'aeiaeia', 'aei', '', '2', '1336211511', '1336211511', '1', '45'),
  ('45', 'aeiaeia', 'aei', '', '2', '1336211521', '1336211521', '1', '46'),
  ('46', 'aeiaeia', 'aei', '', '2', '1336211552', '1336211552', '1', '47'),
  ('47', 'aeiaeia', 'aei', '', '2', '1336211719', '1336211719', '1', '48'),
  ('48', 'aeiaeia', 'aei', '', '2', '1336211736', '1336211736', '1', '49'),
  ('49', 'aeiaeia', 'aei', '', '2', '1336211749', '1336211749', '1', '50'),
  ('50', 'aeiaeia', 'aei', '', '2', '1336211758', '1336211758', '1', '51'),
  ('51', 'aeiaeia', 'aei', '', '2', '1336211777', '1336211777', '1', '52'),
  ('52', 'aeiaeia', 'aei', '', '2', '1336211914', '1336211914', '1', '53'),
  ('53', 'aeiaeia', 'aei', '', '2', '1336211949', '1336211949', '1', '54'),
  ('54', 'aeiaeia', 'aei', '', '2', '1336211991', '1336211991', '1', '55'),
  ('55', 'aeiaeia', 'aei', '', '2', '1336212052', '1336212052', '1', '56'),
  ('56', 'aeiaeia', 'aei', '', '2', '1336212071', '1336212071', '1', '57'),
  ('57', 'aeiaeia', 'aei', '', '2', '1336212097', '1336212097', '1', '58'),
  ('58', 'aeiaeia', 'aei', '', '2', '1336212117', '1336212117', '1', '59'),
  ('59', 'aeiaeia', 'aei', '', '2', '1336212153', '1336212153', '1', '60'),
  ('60', 'aeiaeia', 'aei', '', '2', '1336212173', '1336212173', '1', '61'),
  ('61', 'aeiaeia', 'aei', '', '2', '1336212192', '1336212192', '1', '62'),
  ('62', 'aeiaeia', 'aei', '', '2', '1336212206', '1336212206', '1', '63'),
  ('63', 'aeiaeia', 'aei', '', '2', '1336212232', '1336212232', '1', '64'),
  ('64', 'aeiaeia', 'aei', '', '2', '1336212242', '1336212242', '1', '65'),
  ('65', 'aeiaeia', 'aei', '', '2', '1336212250', '1336212250', '1', '66'),
  ('66', 'aeiaeia', 'aei', '', '2', '1336212255', '1336212255', '1', '67'),
  ('67', 'aeiaeia', 'aei', '', '2', '1336212277', '1336212277', '1', '68'),
  ('68', 'aeiaeia', 'aei', '', '2', '1336212358', '1336212358', '1', '69'),
  ('69', 'aeiaeia', 'aei', '', '2', '1336212368', '1336212368', '1', '70'),
  ('70', 'aeiaeia', 'aei', '', '2', '1336212379', '1336212379', '1', '71'),
  ('71', 'aeiaeia', 'aei', '', '2', '1336212391', '1336212391', '1', '72'),
  ('72', 'aeiaeia', 'aei', '', '2', '1336212414', '1336212414', '1', '73'),
  ('73', 'aeiaeia', 'aei', '', '2', '1336212423', '1336212423', '1', '74'),
  ('74', 'aeiaeia', 'aei', '', '2', '1336212442', '1336212442', '1', '75'),
  ('75', 'aeiaeia', 'aei', '', '2', '1336212478', '1336212478', '1', '76'),
  ('76', 'aeiaeia', 'aei', '', '2', '1336212516', '1336212516', '1', '77'),
  ('77', 'aeiaeia', 'aei', '', '2', '1336212526', '1336212526', '1', '78'),
  ('78', 'aeiaeia', 'aei', '', '2', '1336212913', '1336212913', '1', '79'),
  ('79', 'aeiaeia', 'aei', '', '2', '1336213061', '1336213061', '1', '80'),
  ('80', 'aeiaeia', 'aei', '', '2', '1336213082', '1336213082', '1', '81'),
  ('81', 'aeiaeia', 'aei', '', '2', '1336213088', '1336213088', '1', '82'),
  ('82', 'aeiaeia', 'aei', '', '2', '1336213129', '1336213129', '1', '83'),
  ('83', 'aeiaeia', 'aei', '', '2', '1336213382', '1336213382', '1', '84'),
  ('84', 'aeiaeia', 'aei', '', '2', '1336213427', '1336213427', '1', '85'),
  ('85', 'aeiaeia', 'aei', '', '2', '1336213440', '1336213440', '1', '86'),
  ('86', 'aeiaeia', 'aei', '', '2', '1336213460', '1336213460', '1', '87'),
  ('87', 'aeiaeia', 'aei', '', '2', '1336213867', '1336213867', '1', '88'),
  ('88', 'aeiaeia', 'aei', '', '2', '1336213898', '1336213898', '1', '89'),
  ('89', 'aeiaeia', 'aei', '', '2', '1336214001', '1336214001', '1', '90'),
  ('90', 'aeiaeia', 'aei', '', '2', '1336214071', '1336214071', '1', '91'),
  ('91', 'aeiaei', 'aeia						', '', '2', '1336214116', '1336908904', '1', '92'),
  ('92', 'aeiaei', 'aeia', '', '2', '1336214153', '1336214153', '1', '93');

-- 
-- Structure for table `tbl_howto_category`
-- 

DROP TABLE IF EXISTS `tbl_howto_category`;
CREATE TABLE IF NOT EXISTS `tbl_howto_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `howto_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_howto_category`
-- 

INSERT INTO `tbl_howto_category` (`id`, `howto_id`, `category_id`) VALUES
  ('1', '1', '1');

-- 
-- Structure for table `tbl_lookup`
-- 

DROP TABLE IF EXISTS `tbl_lookup`;
CREATE TABLE IF NOT EXISTS `tbl_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_lookup`
-- 

INSERT INTO `tbl_lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
  ('1', 'Draft', '1', 'HowtoStatus', '1'),
  ('2', 'Published', '2', 'HowtoStatus', '2'),
  ('3', 'Archived', '3', 'HowtoStatus', '3'),
  ('4', 'Pending Approval', '1', 'CommentStatus', '1'),
  ('5', 'Approved', '2', 'CommentStatus', '2');

-- 
-- Structure for table `tbl_messages`
-- 

DROP TABLE IF EXISTS `tbl_messages`;
CREATE TABLE IF NOT EXISTS `tbl_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(256) NOT NULL DEFAULT '',
  `body` text,
  `is_read` enum('0','1') NOT NULL DEFAULT '0',
  `deleted_by` enum('sender','receiver') DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender_id`),
  KEY `reciever` (`receiver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_messages`
-- 

INSERT INTO `tbl_messages` (`id`, `sender_id`, `receiver_id`, `subject`, `body`, `is_read`, `deleted_by`, `created_at`) VALUES
  ('8', '1', '1', 'ei', 'aei', '1', NULL, '2012-03-20 12:02:33'),
  ('9', '1', '1', 'hej', 'hej', '1', NULL, '2012-03-23 08:29:17');

-- 
-- Structure for table `tbl_rating`
-- 

DROP TABLE IF EXISTS `tbl_rating`;
CREATE TABLE IF NOT EXISTS `tbl_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vote_count` int(11) NOT NULL DEFAULT '0',
  `vote_average` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL DEFAULT '5',
  `vote_sum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_rating`
-- 

INSERT INTO `tbl_rating` (`id`, `vote_count`, `vote_average`, `vote_sum`) VALUES
  ('1', '80', '8.89', '711'),
  ('2', '30', '8.3', '249'),
  ('3', '0', '5', '0'),
  ('4', '0', '5', '0'),
  ('5', '0', '5', '0'),
  ('6', '0', '5', '0'),
  ('7', '0', '5', '0'),
  ('8', '0', '5', '0'),
  ('9', '0', '5', '0'),
  ('10', '0', '5', '0'),
  ('11', '0', '5', '0'),
  ('12', '0', '5', '0'),
  ('13', '0', '5', '0'),
  ('14', '0', '5', '0'),
  ('15', '0', '5', '0'),
  ('16', '0', '5', '0'),
  ('17', '0', '5', '0'),
  ('18', '0', '5', '0'),
  ('19', '0', '5', '0'),
  ('20', '0', '5', '0'),
  ('21', '0', '5', '0'),
  ('22', '0', '5', '0'),
  ('23', '0', '5', '0'),
  ('24', '0', '5', '0'),
  ('25', '0', '5', '0'),
  ('26', '0', '5', '0'),
  ('27', '0', '5', '0'),
  ('28', '0', '5', '0'),
  ('29', '0', '5', '0'),
  ('30', '0', '5', '0'),
  ('31', '0', '5', '0'),
  ('32', '0', '5', '0'),
  ('33', '0', '5', '0'),
  ('34', '0', '5', '0'),
  ('35', '0', '5', '0'),
  ('36', '0', '5', '0'),
  ('37', '0', '5', '0'),
  ('38', '0', '5', '0'),
  ('39', '0', '5', '0'),
  ('40', '0', '5', '0'),
  ('41', '0', '5', '0'),
  ('42', '0', '5', '0'),
  ('43', '0', '5', '0'),
  ('44', '0', '5', '0'),
  ('45', '0', '5', '0'),
  ('46', '0', '5', '0'),
  ('47', '0', '5', '0'),
  ('48', '0', '5', '0'),
  ('49', '0', '5', '0'),
  ('50', '0', '5', '0'),
  ('51', '0', '5', '0'),
  ('52', '0', '5', '0'),
  ('53', '0', '5', '0'),
  ('54', '0', '5', '0'),
  ('55', '0', '5', '0'),
  ('56', '0', '5', '0'),
  ('57', '0', '5', '0'),
  ('58', '0', '5', '0'),
  ('59', '0', '5', '0'),
  ('60', '0', '5', '0'),
  ('61', '0', '5', '0'),
  ('62', '0', '5', '0'),
  ('63', '0', '5', '0'),
  ('64', '0', '5', '0'),
  ('65', '0', '5', '0'),
  ('66', '0', '5', '0'),
  ('67', '0', '5', '0'),
  ('68', '0', '5', '0'),
  ('69', '0', '5', '0'),
  ('70', '0', '5', '0'),
  ('71', '0', '5', '0'),
  ('72', '0', '5', '0'),
  ('73', '0', '5', '0'),
  ('74', '0', '5', '0'),
  ('75', '0', '5', '0'),
  ('76', '0', '5', '0'),
  ('77', '0', '5', '0'),
  ('78', '0', '5', '0'),
  ('79', '0', '5', '0'),
  ('80', '0', '5', '0'),
  ('81', '0', '5', '0'),
  ('82', '0', '5', '0'),
  ('83', '0', '5', '0'),
  ('84', '0', '5', '0'),
  ('85', '0', '5', '0'),
  ('86', '0', '5', '0'),
  ('87', '0', '5', '0'),
  ('88', '0', '5', '0'),
  ('89', '0', '5', '0'),
  ('90', '0', '5', '0'),
  ('91', '0', '5', '0'),
  ('92', '0', '5', '0'),
  ('93', '0', '5', '0');

-- 
-- Structure for table `tbl_rights`
-- 

DROP TABLE IF EXISTS `tbl_rights`;
CREATE TABLE IF NOT EXISTS `tbl_rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  PRIMARY KEY (`itemname`),
  CONSTRAINT `tbl_rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_rights`
-- 

INSERT INTO `tbl_rights` (`itemname`, `type`, `weight`) VALUES
  ('Authenticated', '2', '1'),
  ('Guest', '2', '2');

-- 
-- Structure for table `tbl_slide`
-- 

DROP TABLE IF EXISTS `tbl_slide`;
CREATE TABLE IF NOT EXISTS `tbl_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `text` varchar(255) NOT NULL,
  `howto_id` int(11) NOT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_slide`
-- 

INSERT INTO `tbl_slide` (`id`, `title`, `text`, `howto_id`, `picture`) VALUES
  ('18', 'aeiaeia', 'aouao', '1', '1336056609530.gif'),
  ('20', 'AEIA', 'aeieaia', '1', 'fs_504890394_96921_1336028771.jpg'),
  ('23', 'aeia', 'aeia', '92', 'fs_505033746_67623_1336331334.jpg'),
  ('24', 'Två', ':)', '92', 'senap.jpg');

-- 
-- Structure for table `tbl_social`
-- 

DROP TABLE IF EXISTS `tbl_social`;
CREATE TABLE IF NOT EXISTS `tbl_social` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yiiuser` int(11) NOT NULL,
  `provider` varchar(50) NOT NULL,
  `provideruser` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_social`
-- 

INSERT INTO `tbl_social` (`id`, `yiiuser`, `provider`, `provideruser`) VALUES
  ('1', '25', 'twitter', '105101246');

-- 
-- Structure for table `tbl_step`
-- 

DROP TABLE IF EXISTS `tbl_step`;
CREATE TABLE IF NOT EXISTS `tbl_step` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `howto_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `text` mediumtext NOT NULL,
  `position` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`howto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_step`
-- 

INSERT INTO `tbl_step` (`id`, `howto_id`, `title`, `text`, `position`) VALUES
  ('1', '1', 'Steg 1 - Koka vatten', '<a name=\"steg2\" title=\"Bookmark: steg2\">hej</a><br>När vattnet börjar bubbla är du klar med <a anchor=\"steg2\" href=\"#steg1\"><span style=\"font-family:impact,sans-serif\">steg1</span></a> .Då tar du bort kastrullen från spisen. Häll upp vattnet i ett glas och drick:p', '1'),
  ('17', '1', 'Steg2 - Bränna tungan', '<a name=\"steg2\" title=\"Bookmark: steg2\"></a><br />När vattnet börjar bubbla är du klar med <a anchor=\"steg2\" href=\"#steg1\"><span style=\"font-family:impact,sans-serif\">steg1</span></a> .Då tar du bort kastrullen från spisen. Häll upp vattnet i ett glas och drick<br /><img alt=\"wink\" title=\"wink\" src=\"http://blog/assets/d024e261/images/smileys/wink.png\" />', '2'),
  ('71', '51', 'Test', 'stop', '1'),
  ('72', '52', 'aei', 'aei', '1'),
  ('73', '3', 'eia', 'aeiaei', '1'),
  ('74', '3', 'aeia', 'aeiaeiaea', '2');

-- 
-- Structure for table `tbl_tag`
-- 

DROP TABLE IF EXISTS `tbl_tag`;
CREATE TABLE IF NOT EXISTS `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_tag`
-- 

INSERT INTO `tbl_tag` (`id`, `name`, `frequency`) VALUES
  ('1', 'yii', '1'),
  ('2', 'blog', '1'),
  ('3', 'test', '1'),
  ('4', 'ia', '1'),
  ('5', 'eaia', '1'),
  ('6', 'aei', '1');

-- 
-- Structure for table `tbl_twitter`
-- 

DROP TABLE IF EXISTS `tbl_twitter`;
CREATE TABLE IF NOT EXISTS `tbl_twitter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `consumer_key` varchar(100) NOT NULL,
  `consumer_secret` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_twitter`
-- 

INSERT INTO `tbl_twitter` (`id`, `user_id`, `consumer_key`, `consumer_secret`) VALUES
  ('1', '1', 'rPmGEE1Wvsf56BSyQaWXw', 'V4SK09O0cPOgkabsxR5AruBSNrc0b1tzoBeWkL7ew0');

-- 
-- Structure for table `tbl_user`
-- 

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `created` datetime NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `avatar` varchar(255) DEFAULT NULL,
  `presentation` mediumtext NOT NULL,
  `public_library` tinyint(1) NOT NULL DEFAULT '0',
  `reputation` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_user`
-- 

INSERT INTO `tbl_user` (`id`, `username`, `password`, `email`, `created`, `last_activity`, `avatar`, `presentation`, `public_library`, `reputation`) VALUES
  ('1', 'Admin', '$2a$10$rA7CrKSDG0vfJH0NikgdhOg0QFdH0o3iCJH8r2WDmY/uE3kO7SyrS', 'webmaster@prototyp.com', '2012-03-09 12:03:16', '2012-05-25 11:05:25', 'DSC_0011.JPG', '<a href=\"/files/users/1/Admin_19375414.jpg\">Admin_19375414.jpg</a><span style=\"font-size:x-large;font-family:comic sans ms,cursive;color:#ffffff;background-color:#000000\"></span><span style=\"font-size:x-large\"><img alt=\"evilgrin\" title=\"evilgrin\" src=\"http://blog/assets/7952073/images/smileys/evilgrin.png\" /> lorum ipsumlorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  lorum ipsum  <br /><br /><br /></span>', '0', '24'),
  ('2', 'demo', '$2a$10$PaydiNueMCVikCS2sR5eNuQxlmFmqUY6TLQWGnW6aDtbIRJE/qwbm', 'demo@demo.com', '2012-03-11 12:03:51', '0000-00-00 00:00:00', '', '', '0', '0'),
  ('3', 'demo', '$2a$10$aNE1SHBkmld6iLbfBiAUEePvslXiEPPL1CiXLSZioHz/5VohJ2pf6', 'demo@demo.com', '2012-03-11 12:03:49', '0000-00-00 00:00:00', '', '', '0', '0'),
  ('12', 'idrini@gmail.com', '$2a$10$ehtSExvtMlVTmyIajRyIW.oRaoV09DgPsZy5RLfHaZJ1DmWSE/jjC', 'idrini@gmail.com', '2012-05-06 11:05:07', '0000-00-00 00:00:00', NULL, '', '0', '0'),
  ('17', 'Drini', '$2a$10$oSVG.ZnIBV1A4OwCZV42zeg8C1QvQt12vLfkvI7yTPlaKflErCDaC', 'idrini@gmail.com', '2012-05-06 11:05:57', '2012-05-08 10:05:57', '', ':)', '0', '0'),
  ('25', '105101246', '$2a$10$qwiyKR546KmZvINdhR5T5eipRHpJGzzzgk5BEVYZXO/iahzQGk/jq', '', '2012-05-29 06:05:59', '2012-05-29 07:05:37', 'senap.jpg', '', '0', '0');

-- 
-- Structure for table `tbl_video`
-- 

DROP TABLE IF EXISTS `tbl_video`;
CREATE TABLE IF NOT EXISTS `tbl_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `howto_id` int(11) NOT NULL,
  `filename` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- 
-- Data for table `tbl_video`
-- 

INSERT INTO `tbl_video` (`id`, `user_id`, `howto_id`, `filename`) VALUES
  ('1', '1', '92', 'DSC_0015.JPG'),
  ('2', '1', '92', 'DSC_0014.JPG'),
  ('3', '1', '92', 'DSC_0013.JPG');

