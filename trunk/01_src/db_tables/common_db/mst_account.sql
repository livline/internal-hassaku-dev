-- アカウント情報
CREATE TABLE mst_account
(
	account_id          INT UNSIGNED NOT NULL AUTO_INCREMENT        COMMENT 'アカウントID',				-- 自動採番される一意のID.システム内部で使用(基本的に見せない)
	user_id		INT UNSIGNED NOT NULL		COMMENT 'ユーザID',
	login_id      CHAR(8) NOT NULL                            COMMENT 'ログインID',
	password     CHAR(60) DEFAULT NULL                       COMMENT 'ログインパスワード',		-- ハッシュ値(NULLの場合は仮アカウント)
	kind_bit     TINYINT NOT NULL DEFAULT 0                  COMMENT 'アカウント区分bit',		-- 1: スーパーユーザ 10: 通常
	status       TINYINT NOT NULL DEFAULT 0                  COMMENT 'アカウント状態',			-- 1:仮登録 2:本登録 3:停止
	temp_dt      DATETIME DEFAULT NULL                       COMMENT 'アカウント仮登録日時',
	regist_dt    DATETIME DEFAULT NULL                       COMMENT 'アカウント本登録日時',
	stop_dt      DATETIME DEFAULT NULL                       COMMENT 'アカウント停止日時',
	admin_flag   TINYINT(1) NOT NULL DEFAULT 0               COMMENT 'システム関係者フラグ',	-- メンテ中もログインできる
	last_login_dt   DATETIME DEFAULT NULL                       COMMENT '最終ログイン日時',
	delete_flag  TINYINT(1) NOT NULL DEFAULT 0               COMMENT '削除フラグ',				-- 論理削除
	create_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
	updated_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',

PRIMARY KEY( account_id ),
UNIQUE KEY( login_id ),
UNIQUE KEY( user_id )
)
ENGINE=InnoDB default charset=utf8mb4;
