delimiter //
DROP PROCEDURE IF EXISTS getChannelsStatistics //
CREATE PROCEDURE getChannelsStatistics(IN MAX_RESULTS INT, IN CHANNEL_ID_PARAM varchar(1000), IN TITLE_CONTAIN varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin, IN TITLE_NOT_CONTAIN varchar(1000), IN TITLE_EXCEED int, IN TITLE_LESS int, IN TITLE_ALL_CAPS int, IN DESC_CONTAIN varchar(1000), IN DESC_NOT_CONTAIN varchar(1000), IN DESC_EXCEED int, IN DESC_LESS int, IN DESC_ALL_CAPS int, IN CREATED_BEFORE varchar(100), IN CREATED_AFTER varchar(100), IN SUB_EXCEED int, IN SUB_LESS int, IN VIEW_EXCEED int, IN VIEW_LESS int,IN COUNTRY_GIVEN char(2), IN SORT_PARAM varchar(50), IN SORT_DIR varchar(20), IN GET_COUNT int, IN GET_PER int, IN AVE_SUB int, IN MAX_SUB int, IN MIN_SUB int, IN STD_SUB int, IN AVE_VIEW int, IN MAX_VIEW int, IN MIN_VIEW int, IN STD_VIEW int, IN AVE_DATE int, IN MAX_DATE int, IN MIN_DATE int, IN STD_DATE int, IN AVE_TITLE int, IN MAX_TITLE int, IN MIN_TITLE int, IN STD_TITLE int, IN AVE_DESC int, IN MAX_DESC int, IN MIN_DESC int, IN STD_DESC int, IN CORRELATION_FIRST varchar(50), IN CORRELATION_SECOND varchar(50), IN RATIO_FIRST varchar(50), IN RATIO_SECOND varchar(50))
BEGIN
set @rownum:=0;
SELECT
MAX(channel_id),
COUNT(*) * 100 / (SELECT COUNT(*) FROM Channel) AS per,
CASE WHEN GET_COUNT = 1 THEN COUNT(*) ELSE NULL END,
CASE WHEN AVE_SUB = 1 THEN AVG(subscribers) ELSE NULL END,
CASE WHEN MAX_SUB = 1 THEN MAX(subscribers) ELSE NULL END,
CASE WHEN MIN_SUB = 1 THEN MIN(subscribers) ELSE NULL END,
CASE WHEN STD_SUB = 1 THEN STDDEV(subscribers) ELSE NULL END,
CASE WHEN AVE_VIEW = 1 THEN AVG(views) ELSE NULL END,
CASE WHEN MAX_VIEW = 1 THEN MAX(views) ELSE NULL END,
CASE WHEN MIN_VIEW = 1 THEN MIN(views) ELSE NULL END,
CASE WHEN STD_VIEW = 1 THEN STDDEV(views) ELSE NULL END,
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
CASE RATIO_FIRST
WHEN 'Subscriber Count' THEN
     CASE RATIO_SECOND
     WHEN 'Subscriber Count' THEN AVG(subscribers / subscribers)
     WHEN 'View Count' THEN AVG(subscribers / views)
     WHEN 'Length of Title' THEN AVG(subscribers / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(subscribers / LENGTH(description))
     ELSE NULL
     END
WHEN 'View Count' THEN
     CASE RATIO_SECOND
     WHEN 'Subscriber Count' THEN AVG(views / subscribers)
     WHEN 'View Count' THEN AVG(views / views)
     WHEN 'Length of Title' THEN AVG(views / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(views / LENGTH(description))
     ELSE NULL
     END
WHEN 'Length of Title' THEN
     CASE RATIO_SECOND
     WHEN 'Subscriber Count' THEN AVG(LENGTH(title) / subscribers)
     WHEN 'View Count' THEN AVG(LENGTH(title) / views)
     WHEN 'Length of Title' THEN AVG(LENGTH(title) / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(LENGTH(title) / LENGTH(description))
     ELSE NULL
     END
WHEN 'Length of Description' THEN
     CASE RATIO_SECOND
     WHEN 'Subscriber Count' THEN AVG(LENGTH(description) / subscribers)
     WHEN 'View Count' THEN AVG(LENGTH(description) / views)
     WHEN 'Length of Title' THEN AVG(LENGTH(description) / LENGTH(title))
     WHEN 'Length of Description' THEN AVG(LENGTH(description) / LENGTH(description))
     ELSE NULL
     END
ELSE NULL
END,
CASE CORRELATION_FIRST
WHEN 'Subscriber Count' THEN
     CASE CORRELATION_SECOND
     WHEN 'Subscriber Count' THEN ((AVG(subscribers * subscribers) - AVG(subscribers) * AVG(subscribers))/(STDDEV(subscribers) * STDDEV(subscribers)))
     WHEN 'View Count' THEN ((AVG(views * subscribers) - AVG(subscribers) * AVG(views))/(STDDEV(views) * STDDEV(subscribers)))
     WHEN 'Datetime Created' THEN ((AVG(unix_timestamp(createdDate) * subscribers) - AVG(subscribers) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(subscribers)))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * subscribers) - AVG(LENGTH(title)) * AVG(subscribers))/(STDDEV(LENGTH(title)) * STDDEV(subscribers)))
     WHEN 'Length of Description' THEN ((AVG(subscribers * LENGTH(description)) - AVG(LENGTH(description)) * AVG(subscribers))/(STDDEV(LENGTH(description)) * STDDEV(subscribers)))
     ELSE NULL
     END
WHEN 'View Count' THEN
     CASE CORRELATION_SECOND
     WHEN 'View Count' THEN ((AVG(views * views) - AVG(views) * AVG(views))/(STDDEV(views) * STDDEV(views)))
     WHEN 'Subscriber Count' THEN ((AVG(views * subscribers) - AVG(subscribers) * AVG(views))/(STDDEV(views) * STDDEV(subscribers)))
     WHEN 'Datetime Created' THEN ((AVG(unix_timestamp(createdDate) * views) - AVG(views) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(views)))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * views) - AVG(LENGTH(title)) * AVG(views))/(STDDEV(LENGTH(title)) * STDDEV(views)))
     WHEN 'Length of Description' THEN ((AVG(views * LENGTH(description)) - AVG(LENGTH(description)) * AVG(views))/(STDDEV(LENGTH(description)) * STDDEV(views)))
     ELSE NULL
     END
WHEN 'Datetime Created' THEN
     CASE CORRELATION_SECOND
     WHEN 'Subscriber Count' THEN ((AVG(unix_timestamp(createdDate) * subscribers) - AVG(unix_timestamp(createdDate)) * AVG(subscribers))/(STDDEV(subscribers) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'View Count' THEN ((AVG(views * unix_timestamp(createdDate)) - AVG(unix_timestamp(createdDate)) * AVG(views))/(STDDEV(views) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Datetime Created' THEN ((AVG(unix_timestamp(createdDate) * unix_timestamp(createdDate)) - AVG(unix_timestamp(createdDate)) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * unix_timestamp(createdDate)) - AVG(LENGTH(title)) * AVG(unix_timestamp(createdDate)))/(STDDEV(LENGTH(title)) * STDDEV(unix_timestamp(createdDate))))
     WHEN 'Length of Description' THEN ((AVG(unix_timestamp(createdDate) * LENGTH(description)) - AVG(LENGTH(description)) * AVG(unix_timestamp(createdDate)))/(STDDEV(LENGTH(description)) * STDDEV(unix_timestamp(createdDate))))
     ELSE NULL
     END
WHEN 'Length of Title' THEN
     CASE CORRELATION_SECOND
     WHEN 'Subscriber Count' THEN ((AVG(LENGTH(title) * subscribers) - AVG(LENGTH(title)) * AVG(subscribers))/(STDDEV(LENGTH(title)) * STDDEV(subscribers)))
     WHEN 'View Count' THEN ((AVG(views * LENGTH(title)) - AVG(LENGTH(title)) * AVG(views))/(STDDEV(views) * STDDEV(LENGTH(title))))
     WHEN 'Datetime Created' THEN ((AVG(unix_timestamp(createdDate) * LENGTH(title)) - AVG(LENGTH(title)) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(LENGTH(title))))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * LENGTH(title)) - AVG(LENGTH(title)) * AVG(LENGTH(title)))/(STDDEV(LENGTH(title)) * STDDEV(LENGTH(title))))
     WHEN 'Length of Description' THEN ((AVG(LENGTH(title) * LENGTH(description)) - AVG(LENGTH(description)) * AVG(LENGTH(title)))/(STDDEV(LENGTH(description)) * STDDEV(LENGTH(title))))
     ELSE NULL
     END
WHEN 'Length of Description' THEN
     CASE CORRELATION_SECOND
     WHEN 'Subscriber Count' THEN ((AVG(LENGTH(description) * subscribers) - AVG(LENGTH(description)) * AVG(subscribers))/(STDDEV(subscribers) * STDDEV(LENGTH(description))))
     WHEN 'View Count' THEN ((AVG(views * LENGTH(description)) - AVG(LENGTH(description)) * AVG(views))/(STDDEV(views) * STDDEV(LENGTH(description))))
     WHEN 'Datetime Created' THEN ((AVG(unix_timestamp(createdDate) * LENGTH(description)) - AVG(LENGTH(description)) * AVG(unix_timestamp(createdDate)))/(STDDEV(unix_timestamp(createdDate)) * STDDEV(LENGTH(description))))
     WHEN 'Length of Title' THEN ((AVG(LENGTH(title) * LENGTH(description)) - AVG(LENGTH(title)) * AVG(LENGTH(description)))/(STDDEV(LENGTH(title)) * STDDEV(LENGTH(description))))
     WHEN 'Length of Description' THEN ((AVG(LENGTH(description) * LENGTH(description)) - AVG(LENGTH(description)) * AVG(LENGTH(description)))/(STDDEV(LENGTH(description)) * STDDEV(LENGTH(description))))
     ELSE NULL
     END
ELSE NULL
END

FROM(SELECT *, (@rownum:=@rownum+1) AS num FROM (SELECT * FROM Channel
WHERE
channel_id = CASE WHEN LENGTH(CHANNEL_ID_PARAM) = 0 THEN channel_id ELSE CHANNEL_ID_PARAM END AND
title LIKE CASE WHEN LENGTH(TITLE_CONTAIN) = 0 THEN title ELSE CONCAT("%", TITLE_CONTAIN, "%") END AND
title NOT LIKE CASE WHEN LENGTH(TITLE_NOT_CONTAIN) = 0 then CONCAT("a", title) ELSE CONCAT("%", TITLE_NOT_CONTAIN, "%") END AND
LENGTH(title) > TITLE_EXCEED AND
LENGTH(title) < CASE WHEN TITLE_LESS = -1 THEN ~0 ELSE TITLE_LESS END AND
title = CASE WHEN TITLE_ALL_CAPS = 1 THEN BINARY UPPER(title) ELSE title END AND
description LIKE CASE WHEN LENGTH(DESC_CONTAIN) = 0 THEN description ELSE CONCAT("%", DESC_CONTAIN, "%") END AND
description NOT LIKE CASE WHEN LENGTH(DESC_NOT_CONTAIN) = 0 then CONCAT("a", description) ELSE CONCAT("%", DESC_NOT_CONTAIN, "%") END AND
LENGTH(description) > DESC_EXCEED AND
LENGTH(description) < CASE WHEN DESC_LESS = -1 THEN ~0 ELSE DESC_LESS END AND
description = CASE WHEN DESC_ALL_CAPS = 1 THEN BINARY UPPER(description) ELSE description END AND
createdDate < CREATED_BEFORE AND 
createdDate > CREATED_AFTER AND
subscribers > SUB_EXCEED AND
subscribers < CASE WHEN SUB_LESS = -1 THEN ~0 ELSE SUB_LESS END AND
views > VIEW_EXCEED AND
views < CASE WHEN VIEW_LESS = -1 THEN ~0 ELSE VIEW_LESS END AND
country = CASE WHEN LENGTH(COUNTRY_GIVEN) = 0 THEN country ELSE COUNTRY_GIVEN END
ORDER BY
/*Need to do view count and subsciber count separately otherwise they will be compared as strings*/
CASE WHEN SORT_PARAM = 'Subscriber Count' AND SORT_DIR = 'Descending' THEN subscribers END DESC, CASE WHEN SORT_PARAM = 'Subscriber Count' AND SORT_DIR = 'Ascending' THEN subscribers END ASC, CASE WHEN SORT_PARAM = 'View Count' AND SORT_DIR = 'Descending' THEN views END DESC, CASE WHEN SORT_PARAM = 'View Count' AND SORT_DIR = 'Ascending' THEN views END ASC, CASE WHEN SORT_PARAM = 'Title Length' AND SORT_DIR = 'Descending' THEN LENGTH(title) END DESC, CASE WHEN SORT_PARAM = 'Title Length' AND SORT_DIR = 'Ascending' THEN LENGTH(title) END ASC, CASE WHEN SORT_PARAM = 'Description Length' AND SORT_DIR = 'Descending' THEN LENGTH(description) END DESC, CASE WHEN SORT_PARAM = 'Description Length' AND SORT_DIR = 'Ascending' THEN LENGTH(description) END ASC,
CASE WHEN SORT_DIR = 'Descending' THEN
CASE
WHEN SORT_PARAM = 'Datetime Created' THEN createdDate
WHEN SORT_PARAM = 'Title (alphabetic)' THEN title
WHEN SORT_PARAM = 'Description (alphabetic)' THEN description
WHEN SORT_PARAM = 'Country' THEN country
ELSE channel_id
END
END DESC,
CASE WHEN SORT_DIR ='Ascending' THEN
CASE
WHEN SORT_PARAM = 'Datetime Created' THEN createdDate
WHEN SORT_PARAM = 'Title (alphabetic)' THEN title
WHEN SORT_PARAM = 'Description (alphabetic)' THEN description
WHEN SORT_PARAM = 'Country' THEN country
ELSE channel_id
END
END ASC
LIMIT 18446744073709551615
) AS z

WHERE @rownum < MAX_RESULTS) AS h;

END;
//
delimiter ;
