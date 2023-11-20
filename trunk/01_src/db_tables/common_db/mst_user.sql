-- 従業員基本情報
/*
*/
CREATE TABLE mst_user
(
	user_id              INT UNSIGNED NOT NULL AUTO_INCREMENT        COMMENT '従業員ID',
	employment_no VARCHAR(10) DEFAULT NULL COMMENT '社員No.',
	employment_dt	    DATE NOT NULL                               COMMENT '入社日',
	retirement_dt	    DATE NULL DEFAULT NULL                               COMMENT '退社日',
	delete_flag	TINYINT(1) NOT NULL DEFAULT 0	COMMENT '削除フラグ',		-- 0: 未削除 / 1: 削除済
	create_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
	updated_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',

	PRIMARY KEY( user_id )
)
ENGINE=InnoDB default charset=utf8mb4;
