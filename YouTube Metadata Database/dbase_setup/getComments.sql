delimiter //
DROP PROCEDURE IF EXISTS getComments //
CREATE PROCEDURE getComments(IN MAX_RESULTS INT, IN COM_ID_PARAM varchar(1000), IN AUTH_ID_PARAM varchar(1000), IN VIDEO_ID_PARAM varchar(1000), IN COM_CONTAIN varchar(8000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin, IN COM_NOT_CONTAIN varchar(1000), IN COM_EXCEED int, IN COM_LESS int, IN CONTAIN_SUB int, IN ALL_CAPS INT, IN CREATED_BEFORE varchar(100), IN CREATED_AFTER varchar(100), IN CREATED_BEFORE_VIDEO_BOOL int, IN CREATED_BEFORE_VIDEO_SEC int, IN CREATED_BEFORE_VIDEO_MIN int, IN CREATED_BEFORE_VIDEO_HR int, IN CREATED_BEFORE_VIDEO_DAY int, IN CREATED_AFTER_VIDEO_BOOL int, IN CREATED_AFTER_VIDEO_SEC int, IN CREATED_AFTER_VIDEO_MIN int, IN CREATED_AFTER_VIDEO_HR int, IN CREATED_AFTER_VIDEO_DAY int, IN LIKE_EXCEED int, IN LIKE_LESS int, IN SORT_PARAM varchar(50), IN SORT_DIR varchar(20), IN GET_COM_ID int, IN GET_COM int, IN GET_AUTH_ID int, IN GET_VIDEO_ID int, IN GET_DATE int, IN GET_LIKE int, IN GET_VIDEO int)
BEGIN
set @rownum:=0;
SELECT (@rownum:=@rownum+1) AS num,
CASE WHEN GET_COM_ID = 1 THEN comment_id ELSE NULL END,
CASE WHEN GET_AUTH_ID = 1 THEN author_id ELSE NULL END,
CASE WHEN GET_VIDEO_ID = 1 THEN video_id ELSE NULL END,
CASE WHEN GET_DATE = 1 THEN createdDate ELSE NULL END,
CASE WHEN GET_LIKE = 1 THEN likes ELSE NULL END,
CASE WHEN GET_COM = 1 THEN text ELSE NULL END,
CASE WHEN GET_VIDEO = 1 THEN title ELSE NULL END

FROM (SELECT comment_id, Video.video_id, Video.title, author_id, Comment.createdDate, Video.createdDate AS videoCreatedDate, text, Comment.likes FROM Comment JOIN Video ON Comment.video_id = Video.video_id
WHERE
comment_id = CASE WHEN LENGTH(COM_ID_PARAM) = 0 THEN comment_id ELSE COM_ID_PARAM END AND
author_id = CASE WHEN LENGTH(AUTH_ID_PARAM) = 0 THEN author_id ELSE AUTH_ID_PARAM END AND
Comment.video_id = CASE WHEN LENGTH(VIDEO_ID_PARAM) = 0 THEN Comment.video_id ELSE VIDEO_ID_PARAM END AND
text LIKE CASE WHEN LENGTH(COM_CONTAIN) = 0 THEN text ELSE CONCAT("%", COM_CONTAIN, "%") END AND
text NOT LIKE CASE WHEN LENGTH(COM_NOT_CONTAIN) = 0 then CONCAT("a", text) ELSE CONCAT("%", COM_NOT_CONTAIN, "%") END AND
LENGTH(text) > COM_EXCEED AND
LENGTH(text) < CASE WHEN COM_LESS = -1 THEN ~0 ELSE COM_LESS END AND
text RLIKE CASE WHEN CONTAIN_SUB = 1 THEN replace(Video.title, ' ', '|') ELSE text END AND
text = CASE WHEN ALL_CAPS = 1 THEN BINARY UPPER(text) ELSE text END AND
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
) AS k

WHERE @rownum < MAX_RESULTS;

END;
//
delimiter ;
