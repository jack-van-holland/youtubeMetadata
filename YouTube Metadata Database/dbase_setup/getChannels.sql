delimiter //
DROP PROCEDURE IF EXISTS getChannels //
CREATE PROCEDURE getChannels(IN MAX_RESULTS INT, IN CHANNEL_ID_PARAM varchar(1000), IN TITLE_CONTAIN varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin, IN TITLE_NOT_CONTAIN varchar(1000), IN TITLE_EXCEED int, IN TITLE_LESS int, IN TITLE_ALL_CAPS int, IN DESC_CONTAIN varchar(1000), IN DESC_NOT_CONTAIN varchar(1000), IN DESC_EXCEED int, IN DESC_LESS int, IN DESC_ALL_CAPS int, IN CREATED_BEFORE varchar(100), IN CREATED_AFTER varchar(100), IN SUB_EXCEED int, IN SUB_LESS int, IN VIEW_EXCEED int, IN VIEW_LESS int, IN COUNTRY_GIVEN char(2), IN SORT_PARAM varchar(50), IN SORT_DIR varchar(20), IN GET_CHANNEL_ID int, IN GET_TITLE int, IN GET_DATE int, IN GET_VIEWS int, IN GET_SUB int, IN GET_DESC int, IN GET_COUNTRY int)
BEGIN
set @rownum:=0;
SELECT (@rownum:=@rownum+1) AS num,
CASE WHEN GET_CHANNEL_ID = 1 THEN channel_id ELSE NULL END,
CASE WHEN GET_TITLE = 1 THEN title ELSE NULL END,
CASE WHEN GET_DATE = 1 THEN createdDate ELSE NULL END,
CASE WHEN GET_VIEWS = 1 THEN views ELSE NULL END,
CASE WHEN GET_SUB = 1 THEN subscribers ELSE NULL END,
CASE WHEN GET_DESC = 1 THEN description ELSE NULL END,
CASE WHEN GET_COUNTRY = 1 THEN country ELSE NULL END


FROM (SELECT * FROM Channel
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
CASE WHEN SORT_DIR = 'Ascending' THEN
CASE
WHEN SORT_PARAM = 'Datetime Created' THEN createdDate
WHEN SORT_PARAM = 'Title (alphabetic)' THEN title
WHEN SORT_PARAM = 'Description (alphabetic)' THEN description
WHEN SORT_PARAM = 'Country' THEN country
ELSE channel_id
END
END ASC
LIMIT 18446744073709551615
) AS p
WHERE @rownum < MAX_RESULTS;
END;
//
delimiter ;
