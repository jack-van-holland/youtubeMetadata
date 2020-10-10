-- Soo-Yeon Kim (skim403)
-- Jack Van Holland (jvanhol1)

-- setup.sql

------------------------------------------------------------------------------------------


-- In case we've run this script before, remove old tables before we re-create them
DROP TABLE IF EXISTS Reply;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Video;
DROP TABLE IF EXISTS Channel;


CREATE TABLE Channel (
  channel_id   CHAR(24),
  title        VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  createdDate  DATETIME,
  views        INT UNSIGNED,
  subscribers  INT UNSIGNED,
  description  VARCHAR(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  country      CHAR(2),
  PRIMARY KEY(channel_id)
);

LOAD DATA LOCAL INFILE 'channel.txt'
INTO TABLE Channel
CHARACTER SET UTF8
FIELDS TERMINATED BY '\t'
LINES TERMINATED BY X'0b';

CREATE TABLE Video (
  video_id     CHAR(11),
  title        VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  channel_id   CHAR(24) NOT NULL,
  createdDate  DATETIME,
  category     VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  likes        INT UNSIGNED,
  dislikes     INT UNSIGNED,
  views        INT UNSIGNED,
  description  VARCHAR(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  duration     INT UNSIGNED,
  PRIMARY KEY(video_id),
  FOREIGN KEY(channel_id) REFERENCES Channel(channel_id) ON UPDATE CASCADE ON DELETE CASCADE
);

LOAD DATA LOCAL INFILE 'video.txt'
INTO TABLE Video
CHARACTER SET UTF8
FIELDS TERMINATED BY '\t'
LINES TERMINATED BY X'0b';

CREATE TABLE Comment (
  comment_id   VARCHAR(49),
  video_id     CHAR(11) NOT NULL,
  author_id    CHAR(24) NOT NULL,
  createdDate  DATETIME,
  text         VARCHAR(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  likes        INT UNSIGNED,
  PRIMARY KEY(comment_id),
  FOREIGN KEY(video_id) REFERENCES Video(video_id) ON UPDATE CASCADE ON DELETE CASCADE
);

LOAD DATA LOCAL INFILE 'comment.txt'
INTO TABLE Comment
CHARACTER SET UTF8
FIELDS TERMINATED BY '\t'
LINES TERMINATED BY X'0b';

CREATE TABLE Reply  (
  reply_comment_id     VARCHAR(49),
  original_comment_id  VARCHAR(49) NOT NULL,
  PRIMARY KEY(reply_comment_id),
  FOREIGN KEY(original_comment_id) REFERENCES Comment(comment_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(reply_comment_id) REFERENCES Comment(comment_id) ON UPDATE CASCADE ON DELETE CASCADE
);

LOAD DATA LOCAL INFILE 'reply.txt'
INTO TABLE Reply
CHARACTER SET UTF8
FIELDS TERMINATED BY '\t'
LINES TERMINATED BY X'0b';
