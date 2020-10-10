delimiter //
DROP PROCEDURE IF EXISTS getRepliesStatistics //
CREATE PROCEDURE getRepliesStatistics(IN MAX_RESULTS int, IN REPLY_COMMENT_ID_PARAM varchar(1000), IN ORIGINAL_COMMENT_ID_PARAM varchar(1000), IN SORT_PARAM varchar(50), IN SORT_DIR varchar(20), IN GET_COUNT int, IN GET_PER int)
BEGIN
set @rownum:=0;
SELECT
MAX(reply_comment_id),
COUNT(*) * 100 / (SELECT COUNT(*) FROM Reply) AS per,
CASE WHEN GET_COUNT = 1 THEN COUNT(*) ELSE NULL END

FROM (SELECT *, (@rownum:=@rownum+1) AS num FROM (SELECT * FROM Reply
WHERE
reply_comment_id = CASE WHEN LENGTH(REPLY_COMMENT_ID_PARAM) = 0 THEN reply_comment_id ELSE REPLY_COMMENT_ID_PARAM END AND
original_comment_id = CASE WHEN LENGTH(ORIGINAL_COMMENT_ID_PARAM) = 0 THEN original_comment_id ELSE ORIGINAL_COMMENT_ID_PARAM END
ORDER BY
CASE WHEN SORT_DIR = 'Descending' THEN
CASE
WHEN SORT_PARAM = 'Reply Comment ID' THEN reply_comment_id
WHEN SORT_PARAM = 'Original Comment ID' THEN original_comment_id
END
END DESC,
CASE WHEN SORT_DIR = 'Ascending' THEN
CASE
WHEN SORT_PARAM = 'Reply Comment ID' THEN reply_comment_id
WHEN SORT_PARAM = 'Original Comment ID' THEN original_comment_id
END
END ASC
LIMIT 18446744073709551615
) AS p
WHERE @rownum < MAX_RESULTS) as w;
END;
//
delimiter ;
