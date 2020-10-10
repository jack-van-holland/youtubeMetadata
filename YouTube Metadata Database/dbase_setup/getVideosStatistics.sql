delimiter //
DROP PROCEDURE IF EXISTS getVideosStatistics //
CREATE PROCEDURE getVideosStatistics(IN MAX_RESULTS int, IN VIDEO_ID_PARAM varchar(1000), IN AUTH_ID_PARAM varchar(1000), IN TITLE_CONTAIN varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin, IN TITLE_NOT_CONTAIN varchar(1000), IN TITLE_EXCEED int, IN TITLE_LESS int, IN TITLE_ALL_CAPS int, IN DESC_CONTAIN varchar(1000), IN DESC_NOT_CONTAIN varchar(1000), IN DESC_EXCEED int, IN DESC_LESS int, IN DESC_ALL_CAPS int, IN CREATED_BEFORE varchar(100), IN CREATED_AFTER varchar(100), IN VIEW_EXCEED int, IN VIEW_LESS int, IN LIKE_EXCEED int, IN LIKE_LESS int, IN DISLIKE_EXCEED int, IN DISLIKE_LESS int, IN COM_EXCEED int, IN COM_LESS int, IN DURATION_EXCEED int, IN DURATION_LESS int, IN CATEGORY_GIVEN varchar(4), IN SORT_PARAM varchar(50), IN SORT_DIR varchar(20), IN GET_COUNT int, IN GET_PER int, IN AVE_VIEW int, IN MAX_VIEW int, IN MIN_VIEW int, IN STD_VIEW int, IN AVE_LIKE int, IN MAX_LIKE int, IN MIN_LIKE int, IN STD_LIKE int, IN AVE_DISLIKE int, IN MAX_DISLIKE int, IN MIN_DISLIKE int, IN STD_DISLIKE int, IN AVE_COM int, IN MAX_COM int, IN MIN_COM int, IN STD_COM int, IN AVE_DATE int, IN MAX_DATE int, IN MIN_DATE int, IN STD_DATE int, IN AVE_TITLE int, IN MAX_TITLE int, IN MIN_TITLE int, IN STD_TITLE int, IN AVE_DESC int, IN MAX_DESC int, IN MIN_DESC int, IN STD_DESC int, IN AVE_DURATION int, IN MAX_DURATION int, IN MIN_DURATION int, IN STD_DURATION int, IN CORRELATION_FIRST varchar(50), IN CORRELATION_SECOND varchar(50), IN RATIO_FIRST varchar(50), IN RATIO_SECOND varchar(50))
BEGIN
set @rownum:=0;
SELECT
MAX(video_id),
COUNT(*) * 100 / (SELECT COUNT(*) FROM Video) AS per,
CASE WHEN GET_COUNT = 1 THEN COUNT(*) ELSE NULL END,
CASE WHEN AVE_VIEW = 1 THEN AVG(views) ELSE NULL END,
CASE WHEN MAX_VIEW = 1 THEN MAX(views) ELSE NULL END,
CASE WHEN MIN_VIEW = 1 THEN MIN(views) ELSE NULL END,
CASE WHEN STD_VIEW = 1 THEN STDDEV(views) ELSE NULL END,
CASE WHEN AVE_LIKE = 1 THEN AVG(likes) ELSE NULL END,
CASE WHEN MAX_LIKE = 1 THEN MAX(likes) ELSE NULL END,
CASE WHEN MIN_LIKE = 1 THEN MIN(likes) ELSE NULL END,
CASE WHEN STD_LIKE = 1 THEN STDDEV(likes) ELSE NULL END,
CASE WHEN AVE_DISLIKE = 1 THEN AVG(dislikes) ELSE NULL END,
CASE WHEN MAX_DISLIKE = 1 THEN MAX(dislikes) ELSE NULL END,
CASE WHEN MIN_DISLIKE = 1 THEN MIN(dislikes) ELSE NULL END,
CASE WHEN STD_DISLIKE = 1 THEN STDDEV(dislikes) ELSE NULL END,
CASE WHEN AVE_COM = 1 THEN AVG(com_num) ELSE NULL END,
CASE WHEN MAX_COM = 1 THEN MAX(com_num) ELSE NULL END,
CASE WHEN MIN_COM = 1 THEN MIN(com_num) ELSE NULL END,
CASE WHEN STD_COM = 1 THEN STDDEV(com_num) ELSE NULL END,
CASE WHEN AVE_DATE = 1 THEN from_unixtime(AVG(unix_timestamp(createdDate))) ELSE NULL END,
CASE WHEN MAX_DATE = 1 THEN MAX(createdDate) ELSE NULL END,
CASE WHEN MIN_DATE = 1 THEN MIN(createdDate) ELSE NULL END,
CASE WHEN STD_DATE = 1 THEN STDDEV(unix_timestamp(createdDate)) / 60 / 60 / 24 ELSE NULL END,
CASE WHEN AVE_TITLE = 1 THEN AVG(LENGTH(title)) ELSE NULL END,
CASE WHEN MAX_TITLE = 1 THEN MAX(LENGTH(title)) ELSE NULL END,
CASE WHEN MIN_TITLE = 1 THEN MIN(LENGTH(title)) ELSE NULL END,
CASE WHEN STD_TITLE = 1 THEN STDDEV(LENGTH(title)) ELSE NULL END,
CASE WHEN AVE_DESC = 1 THEN AVG(LENGTH(description)) ELSE NULL END,
CASE WHEN MAX_DESC = 1 THEN MAX(LENGTH(description)) ELSE NULL END,
CASE WHEN MIN_DESC = 1 THEN MIN(LENGTH(description)) ELSE NULL END,
CASE WHEN STD_DESC = 1 THEN STDDEV(LENGTH(description)) ELSE NULL END,
CASE WHEN AVE_DURATION = 1 THEN AVG(duration) ELSE NULL END,
CASE WHEN MAX_DURATION = 1 THEN MAX(duration) ELSE NULL END,
CASE WHEN MIN_DURATION = 1 THEN MIN(duration) ELSE NULL END,
CASE WHEN STD_DURATION = 1 THEN STDDEV(duration) ELSE NULL END,
CASE RATIO_FIRST
WHEN 'View Count' THEN
     CASE RATIO_SECOND
     WHEN 'View Count' THEN AVG(views / views)
     WHEN 'Like Count' THEN AVG(views / likes)
     WHEN 'Dislike Count' THEN AVG(views / dislikes)
     WHEN 'Comment Count' THEN AVG(views / com_num)
     WHEN 'Length of Title' THEN AVG(views / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(views / LENGTH(description))
     WHEN 'Duration' THEN AVG(views / duration)
     ELSE NULL
     END
WHEN 'Like Count' THEN
     CASE RATIO_SECOND
     WHEN 'View Count' THEN AVG(likes / views)
     WHEN 'Like Count' THEN AVG(likes / likes)
     WHEN 'Dislike Count' THEN AVG(likes / dislikes)
     WHEN 'Comment Count' THEN AVG(likes / com_num)
     WHEN 'Length of Title' THEN AVG(likes / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(likes / LENGTH(description))
     WHEN 'Duration' THEN AVG(likes / duration)
     ELSE NULL
     END
WHEN 'Dislike Count' THEN
     CASE RATIO_SECOND
     WHEN 'View Count' THEN AVG(dislikes / views)
     WHEN 'Like Count' THEN AVG(dislikes / likes)
     WHEN 'Dislike Count' THEN AVG(dislikes / dislikes)
     WHEN 'Comment Count' THEN AVG(dislikes / com_num)
     WHEN 'Length of Title' THEN AVG(dislikes / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(dislikes / LENGTH(description))
     WHEN 'Duration' THEN AVG(dislikes / duration)
     ELSE NULL
     END
WHEN 'Comment Count' THEN
     CASE RATIO_SECOND
     WHEN 'View Count' THEN AVG(com_num / views)
     WHEN 'Like Count' THEN AVG(com_num / likes)
     WHEN 'Dislike Count' THEN AVG(com_num / dislikes)
     WHEN 'Comment Count' THEN AVG(com_num / com_num)
     WHEN 'Length of Title' THEN AVG(com_num / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(com_num / LENGTH(description))
     WHEN 'Duration' THEN AVG(com_num / duration)
     ELSE NULL
     END
WHEN 'Length of Title' THEN
     CASE RATIO_SECOND
     WHEN 'View Count' THEN AVG(LENGTH(title) / views)
     WHEN 'Like Count' THEN AVG(LENGTH(title) / likes)
     WHEN 'Dislike Count' THEN AVG(LENGTH(title) / dislikes)
     WHEN 'Comment Count' THEN AVG(LENGTH(title) / com_num)
     WHEN 'Length of Title' THEN AVG(LENGTH(title) / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(LENGTH(title) / LENGTH(description))
     WHEN 'Duration' THEN AVG(LENGTH(title) / duration)
     ELSE NULL
     END
WHEN 'Length of Description' THEN
     CASE RATIO_SECOND
     WHEN 'View Count' THEN AVG(LENGTH(description) / views)
     WHEN 'Like Count' THEN AVG(LENGTH(description) / likes)
     WHEN 'Dislike Count' THEN AVG(LENGTH(description) / dislikes)
     WHEN 'Comment Count' THEN AVG(LENGTH(description) / com_num)
     WHEN 'Length of Title' THEN AVG(LENGTH(description) / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(LENGTH(description) / LENGTH(description))
     WHEN 'Duration' THEN AVG(LENGTH(description) / duration)
     ELSE NULL
     END
WHEN 'Duration' THEN
     CASE RATIO_SECOND
     WHEN 'View Count' THEN AVG(duration / views)
     WHEN 'Like Count' THEN AVG(duration / likes)
     WHEN 'Dislike Count' THEN AVG(duration / dislikes)
     WHEN 'Comment Count' THEN AVG(duration / com_num)
     WHEN 'Length of Title' THEN AVG(duration / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(duration / LENGTH(description))
     WHEN 'Duration' THEN AVG(duration / duration)
     ELSE NULL
     END
ELSE NULL
END,
CASE CORRELATION_FIRST
WHEN 'View Count' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(views * views) - AVG(views) * AVG(views))/(STDDEV(views) * STDDEV(views)))
     WHEN 'Like Count' THEN ((AVG(likes * views) - AVG(views) * AVG(likes))/(STDDEV(likes) * STDDEV(views)))
     WHEN 'Dislike Count' THEN ((AVG(dislikes * views) - AVG(views) * AVG(dislikes))/(STDDEV(dislikes) * STDDEV(views)))
     WHEN 'Comment Count' THEN ((AVG(com_num * views) - AVG(views) * AVG(com_num))/(STDDEV(com_num) * STDDEV(views)))
     WHEN 'Datetime Posted' THEN ((AVG(unix_timestamp(createdDate) * views) - AVG(views) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(views)))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * views) - AVG(LENGTH(title)) * AVG(views))/(STDDEV(LENGTH(title)) * STDDEV(views)))
     WHEN 'Length of Description' THEN ((AVG(views * LENGTH(description)) - AVG(LENGTH(description)) * AVG(views))/(STDDEV(LENGTH(description)) * STDDEV(views)))
     WHEN 'Duration' THEN ((AVG(duration * views) - AVG(views) * AVG(duration))/(STDDEV(duration) * STDDEV(views)))
     ELSE NULL
     END
WHEN 'Like Count' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(views * likes) - AVG(likes) * AVG(views))/(STDDEV(views) * STDDEV(likes)))
     WHEN 'Like Count' THEN ((AVG(likes * likes) - AVG(likes) * AVG(likes))/(STDDEV(likes) * STDDEV(likes)))
     WHEN 'Dislike Count' THEN ((AVG(dislikes * likes) - AVG(likes) * AVG(dislikes))/(STDDEV(dislikes) * STDDEV(likes)))
     WHEN 'Comment Count' THEN ((AVG(com_num * likes) - AVG(likes) * AVG(com_num))/(STDDEV(com_num) * STDDEV(likes)))
     WHEN 'Datetime Posted' THEN ((AVG(unix_timestamp(createdDate) * likes) - AVG(likes) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(likes)))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * likes) - AVG(LENGTH(title)) * AVG(likes))/(STDDEV(LENGTH(title)) * STDDEV(likes)))
     WHEN 'Length of Description' THEN ((AVG(likes * LENGTH(description)) - AVG(LENGTH(description)) * AVG(likes))/(STDDEV(LENGTH(description)) * STDDEV(likes)))
     WHEN 'Duration' THEN ((AVG(duration * likes) - AVG(likes) * AVG(duration))/(STDDEV(duration) * STDDEV(likes)))
     ELSE NULL
     END
WHEN 'Dislike Count' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(views * dislikes) - AVG(dislikes) * AVG(views))/(STDDEV(views) * STDDEV(dislikes)))
     WHEN 'Like Count' THEN ((AVG(likes * dislikes) - AVG(dislikes) * AVG(likes))/(STDDEV(likes) * STDDEV(dislikes)))
     WHEN 'Dislike Count' THEN ((AVG(dislikes * dislikes) - AVG(dislikes) * AVG(dislikes))/(STDDEV(dislikes) * STDDEV(dislikes)))
     WHEN 'Comment Count' THEN ((AVG(com_num * dislikes) - AVG(dislikes) * AVG(com_num))/(STDDEV(com_num) * STDDEV(dislikes)))
     WHEN 'Datetime Posted' THEN ((AVG(unix_timestamp(createdDate) * dislikes) - AVG(dislikes) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(dislikes)))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * dislikes) - AVG(LENGTH(title)) * AVG(dislikes))/(STDDEV(LENGTH(title)) * STDDEV(dislikes)))
     WHEN 'Length of Description' THEN ((AVG(dislikes * LENGTH(description)) - AVG(LENGTH(description)) * AVG(dislikes))/(STDDEV(LENGTH(description)) * STDDEV(dislikes)))
     WHEN 'Duration' THEN ((AVG(duration * dislikes) - AVG(dislikes) * AVG(duration))/(STDDEV(duration) * STDDEV(dislikes)))
     ELSE NULL
     END
WHEN 'Comment Count' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(views * com_num) - AVG(com_num) * AVG(views))/(STDDEV(views) * STDDEV(com_num)))
     WHEN 'Like Count' THEN ((AVG(likes * com_num) - AVG(com_num) * AVG(likes))/(STDDEV(likes) * STDDEV(com_num)))
     WHEN 'Dislike Count' THEN ((AVG(dislikes * com_num) - AVG(com_num) * AVG(dislikes))/(STDDEV(dislikes) * STDDEV(com_num)))
     WHEN 'Comment Count' THEN ((AVG(com_num * com_num) - AVG(com_num) * AVG(com_num))/(STDDEV(com_num) * STDDEV(com_num)))
     WHEN 'Datetime Posted' THEN ((AVG(unix_timestamp(createdDate) * com_num) - AVG(com_num) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(com_num)))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * com_num) - AVG(LENGTH(title)) * AVG(com_num))/(STDDEV(LENGTH(title)) * STDDEV(com_num)))
     WHEN 'Length of Description' THEN ((AVG(com_num * LENGTH(description)) - AVG(LENGTH(description)) * AVG(com_num))/(STDDEV(LENGTH(description)) * STDDEV(com_num)))
     WHEN 'Duration' THEN ((AVG(duration * com_num) - AVG(com_num) * AVG(duration))/(STDDEV(duration) * STDDEV(com_num)))
     ELSE NULL
     END
WHEN 'Datetime Posted' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(unix_timestamp(createdDate) * views) - AVG(unix_timestamp(createdDate)) * AVG(views))/(STDDEV(views) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Like Count' THEN ((AVG(unix_timestamp(createdDate) * likes) - AVG(unix_timestamp(createdDate)) * AVG(likes))/(STDDEV(likes) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Dislike Count' THEN ((AVG(unix_timestamp(createdDate) * dislikes) - AVG(unix_timestamp(createdDate)) * AVG(dislikes))/(STDDEV(dislikes) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Comment Count' THEN ((AVG(unix_timestamp(createdDate) * com_num) - AVG(unix_timestamp(createdDate)) * AVG(com_num))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(com_num)))
     WHEN 'Datetime Posted' THEN ((AVG(unix_timestamp(createdDate) * unix_timestamp(createdDate)) - AVG(unix_timestamp(createdDate)) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * unix_timestamp(createdDate)) - AVG(LENGTH(title)) * AVG(unix_timestamp(createdDate)))/(STDDEV(LENGTH(title)) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Length of Description' THEN ((AVG(unix_timestamp(createdDate) * LENGTH(description)) - AVG(LENGTH(description)) * AVG(unix_timestamp(createdDate)))/(STDDEV(LENGTH(description)) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Duration' THEN ((AVG(unix_timestamp(createdDate) * duration) - AVG(unix_timestamp(createdDate)) * AVG(duration))/(STDDEV(duration) * STDDEV(unix_timestamp(createdDate))))
     ELSE NULL
     END
WHEN 'Length of Title' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(views * LENGTH(title)) - AVG(LENGTH(title)) * AVG(views))/(STDDEV(views) * STDDEV(LENGTH(title))))
     WHEN 'Like Count' THEN ((AVG(likes * LENGTH(title)) - AVG(LENGTH(title)) * AVG(likes))/(STDDEV(likes) * STDDEV(LENGTH(title))))
     WHEN 'Dislike Count' THEN ((AVG(dislikes * LENGTH(title)) - AVG(LENGTH(title)) * AVG(dislikes))/(STDDEV(dislikes) * STDDEV(LENGTH(title))))
     WHEN 'Comment Count' THEN ((AVG(LENGTH(title) * com_num) - AVG(LENGTH(title)) * AVG(com_num))/(STDDEV(com_num) * STDDEV(LENGTH(title))))
     WHEN 'Datetime Posted' THEN ((AVG(unix_timestamp(createdDate) * LENGTH(title)) - AVG(LENGTH(title)) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(LENGTH(title))))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * LENGTH(title)) - AVG(LENGTH(title)) * AVG(LENGTH(title)))/(STDDEV(LENGTH(title)) * STDDEV(LENGTH(title))))
     WHEN 'Length of Description' THEN ((AVG(LENGTH(title) * LENGTH(description)) - AVG(LENGTH(description)) * AVG(LENGTH(title)))/(STDDEV(LENGTH(description)) * STDDEV(LENGTH(title))))
     WHEN 'Duration' THEN ((AVG(duration * LENGTH(title)) - AVG(LENGTH(title)) * AVG(duration))/(STDDEV(duration) * STDDEV(LENGTH(title))))
     ELSE NULL
     END
WHEN 'Length of Description' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(views * LENGTH(description)) - AVG(LENGTH(description)) * AVG(views))/(STDDEV(views) * STDDEV(LENGTH(description))))
     WHEN 'Like Count' THEN ((AVG(likes * LENGTH(description)) - AVG(LENGTH(description)) * AVG(likes))/(STDDEV(likes) * STDDEV(LENGTH(description))))
     WHEN 'Dislike Count' THEN ((AVG(dislikes * LENGTH(description)) - AVG(LENGTH(description)) * AVG(dislikes))/(STDDEV(dislikes) * STDDEV(LENGTH(description))))
     WHEN 'Comment Count' THEN ((AVG(LENGTH(description) * com_num) - AVG(LENGTH(description)) * AVG(com_num))/(STDDEV(com_num) * STDDEV(LENGTH(description))))
     WHEN 'Datetime Posted' THEN ((AVG(unix_timestamp(createdDate) * LENGTH(description)) - AVG(LENGTH(description)) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(LENGTH(description))))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * LENGTH(description)) - AVG(LENGTH(title)) * AVG(LENGTH(description)))/(STDDEV(LENGTH(title)) * STDDEV(LENGTH(description))))
     WHEN 'Length of Description' THEN ((AVG(LENGTH(description) * LENGTH(description)) - AVG(LENGTH(description)) * AVG(LENGTH(description)))/(STDDEV(LENGTH(description)) * STDDEV(LENGTH(description))))
     WHEN 'Duration' THEN ((AVG(duration * LENGTH(description)) - AVG(LENGTH(description)) * AVG(duration))/(STDDEV(duration) * STDDEV(LENGTH(description))))
     ELSE NULL
     END
WHEN 'Duration' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(views * duration) - AVG(duration) * AVG(views))/(STDDEV(views) * STDDEV(duration)))
     WHEN 'Like Count' THEN ((AVG(likes * duration) - AVG(duration) * AVG(likes))/(STDDEV(likes) * STDDEV(duration)))
     WHEN 'Dislike Count' THEN ((AVG(dislikes * duration) - AVG(duration) * AVG(dislikes))/(STDDEV(dislikes) * STDDEV(duration)))
     WHEN 'Comment Count' THEN ((AVG(duration * com_num) - AVG(duration) * AVG(com_num))/(STDDEV(com_num) * STDDEV(duration)))
     WHEN 'Datetime Poasted' THEN ((AVG(unix_timestamp(createdDate) * duration) - AVG(duration) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(duration)))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * duration) - AVG(duration) * AVG(LENGTH(title)))/(STDDEV(LENGTH(title)) * STDDEV(duration)))
     WHEN 'Length of Description' THEN ((AVG(LENGTH(description) * duration) - AVG(duration) * AVG(LENGTH(description)))/(STDDEV(LENGTH(description)) * STDDEV(duration)))
     WHEN 'Duration' THEN ((AVG(duration * duration) - AVG(duration) * AVG(duration))/(STDDEV(duration) * STDDEV(duration)))
     ELSE NULL
     END
ELSE NULL
END

FROM(SELECT *, (@rownum:=@rownum+1) AS num FROM (SELECT * FROM (SELECT Video.video_id, Video.title, Video.channel_id, Video.createdDate, Video.category, Video.likes, Video.dislikes, Video.views, Video.description, Video.duration, COUNT(comment_id) AS com_num FROM Video LEFT JOIN Comment ON Video.video_id = Comment.video_id GROUP BY Video.video_id) AS f
WHERE
video_id = CASE WHEN LENGTH(VIDEO_ID_PARAM) = 0 THEN video_id ELSE VIDEO_ID_PARAM END AND
channel_id = CASE WHEN LENGTH(AUTH_ID_PARAM) = 0 THEN channel_id ELSE AUTH_ID_PARAM END AND
title LIKE CASE WHEN LENGTH(TITLE_CONTAIN) = 0 THEN title ELSE CONCAT("%", TITLE_CONTAIN, "%") END AND
title NOT LIKE CASE WHEN LENGTH(TITLE_NOT_CONTAIN) = 0 then CONCAT("a",title) ELSE CONCAT("%", TITLE_NOT_CONTAIN, "%") END AND
LENGTH(title) > TITLE_EXCEED AND
LENGTH(title) < CASE WHEN TITLE_LESS = -1 THEN ~0 ELSE TITLE_LESS END AND
title = CASE WHEN TITLE_ALL_CAPS = 1 THEN BINARY UPPER(title) ELSE title END AND
description LIKE CASE WHEN LENGTH(DESC_CONTAIN) = 0 THEN description ELSE CONCAT("%", DESC_CONTAIN, "%") END AND
description NOT LIKE CASE WHEN LENGTH(DESC_NOT_CONTAIN) = 0 THEN CONCAT("a", description) ELSE CONCAT("%", DESC_NOT_CONTAIN, "%") END AND
LENGTH(description) > DESC_EXCEED AND
LENGTH(description) < CASE WHEN DESC_LESS = -1 THEN ~0 ELSE DESC_LESS END AND
description = CASE WHEN DESC_ALL_CAPS = 1 THEN BINARY UPPER(description) ELSE description END AND
createdDate < CREATED_BEFORE AND
createdDate > CREATED_AFTER AND
views > VIEW_EXCEED AND
views < CASE WHEN VIEW_LESS = -1 THEN ~0 ELSE VIEW_LESS END AND
likes > LIKE_EXCEED AND
likes < CASE WHEN LIKE_LESS = -1 THEN ~0 ELSE LIKE_LESS END AND
dislikes > DISLIKE_EXCEED AND
dislikes < CASE WHEN DISLIKE_LESS = -1 THEN ~0 ELSE DISLIKE_LESS END AND
com_num > COM_EXCEED AND
com_num < CASE WHEN COM_LESS = -1 THEN ~0 ELSE COM_LESS END AND
duration > DURATION_EXCEED AND
duration < CASE WHEN DURATION_LESS =-1 THEN ~0 ELSE DURATION_LESS END AND
category = CASE WHEN LENGTH(CATEGORY_GIVEN) = 0 THEN category ELSE CATEGORY_GIVEN END
ORDER BY
CASE WHEN SORT_PARAM = 'View Count' AND SORT_DIR = 'Descending' THEN views END DESC, CASE WHEN SORT_PARAM = 'View Count' AND SORT_DIR = 'Ascending' THEN views END ASC, CASE WHEN SORT_PARAM = 'Like Count' AND SORT_DIR = 'Descending' THEN likes END DESC, CASE WHEN SORT_PARAM = 'Like Count' AND SORT_DIR = 'Ascendi\
ng' THEN likes END ASC, CASE WHEN SORT_PARAM = 'Dislike Count' AND SORT_DIR = 'Descending' THEN dislikes END DESC, CASE WHEN SORT_PARAM = 'Dislike Count' AND SORT_DIR = 'Ascending' THEN dislikes END ASC, CASE WHEN SORT_PARAM = 'Comment Count' AND SORT_DIR = 'Descending' THEN com_num END DESC, CASE WHEN SORT_PARAM = 'Comment Count' AND SORT_DIR = 'Ascending' THEN com_num END ASC, CASE WHEN SORT_PARAM = 'Duration' AND SORT_DIR = 'Descending' THEN duration END DESC, CASE WHEN SORT_PARAM = 'Duration' AND SORT_DIR = 'Ascending' THEN duration END ASC, CASE WHEN SORT_PARAM = 'Title Length' AND SORT_DIR = 'Descending' THEN LENGTH(title) END DESC, CASE WHEN SORT_PARAM = 'Title Length' AND SORT_DIR = 'Ascending' THEN LENGTH(title) END ASC, CASE WHEN SORT_PARAM = 'Description Length' AND SORT_DIR = 'De\
scending' THEN LENGTH(description) END DESC, CASE WHEN SORT_PARAM = 'Description Length' AND SORT_DIR = 'Ascending' THEN LENGTH(description) END ASC,
CASE WHEN SORT_DIR = 'Descending' THEN
CASE
WHEN SORT_PARAM = 'Datetime Posted' THEN createdDate
WHEN SORT_PARAM = 'Title (alphabetic)' THEN title
WHEN SORT_PARAM = 'Description (alphabetic)' THEN description
WHEN SORT_PARAM = 'Category' THEN category
WHEN SORT_PARAM = 'Channel ID' THEN channel_id
ELSE video_id
END
END DESC,
CASE WHEN SORT_DIR = 'Ascending' THEN
CASE
WHEN SORT_PARAM = 'Datetime Posted' THEN createdDate
WHEN SORT_PARAM = 'Title (alphabetic)' THEN title
WHEN SORT_PARAM = 'Description (alphabetic)' THEN description
WHEN SORT_PARAM = 'Category' THEN category
WHEN SORT_PARAM = 'Channel ID' THEN channel_id
ELSE video_id
END
END ASC
LIMIT 18446744073709551615
) AS p
WHERE @rownum < MAX_RESULTS) AS r;
END;
//
delimiter ;
