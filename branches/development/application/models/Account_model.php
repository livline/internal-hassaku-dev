<?php
/**
 * Account_model
 *
 */
class Account_model extends CI_model
{
	public function __construct()
	{

	}

	// ログインIDからアカウントデータを取得
	public function get_account_data_by_loginid( $login_id )
	{
		$sql = "
			SELECT
				usr.user_id,
				login_id,
				password,
				kind_bit,
				name_1,
				name_2,
				admin_flag,
				last_login_dt,
				dep.department_name
			FROM
				mst_account AS acc
			JOIN
				mst_user AS usr
			ON
				acc.user_id = usr.user_id
			JOIN
			(
				SELECT
					*
				FROM
					mst_tl_username AS a
				WHERE TRUE
				AND
					a.create_at = 
					(
						SELECT
							b.create_at
						FROM
							mst_tl_username AS b
						WHERE TRUE
						AND
							a.user_id = b.user_id
						AND
							b.create_at <= NOW()
						ORDER BY
							b.create_at DESC
						LIMIT 1
					)
			) AS unm
			ON
				acc.user_id = unm.user_id
			JOIN
			(
				SELECT
					*
				FROM
					mst_tl_departmentassignment_rel AS a
				WHERE TRUE
				AND
					a.create_at = 
					(
						SELECT
							b.create_at
						FROM
							mst_tl_departmentassignment_rel AS b
						WHERE TRUE
						AND
							a.user_id = b.user_id
						AND
							b.create_at <= NOW()
						AND
							b.apply_d <= NOW()
						ORDER BY
							b.create_at DESC
						LIMIT 1
					)
			) AS udp
			ON
				acc.user_id = udp.user_id
			JOIN
				mst_department AS dep
			ON
				dep.department_id = udp.department_id
			WHERE TRUE
			AND
				usr.delete_flag = 0
			AND
				login_id = ?
		";

		$ph = [ $login_id ];
		$res = get_instance()->common_db->query( $sql, $ph );
		if( $res === FALSE )
		{
			return FALSE;
		}

		if( $res->num_rows() == 0 )
		{
			return 0;
		}

		return $res->row_array();
	}

	// ユーザーIDからアカウントデータを取得
	public function get_account_data_by_userid( $user_id )
	{
		$sql = "
			SELECT
				acc.user_id,
				login_id,
				kind_bit,
				name_1,
				name_2,
				admin_flag,
				last_login_dt,
				dep.department_name
			FROM
				mst_account AS acc
			JOIN
				mst_user AS usr
			ON
				acc.user_id = usr.user_id
			JOIN
			(
				SELECT
					*
				FROM
					mst_tl_username AS a
				WHERE TRUE
				AND
					a.create_at = 
					(
						SELECT
							b.create_at
						FROM
							mst_tl_username AS b
						WHERE TRUE
						AND
							a.user_id = b.user_id
						AND
							b.create_at <= NOW()
						ORDER BY
							b.create_at DESC
						LIMIT 1
					)
			) AS unm
			ON
				acc.user_id = unm.user_id
			JOIN
			(
				SELECT
					*
				FROM
					mst_tl_departmentassignment_rel AS a
				WHERE TRUE
				AND
					a.create_at = 
					(
						SELECT
							b.create_at
						FROM
							mst_tl_departmentassignment_rel AS b
						WHERE TRUE
						AND
							a.user_id = b.user_id
						AND
							b.create_at <= NOW()
						AND
							b.apply_d <= NOW()
						ORDER BY
							b.create_at DESC
						LIMIT 1
					)
			) AS udp
			ON
				acc.user_id = udp.user_id
			JOIN
				mst_department AS dep
			ON
				dep.department_id = udp.department_id
			WHERE TRUE
			AND
				usr.delete_flag = 0
			AND
				user_id = ?
		";

		$ph = [ $user_id ];
		$res = get_instance()->common_db->query( $sql, $ph );
		if( $res === FALSE )
		{
			return FALSE;
		}

		if( $res->num_rows() == 0 )
		{
			return 0;
		}

		return $res->row_array();
	}

	// 指定アカウントのラストログイン時刻を更新する
	public function update_lastlogin( $user_id )
	{
		$sql = "
				UPDATE
					mst_account
				SET
					last_login_dt = CURRENT_TIMESTAMP
				WHERE
					user_id = ?;
			";
		$ph = [ $user_id ];
		$res = get_instance()->common_db->query( $sql, $ph );
		if( $res === FALSE )
		{
			return FALSE;
		}

		return TRUE;
	}

}