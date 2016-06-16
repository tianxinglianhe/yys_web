<?php

/**
 * Class a4MySQL
 * MySQL操作类
 */
class a4MySQL
{

	/********数据库设置********/
	/*数据库链接*/
	private $_conn = null;
	/*数据库表名*/
	private $_tableName = null;
	/*数据库字符集*/
	private $_charset = null;

	/********[finish]********/

	/********操作设置********/
	/*完整的sql语句*/
	private $_sql = null;
	/*被限定的操作字段*/
	private $_field = null;
	/*查询条件*/
	private $_where = null;
	/*外键查询限制*/
	private $_innerJoin = null;
	/*排序条件*/
	private $_order = null;
	/*组合*/
	private $_group = null;
	/********[finish]********/

	/********分页设置********/
	/*页容量*/
	private $_pageSize = 0;
	/*最大页数*/
	private $_pageMax = 0;
	/*条目总数*/
	private $_count = 0;
	/*当前页*/
	private $_pageNow = 1;
	/*读取数据库结果*/
	private $_queryRes = array();
	/********[finish]********/

	/**
	 * a4MySQL constructor
	 * 创建数据库链接
	 */
	public function __construct($TABLE_NAME, $CHARSET = '', $OUTPUT_CHAR = '')
	{
		$config = a4getConf();
		if (a4isEmpty($CHARSET)) {
			$this->_charset = $config['database']['charset'];
		} else {
			$this->_charset = trim($CHARSET);
		}
		$this->_tableName = trim($TABLE_NAME);
		$this->_conn = new mysqli($config['database']['host'], $config['database']['user'], $config['database']['pwd'], $config['database']['name'], $config['database']['port']);
		if (!$this->_conn) {
			die($this->_conn);
		}
	}

	/**
	 * 析构函数
	 * 关闭连接
	 * 释放资源
	 */
	public function __destruct()
	{
		unset($this->_queryRes);
		$this->_conn->close();
	}

	/**
	 * 清空搜索结果
	 */
	public function refresh()
	{
		$this->_sql = '';
		$this->_field = '';
		$this->_where = '';
		$this->_innerJoin = '';
		$this->_order = '';
		$this->_group = '';
		$this->_pageSize = 0;
		$this->_pageMax = 0;
		$this->_count = 0;
		$this->_pageNow = 1;
		$this->_queryRes = array();
	}

	/**
	 * 限定操作的字段名称
	 *
	 * @param array|string $DATA 可接受数组/post/get和null四种形式
	 * array：将数组中对应的名称匹配到SQL语句
	 * post：将$_POST匹配到SQL语句
	 * get：将$_GET匹配到SQL语句
	 * null： 将查询所有字段到SQL语句
	 *
	 * @return object
	 */
	public function field($DATA = null)
	{
		$this->_field = '';
		if ($DATA == 'post') {
			foreach ($_POST as $key => $item) {
				$this->_field .= '`' . $this->_tableName . '`.' . '`' . $key . '`, ';
			}
		} elseif ($DATA == null) {
			$this->_field = ' * ';
		} elseif ($DATA == 'get') {
			foreach ($_GET as $key => $item) {
				$this->_field .= '`' . $this->_tableName . '`.' . '`' . $key . '`, ';
			}
		} else {
			foreach ($DATA as $item) {
				if (is_array($item)) {
					//使用别名读取
					$this->_field .= '`' . $this->_tableName . '`.' . '`' . $item[0] . '` AS ' . $item[1] . ', ';
				} else {
					//使用默认名称读取
					$this->_field .= '`' . $this->_tableName . '`.' . '`' . $item . '`, ';
				}
			}
		}
		return $this;
	}

	/**
	 * 搜索条件
	 *
	 * @param array $DATA
	 * 接受数组和字符串类型
	 *
	 * @return object
	 */
	public function where($DATA = null)
	{
		$where = array();
		$this->_where = 'WHERE';
		$link = '';
		//通过数组进行条件拼接
		foreach ($DATA as $key => $item) {
			/* *拆分条件语句* */
			switch ($item[0]) {
				case 'eq' :
					if (a4admixStrlen($item[2]) > 0) {
						$link = $item[2];
					}
					$where[] = " `$this->_tableName`.`$key` = '" . $item[1] . "' " . strtoupper($link);
					break;
				case 'neq' :
					if (a4admixStrlen($item[2]) > 0) {
						$link = $item[2];
					}
					$where[] = " `$this->_tableName`.`$key` <> '" . $item[1] . "' " . strtoupper($link);
					break;
				case 'lt' :
					if (a4admixStrlen($item[2]) > 0) {
						$link = $item[2];
					}
					$where[] = " `$this->_tableName`.`$key` < '" . $item[1] . "' " . strtoupper($link);
					break;
				case 'gt' :
					if (a4admixStrlen($item[2]) > 0) {
						$link = $item[2];
					}
					$where[] = " `$this->_tableName`.`$key` > '" . $item[1] . "' " . strtoupper($link);
					break;
				case 'lteq' :
					if (a4admixStrlen($item[2]) > 0) {
						$link = $item[2];
					}
					$where[] = " `$this->_tableName`.`$key` <= '" . $item[1] . "' " . strtoupper($link);
					break;
				case 'gteq' :
					if (a4admixStrlen($item[2]) > 0) {
						$link = $item[2];
					}
					$where[] = " `$this->_tableName`.`$key` >= '" . $item[1] . "' " . strtoupper($link);
					break;
				case 'like' :
					if (a4admixStrlen($item[2]) > 0) {
						$link = $item[2];
					}
					$where[] = " `$this->_tableName`.`$key` LIKE '" . $item[1] . "' " . strtoupper($link);
					break;
			}
		}
		foreach ($where as $item) {
			$this->_where .= $item;
		}
		$this->_where = trim($this->_where, ' AND');
		return $this;
	}

	/**
	 * 排序条件
	 *
	 * @param string $FIELD 排序依据
	 * @param string $ORDER 排序顺序 默认：ASC正序
	 *
	 * @return object
	 */
	public function order($FIELD, $ORDER = 'ASC')
	{
		$this->_order = '';
		if (!a4isEmpty($FIELD)) {
			$this->_order = ' ORDER BY `' . $this->_tableName . '`.`' . trim($FIELD) . '` ' . $ORDER;
		}
		return $this;
	}

	/**
	 * 外键链接查询
	 *
	 * @param array $ARRAY 外键查询条件
	 *
	 * @return object
	 */
	public function inner_join($ARRAY)
	{
		$this->_innerJoin = '';
		$innerJoin = array();
		if (is_array($ARRAY)) {
			foreach ($ARRAY as $key => $item) {
				$innerJoin[] = "`$key` ON `$key`.`$item[0]` = `$this->_tableName`.`$item[1]`";
			}
		}
		for ($i = 0; $i < count($innerJoin); $i++) {
			$this->_innerJoin .= 'INNER JOIN ' . $innerJoin[$i] . ' ';
		}
		return $this;
	}

	/**
	 * 设置外键查询字段
	 *
	 * @param array $FIELD_NAME 外键查询字段
	 * 格式：
	 * array(
	 *     表名1 => array(字段名1=>别名，字段名2=>别名，字段名3=>别名),
	 *     表名2 => array(字段名1=>别名，字段名2=>别名，字段名3=>别名),
	 *     表名3 => array(字段名1=>别名，字段名2=>别名，字段名3=>别名),
	 * );
	 *
	 * @return object
	 */
	public function inner_join_field($FIELD_NAME)
	{
		foreach ($FIELD_NAME as $key => $item) {
			foreach ($item as $k => $v) {
				if (is_array($item)) {
					$this->_field .= '`' . $key . '`.`' . $k . '` AS ' . $v . ', ';
				} else {
					$this->_field .= '`' . $key . '`.`' . $item . '`, ';
				}
			}
		}
		return $this;
	}

	/**
	 * 执行查询
	 *
	 * @param bool|false $RETURN_SQL 是否返回SQL语句 默认：false
	 *
	 * @return array|bool
	 */
	public function select($RETURN_SQL = false)
	{
		//设置字符集
		$this->_conn->query('SET NAMES ' . $this->_charset);
		//组合SQL语句
		$this->combo_sql();
		//执行SQL语句
		switch ($RETURN_SQL) {
			case true :
				return $this->_sql;
				break;
			case false :
				$queryRes = $this->_conn->query($this->_sql);
				if ($queryRes) {
					while ($row = $queryRes->fetch_assoc()) {
						$this->_queryRes[] = $row;
					}
					unset($queryRes);
					if ($this->_charset != $this->_output_char) {
						return $this->_queryRes;
					}
				} else {
					return $this->_conn->error;
				}
				break;
		}
	}

	/**
	 * 组合SQL语句
	 *
	 * @param int $LIMIT 分页凭证
	 */
	public function combo_sql($LIMIT = -1)
	{
		//拼接SQL语句
		$sql = '';
		if (a4isEmpty($this->_field)) {
			$sql .= ' * ';
		} else {
			$this->_field = trim($this->_field, ', ');
			$this->_field .= ' ';
			$sql .= $this->_field;
		}
		if ($LIMIT < 0) {
			$this->_sql = 'SELECT ' . $sql . ' FROM `' . $this->_tableName . '` ' . $this->_innerJoin . $this->_where . $this->_order;
		} else {
			$this->_sql = 'SELECT ' . $sql . ' FROM `' . $this->_tableName . '` ' . $this->_innerJoin . $this->_where . $this->_order . ' LIMIT ' . $LIMIT . ',' . $this->_pageSize;
		}
	}

	/**
	 * 设置页容量 同时获取最大页数和条目总数
	 *
	 * @param int $PAGE_SIZE 页容量 默认：30
	 *
	 * @return object
	 */
	public function set_page_size($PAGE_SIZE = 30)
	{
		//拼接SQL语句
		$sql = 'SELECT COUNT(*) FROM `' . $this->_tableName . '` ' . $this->_where;
		$query_res = $this->_conn->query($sql);
		if ($query_res) {
			while ($row = $query_res->fetch_assoc()) {
				$this->_queryRes = $row;
			}
			unset($query_res);
		}
		//获取分页条目总数
		$this->_count = $this->_queryRes['COUNT(*)'];
		unset($this->_queryRes);
		if ($PAGE_SIZE < 1) {
			$this->_pageSize = 1;
		} elseif ($PAGE_SIZE > $this->_count) {
			$this->_pageSize = $this->_count;
		} else {
			$this->_pageSize = $PAGE_SIZE;
		}
		$this->_pageMax = ceil($this->_count / $this->_pageSize);
		return $this;
	}

	/**
	 * 执行分页读取
	 *
	 * @param int $PAGE_NOW 当前页
	 * @param bool|false $RETURN_SQL 是否返回SQL语句
	 * @return array|bool|null
	 */
	public function limit($PAGE_NOW = 1, $RETURN_SQL = false)
	{
		//计算读取条目起始点和终止点
		$limit_start = ($PAGE_NOW - 1) * $this->_pageSize;
		//进行分页读取
		$this->_conn->query('SET NAMES ' . $this->_charset);
		//组合SQL语句
		$this->combo_sql($limit_start);
		switch ($RETURN_SQL) {
			case true :
				return $this->_sql;
				break;
			case false :
				$queryRes = $this->_conn->query($this->_sql);
				if ($queryRes) {
					while ($row = $queryRes->fetch_assoc()) {
						$this->_queryRes[] = $row;
					}
					unset($queryRes);
					$this->_queryRes['limit'] = array(
						'_pageNow' => $PAGE_NOW,
						'_pageMax' => $this->_pageMax,
					);
					return $this->_queryRes;
				} else {
					return $this->_conn->error;
				}
				break;
		}
	}

	/**
	 * 写入数据到数据库
	 *
	 * @param array $DATA 待写入的内容
	 * @param bool|false $RETURN_SQL 是否返回SQL语句
	 * @return bool|mysqli_result|string 成功：返回成功写入的ID编号 失败：返回错误描述
	 */
	public function add($DATA, $RETURN_SQL = false)
	{
		/********组合SQL语句********/
		$field = '';
		$value = '';
		foreach ($DATA as $key => $item) {
			$field .= "`$this->_tableName`.`$key`, ";
			$value .= "'$item', ";
		}
		$field = trim($field, ', ');
		$field .= ' ';
		$value = trim($value, ', ');
		$value .= ' ';
		$this->_sql = "INSERT INTO `$this->_tableName` ($field) VALUE ($value);";
		/********写入数据库********/
		if ($RETURN_SQL) {
			return $this->_sql;
		}
		$this->_conn->query('SET NAMES ' . $this->_charset);
		$executeRes = $this->_conn->query($this->_sql);
		if ($executeRes) {
			return $this->_conn->insert_id;
		} else {
			return $this->_conn->error;
		}
	}

	/**
	 * 修改数据库信息
	 *
	 * @param array $DATA 待修改数据集
	 * @param bool|false $RETURN_SQL 是否返回SQL语句
	 * @return bool|null|string 成功：true 失败：异常描述
	 */
	public function save($DATA, $RETURN_SQL = false)
	{
		/********组合SQL语句********/
		$field = '';
		foreach ($DATA as $key => $item) {
			$field .= "`$this->_tableName`.`$key` = '$item', ";
		}
		$field = trim($field, ', ');
		$field .= ' ';
		$this->_sql = "UPDATE `$this->_tableName` SET " . $field . $this->_where;
		/********写入数据库********/
		if ($RETURN_SQL) {
			return $this->_sql;
		}
		$this->_conn->query('SET NAMES ' . $this->_charset);
		$executeRes = $this->_conn->query($this->_sql);
		if ($executeRes) {
			return true;
		} else {
			return $this->_conn->error;
		}
	}

	/**
	 * 删除数据库信息
	 *
	 * @param bool|false $RETURN_SQL 是否返回SQL语句
	 *
	 * @return bool|mysqli_result|null|string 成功：true 失败：异常描述
	 */
	public function delete($RETURN_SQL = false)
	{
		/********组合SQL语句********/
		$this->_sql = "DELETE FROM `$this->_tableName` " . $this->_where;
		if ($RETURN_SQL) {
			return $this->_sql;
		}
		/********操作数据库********/
		$this->_conn->query('SET NAMES ' . $this->_charset);
		$executeRes = $this->_conn->query($this->_sql);
		if ($executeRes > 0) {
			return $executeRes;
		} else {
			return $this->_conn->error;
		}
	}

	/**
	 * 查询字段条目总和
	 *
	 * @param string|array $FIELD 字段名称
	 *
	 * @return array|null|string
	 */
	public function count($FIELD)
	{
		/********组合sql语句********/
		if (is_array($FIELD)) {
			/* >>>多列查询<<< */
			$field = '';
			foreach ($FIELD as $item) {
				$field .= "COUNT(`$this->_tableName`.`$item`),";
			}
			$field = trim($field, ',');
			$this->_field = $field;
		} else {
			/* >>>单列查询<<< */
			$this->_field .= "COUNT(`$this->_tableName`.`$FIELD`)";
		}
		return $this;
	}

	/**
	 * 直接查询字段总数
	 *
	 * @param string|array $FIELD 字段名称
	 * @param bool|false $RETURN_SQL 是否返回sql语句 默认：false
	 *
	 * @return array|string
	 */
	public function find_count($FIELD, $RETURN_SQL = false)
	{
		/********组合sql语句********/
		if (is_array($FIELD)) {
			/* >>>多列查询<<< */
			$field = '';
			foreach ($FIELD as $item) {
				$field .= "COUNT(`$this->_tableName`.`$item`),";
			}
			$field = trim($field, ',');
		} else {
			/* >>>单列查询<<< */
			$field = "COUNT(`$this->_tableName`.`$FIELD`)";
		}
		$sql = "SELECT $field FROM $this->_tableName $this->_where";
		switch ($RETURN_SQL) {
			case true :
				return $sql;
				break;
			case false :
				$this->_conn->query('SET NAMES ' . $this->_charset);
				$queryRes = $this->_conn->query($sql);
				if ($queryRes) {
					$rows = array();
					while ($row = $queryRes->fetch_assoc()) {
						$rows[] = $row;
					}
					return $rows;
				} else {
					return $this->_conn->error;
				}
				break;
		}
	}

	/**
	 * 查询字段条目平均数
	 *
	 * @param string|array $FIELD 字段名称
	 *
	 * @return array|null|string
	 */
	public function avg($FIELD)
	{
		/********组合sql语句********/
		if (is_array($FIELD)) {
			/* >>>多列查询<<< */
			$field = '';
			foreach ($FIELD as $item) {
				$field .= "AVG(`$this->_tableName`.`$item`),";
			}
			$field = trim($field, ',');
			$this->_field = $field;
		} else {
			/* >>>单列查询<<< */
			$this->_field .= "AVG(`$this->_tableName`.`$FIELD`)";
		}
		return $this;
	}

	/**
	 * 直接查询字段请均值
	 *
	 * @param string|array $FIELD 字段名称
	 * @param bool|false $RETURN_SQL 是否返回sql语句 默认：false
	 *
	 * @return array|string
	 */
	public function find_avg($FIELD, $RETURN_SQL = false)
	{
		/********组合sql语句********/
		if (is_array($FIELD)) {
			/* >>>多列查询<<< */
			$field = '';
			foreach ($FIELD as $item) {
				$field .= "AVG(`$this->_tableName`.`$item`),";
			}
			$field = trim($field, ',');
		} else {
			/* >>>单列查询<<< */
			$field = "AVG(`$this->_tableName`.`$FIELD`)";
		}
		$sql = "SELECT $field FROM $this->_tableName $this->_where";
		switch ($RETURN_SQL) {
			case true :
				return $sql;
				break;
			case false :
				$this->_conn->query('SET NAMES ' . $this->_charset);
				$queryRes = $this->_conn->query($sql);
				if ($queryRes) {
					$rows = array();
					while ($row = $queryRes->fetch_assoc()) {
						$rows[] = $row;
					}
					return $rows;
				} else {
					return $this->_conn->error;
				}
				break;
		}
	}

	/**
	 * 查询字段条目最大值
	 *
	 * @param string|array $FIELD 字段名称
	 *
	 * @return array|null|string
	 */
	public function max($FIELD)
	{
		/********组合sql语句********/
		if (is_array($FIELD)) {
			/* >>>多列查询<<< */
			$field = '';
			foreach ($FIELD as $item) {
				$field .= "MAX(`$this->_tableName`.`$item`),";
			}
			$field = trim($field, ',');
			$this->_field = $field;
		} else {
			/* >>>单列查询<<< */
			$this->_field .= "MAX(`$this->_tableName`.`$FIELD`)";
		}
		return $this;
	}

	/**
	 * 直接查询字段最大值
	 *
	 * @param string|array $FIELD 字段名称
	 * @param bool|false $RETURN_SQL 是否返回sql语句 默认：false
	 *
	 * @return array|string
	 */
	public function find_max($FIELD, $RETURN_SQL = false)
	{
		/********组合sql语句********/
		if (is_array($FIELD)) {
			/* >>>多列查询<<< */
			$field = '';
			foreach ($FIELD as $item) {
				$field .= "MAX(`$this->_tableName`.`$item`),";
			}
			$field = trim($field, ',');
		} else {
			/* >>>单列查询<<< */
			$field = "MAX(`$this->_tableName`.`$FIELD`)";
		}
		$sql = "SELECT $field FROM $this->_tableName $this->_where";
		switch ($RETURN_SQL) {
			case true :
				return $sql;
				break;
			case false :
				$this->_conn->query('SET NAMES ' . $this->_charset);
				$queryRes = $this->_conn->query($sql);
				if ($queryRes) {
					$rows = array();
					while ($row = $queryRes->fetch_assoc()) {
						$rows[] = $row;
					}
					return $rows;
				} else {
					return $this->_conn->error;
				}
				break;
		}
	}

	/**
	 * 查询字段条目最小值
	 *
	 * @param string|array $FIELD 字段名称
	 *
	 * @return array|null|string
	 */
	public function mix($FIELD)
	{
		/********组合sql语句********/
		if (is_array($FIELD)) {
			/* >>>多列查询<<< */
			$field = '';
			foreach ($FIELD as $item) {
				$field .= "MIX(`$this->_tableName`.`$item`),";
			}
			$field = trim($field, ',');
			$this->_field = field;
		} else {
			/* >>>单列查询<<< */
			$this->_field .= "MIX(`$this->_tableName`.`$FIELD`)";
		}
		return $this;
	}

	/**
	 * 直接查询字段最小值
	 *
	 * @param string|array $FIELD 字段名称
	 * @param bool|false $RETURN_SQL 是否返回sql语句 默认：false
	 *
	 * @return array|string
	 */
	public function find_min($FIELD, $RETURN_SQL = false)
	{
		/********组合sql语句********/
		if (is_array($FIELD)) {
			/* >>>多列查询<<< */
			$field = '';
			foreach ($FIELD as $item) {
				$field .= "MIN(`$this->_tableName`.`$item`),";
			}
			$field = trim($field, ',');
		} else {
			/* >>>单列查询<<< */
			$field = "MIN(`$this->_tableName`.`$FIELD`)";
		}
		$sql = "SELECT $field FROM $this->_tableName $this->_where";
		switch ($RETURN_SQL) {
			case true :
				return $sql;
				break;
			case false :
				$this->_conn->query('SET NAMES ' . $this->_charset);
				$queryRes = $this->_conn->query($sql);
				if ($queryRes) {
					$rows = array();
					while ($row = $queryRes->fetch_assoc()) {
						$rows[] = $row;
					}
					return $rows;
				} else {
					return $this->_conn->error;
				}
				break;
		}
	}

	/**
	 * 分组
	 *
	 * @param string $FIELD 分组字段名
	 *
	 * @return $this
	 */
	public function group($FIELD)
	{
		$this->_group = " FIELD BY `$FIELD` ";
		return $this;
	}

	function get_instance()
	{
		return $this;
	}

}

/********[finish]********/
