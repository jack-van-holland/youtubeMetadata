delimiter //
DROP PROCEDURE IF EXISTS getCommentsStatistics //
CREATE PROCEDURE getCommentsStatistics(IN MAX_RESULTS INT, IN COM_ID_PARAM varchar(1000), IN AUTH_ID_PARAM varchar(1000), IN VIDEO_ID_PARAM varchar(1000), IN COM_CONTAIN varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin, IN COM_NOT_CONTAIN varchar(1000), IN COM_EXCEED int, IN COM_LESS int, IN CONTAIN_SUB int, IN ALL_CAPS int, IN CREATED_BEFORE varchar(100), IN CREATED_AFTER varchar(100), IN CREATED_BEFORE_VIDEO_BOOL int, IN CREATED_BEFORE_VIDEO_SEC int, IN CREATED_BEFORE_VIDEO_MIN int, IN CREATED_BEFORE_VIDEO_HR int, IN CREATED_BEFORE_VIDEO_DAY int, IN CREATED_AFTER_VIDEO_BOOL int, IN CREATED_AFTER_VIDEO_SEC int, IN CREATED_AFTER_VIDEO_MIN int, IN CREATED_AFTER_VIDEO_HR int, IN CREATED_AFTER_VIDEO_DAY int, IN LIKE_EXCEED int, IN LIKE_LESS int, IN SORT_PARAM varchar(50), IN SORT_DIR varchar(20), IN GET_COUNT int, IN GET_PER int, IN AVE_LIKE int, IN MAX_LIKE int, IN MIN_LIKE int, IN STD_LIKE int, IN AVE_DATE int, IN MAX_DATE int, IN MIN_DATE int, IN STD_DATE int, IN AVE_COM int, IN MAX_COM int, IN MIN_COM int, IN STD_COM int, IN CORRELATION_FIRST varchar(50), IN CORRELATION_SECOND varchar(50),IN RATIO_FIRST varchar(50), IN RATIO_SECOND varchar(50))
BEGIN
set @rownum:=0;
SELECT
MAX(comment_id),
COUNT(*) * 100 / (SELECT COUNT(*) FROM Comment) AS per,
CASE WHEN GET_COUNT = 1 THEN COUNT(*) ELSE NULL END,
CASE WHEN AVE_LIKE = 1 THEN AVG(likes) ELSE NULL END,
CASE WHEN MAX_LIKE = 1 THEN MAX(likes) ELSE NULL END,
CASE WHEN MIN_LIKE = 1 THEN MIN(likes) ELSE NULL END,
CASE WHEN STD_LIKE = 1 THEN STDDEV(likes) ELSE NULL END,
CASE WHEN AVE_DATE = 1 THEN from_unixtime(AVG(unix_timestamp(createdDate))) ELSE NULL END,
CASE WHEN MAX_DATE = 1 THEN MAX(createdDate) ELSE NULL END,
CASE WHEN MIN_DATE = 1 THEN MIN(createdDate) ELSE NULL END,
CASE WHEN STD_DATE = 1 THEN STDDEV(unix_timestamp(createdDate)) / 60 / 60 / 24 ELSE NULL END,
CASE WHEN AVE_COM = 1 THEN AVG(LENGTH(text)) ELSE NULL END,
CASE WHEN MAX_COM = 1 THEN MAX(LENGTH(text)) ELSE NULL END,
CASE WHEN MIN_COM = 1 THEN MIN(LENGTH(text)) ELSE NULL END,
CASE WHEN STD_COM = 1 THEN STDDEV(LENGTH(text)) ELSE NULL END,
CASE RATIO_FIRST
WHEN 'Like Count' THEN
     CASE RATIO_SECOND
     WHEN 'Like Count' THEN AVG(likes / likes)
     WHEN 'Length of Comment' THEN AVG(likes / LENGTH(text))
     ELSE NULL
     END
WHEN 'Length of Comment' THEN
     CASE RATIO_SECOND
     WHEN 'Like Count' THEN AVG(LENGTH(text) / likes)
     WHEN 'Length of Comment' THEN AVG(LENGTH(text) / LENGTH(text))
     ELSE NULL
     END
ELSE NULL
END,
CASE CORRELATION_FIRST
WHEN 'Like Count' THEN
     CASE CORRELATION_SECOND
     WHEN 'Like Count' THEN ((AVG(likes * likes) - AVG(likes) * AVG(likes))/(STDDEV(likes) * STDDEV(likes)))
     WHEN 'Datetime Created' THEN ((AVG(unix_timestamp(createdDate) * likes) - AVG(likes) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(likes)))
     WHEN 'Length of Comment' THEN ((AVG(LENGTH(text) * likes) - AVG(LENGTH(text)) * AVG(likes))/(STDDEV(LENGTH(text)) * STDDEV(likes)))
     ELSE NULL
     END
WHEN 'Datetime Created' THEN
     CASE CORRELATION_SECOND
     WHEN 'Like Count' THEN ((AVG(unix_timestamp(createdDate) * likes) - AVG(unix_timestamp(createdDate)) * AVG(likes))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(likes)))
     WHEN 'Datetime Created' THEN ((AVG(unix_timestamp(createdDate) * unix_timestamp(createdDate)) - AVG(unix_timestamp(createdDate)) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Length of Comment' THEN ((AVG(LENGTH(text) * unix_timestamp(createdDate)) - AVG(LENGTH(text)) * AVG(unix_timestamp(createdDate)))/(STDDEV(LENGTH(text)) * STDDEV(unix_timestamp(createdDate))))
     ELSE NULL
     END
WHEN 'Length of Comment' THEN
     CASE CORRELATION_SECOND
     WHEN 'Like Count' THEN ((AVG(LENGTH(text) * likes) - AVG(LENGTH(text)) * AVG(likes))/(STDDEV(LENGTH(text)) * STDDEV(likes)))
     WHEN 'Datetime Created' THEN ((AVG(unix_timestamp(createdDate) * LENGTH(text)) - AVG(LENGTH(text)) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(LENGTH(text))))
     WHEN 'Length of Comment' THEN ((AVG(LENGTH(text) * LENGTH(text)) - AVG(LENGTH(text)) * AVG(LENGTH(text)))/(STDDEV(LENGTH(text)) * STDDEV(LENGTH(text))))
     ELSE NULL
     END
ELSE NULL
END


FROM( SELECT *, (@rownum:=@rownum+1) AS num FROM (SELECT comment_id, Video.video_id, author_id, Comment.createdDate, Video.createdDate AS videoCreatedDate, text, Comment.likes FROM Comment JOIN Video ON Comment.video_id = Video.video_id
WHERE
comment_id = CASE WHEN LENGTH(COM_ID_PARAM) = 0 THEN comment_id ELSE COM_ID_PARAM END AND
author_id = CASE WHEN LENGTH(AUTH_ID_PARAM) = 0 THEN author_id ELSE AUTH_ID_PARAM END AND
Comment.video_id = CASE WHEN LENGTH(VIDEO_ID_PARAM) = 0 THEN Comment.video_id ELSE VIDEO_ID_PARAM END AND
text LIKE CASE WHEN LENGTH(COM_CONTAIN) = 0 THEN text ELSE CONCAT("%", COM_CONTAIN, "%") END AND
text NOT LIKE CASE WHEN LENGTH(COM_NOT_CONTAIN) = 0 then CONCAT("a", text) ELSE CONCAT("%", COM_NOT_CONTAIN, "%") END AND
/*text RLIKE CASE WHEN CONTAIN_SUB = 1 THEN replace(Video.title, ' ', '|') ELSE text END AND*/
text = CASE WHEN ALL_CAPS = 1 THEN BINARY UPPER(text) ELSE text END AND
LENGTH(text) > COM_EXCEED AND
LENGTH(text) < CASE WHEN COM_LESS = -1 THEN ~0 ELSE COM_LESS END AND
Comment.createdDate < CREATED_BEFORE AND 
Comment.createdDate > CREATED_AFTER AND
unix_timestamp(Comment.createdDate) - unix_timestamp(Video.createdDate) <  CASE WHEN CREATED_BEFORE_VIDEO_BOOL = 1 THEN CREATED_BEFORE_VIDEO_SEC + CREATED_BEFORE_VIDEO_MIN * 60 + CREATED_BEFORE_VIDEO_HR * 60 * 60 + CREATED_BEFORE_VIDEO_DAY * 60 * 60 * 24 ELSE ~0 END AND
unix_timestamp(Comment.createdDate) - unix_timestamp(Video.createdDate) >  CASE WHEN CREATED_AFTER_VIDEO_BOOL = 1 THEN CREATED_AFTER_VIDEO_SEC + CREATED_AFTER_VIDEO_MIN * 60 + CREATED_AFTER_VIDEO_HR * 60 * 60 + CREATED_AFTER_VIDEO_DAY * 60 * 60 * 24 ELSE -1 END AND
Comment.likes > LIKE_EXCEED AND
Comment.likes < CASE WHEN LIKE_LESS = -1 THEN ~0 ELSE LIKE_LESS END
ORDER BY
/*Need to do view count and subsciber count separately otherwise they will be compared as strings*/
CASE WHEN SORT_PARAM = 'Like Count' AND SORT_DIR = 'Descending' THEN Comment.likes END DESC, CASE WHEN SORT_PARAM = 'Like Count' AND SORT_DIR = 'Ascending' THEN Comment.likes END ASC, CASE WHEN SORT_PARAM = 'Comment Length' AND SORT_DIR = 'Descending' THEN LENGTH(text) END DESC, CASE WHEN SORT_PARAM = 'Comment Length' AND SORT_DIR = 'Ascending' THEN LENGTH(text) END ASC,
CASE WHEN SORT_DIR = 'Descending' THEN
CASE
WHEN SORT_PARAM = 'Datetime Created' THEN Comment.createdDate
WHEN SORT_PARAM = 'Comment (alphabetic)' THEN text
WHEN SORT_PARAM = 'Author Channel ID' THEN author_id
WHEN SORT_PARAM = 'Video ID Posted On' THEN Comment.video_id
ELSE comment_id
END
END DESC,
CASE WHEN SORT_DIR ='Ascending' THEN
CASE
WHEN SORT_PARAM = 'Datetime Created' THEN Comment.createdDate
WHEN SORT_PARAM = 'Comment (alphabetic)' THEN text
WHEN SORT_PARAM	= 'Author Channel ID' THEN author_id
WHEN SORT_PARAM	= 'Video ID Posted On' THEN Comment.video_id
ELSE comment_id
END
END ASC
LIMIT 18446744073709551615
) AS j

WHERE @rownum < MAX_RESULTS) as w;

END;
//
delimiter ;
