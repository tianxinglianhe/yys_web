<?php

class a4MySQLi
{
	//********************数据库设置
	/*数据库链接*/
	private $_conn = null;
	/*数据库表名*/
	private $_tableName = null;
	/*数据库字符集*/
	private $_charset = null;
	//********************数据库设置<FINISH>

	//********************操作设置
	/*完整的sql语句*/
	private $_sql = null;
	/*被限定的操作字段*/
	private $_field = null;
	/*查询条件*/
	private $_where = null;
	/*外键查询限制*/
	private $_joinTable = null;
	/*外间查询字段*/
	private $_joinField = null;
	/*排序条件*/
	private $_order = null;
	/*组合*/
	private $_group = null;
	//********************操作设置<FINISH>

	//********************自动验证
	protected $_selectRule = array();
	protected $_insertRule = array();
	protected $_updateRule = array();
	protected $_deleteRule = array();
	//********************自动验证<FINISH>

	//********************分页设置
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
	//********************分页设置<FINISH>

	/**
	 * @todo 创建连接
	 *
	 * @param string $TABLENAME 表名称
	 * @param string $CHARSET 字符集
	 *
	 * @throws a4Exception
	 */
	public function createConn($TABLENAME, $CHARSET = '')
	{
		$conf = a4getConf();
		$dbConf = $conf{'database'};
		$this->_charset = $CHARSET;
		if (a4isEmpty($CHARSET)) {
			$this->_charset = $dbConf{'charset'};
		}
		$this->_conn = new mysqli($dbConf{'host'},
			$dbConf{'user'},
			$dbConf{'pwd'},
			$dbConf{'name'},
			$dbConf{'port'});
		if (!$this->_conn) {
			echo $this->_conn;
			exit;
		}
		$this->_tableName = $TABLENAME;
		$this->_conn->select_db($this->_tableName);
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
		$this->_joinTable = '';
		$this->_joinField = '';
		$this->_order = '';
		$this->_group = '';
		$this->_pageSize = 0;
		$this->_pageMax = 0;
		$this->_count = 0;
		$this->_pageNow = 1;
		$this->_queryRes = array();
	}


	/**
	 * @todo 设置查询字段名称
	 *
	 * @param string|array $PARAM 查询字段名称
	 *
	 * @return $this
	 */
	public function field($PARAM = null)
	{
		$this->_field = '';
		$this->_joinField = '';
		if ($PARAM == null) {
			$this->_field = '*';
		}
		if (is_string($PARAM)) {
			$field = explode(',', $PARAM);
			foreach ($field as $value) {
				$this->_field .= " `$this->_tableName`.`$value`,";
			}
			$this->_field = trim($this->_field, ',');
		}
		if (is_array($PARAM)) {
			foreach ($PARAM as $key => $value) {
				if (is_numeric($key)) {
					$this->_field .= "`$this->_tableName`.`$value`,";
				} else {
					$this->_field .= "`$this->_tableName`.`$key` AS $value,";
				}
			}
			$this->_field = trim($this->_field, ',');
		}
		return $this;
	}

	/**
	 * @todo 组合where条件
	 *
	 * @param null $PARAM 参数
	 * @param bool(true) $EXE_VERIFY 是否跳过自动验证
	 *
	 * @return $this
	 */
	public function where($PARAM = null, $EXE_VERIFY = true)
	{
		$this->_where = '';
		if ($PARAM == null) {
			return false;
		}
		//********************执行自动验证
		//检查待查数据中是否都存在于规则中
		$ruleCount = count($this->_selectRule);
		$i = 0;
		foreach ($this->_selectRule as $item) {
			foreach ($PARAM as $key => $value) {
				if ($key == $item{0}) {
					$i++;
				}
			}
		}
		if ($i != $ruleCount) {
			return '搜索条件不满足自动验证规则';
		}
		if ($EXE_VERIFY) {
			$verifyRes = a4verifyForm($PARAM, $this->_selectRule);
			if ($verifyRes == 0) {
				return $verifyRes;
			}
		}
		//********************执行自动验证<FINISH>

		if (is_string($PARAM)) {
			$this->_where = trim($PARAM);
		}
		$where = array();//搜索条件
		if (is_array($PARAM)) {
			foreach ($PARAM as $key => $value) {
				switch (gettype($value{1})) {
					case 'string':
						$value{1} = "'" . addslashes($value{1}) . "'";
						break;
					case 'integer':
						$value{1} = (int)addslashes($value{1});
						break;
					default:
						break;
				}
				if ($value{0} == '=' || $value{0} == '<>' || $value{0} == '>' || $value{0} == '<' || $value{0} == '>=' || $value{0} == '<=' || $value{0} == 'like') {
					$where[] = "`$this->_tableName`.`$key`$value[0]$value[1]" . " " . strtoupper($value{2});
				}
			}
			$this->_where = implode(' ', $where);
		}
		return $this;
	}

	/**
	 * @todo 设置排序
	 *
	 * @param string $FIELD 排序依据字段名称
	 * @param string|null $FORMAT 排序类型 默认：null 正序
	 *
	 * @return $this
	 */
	public function order($FIELD, $FORMAT = null)
	{
		$this->_order = '';
		if (a4isEmpty($FIELD)) {
			return '排序条件不能为空';
		}
		if ($FORMAT == null) {
			$this->_order = "`$this->_tableName`.`" . trim($FIELD) . "` ASC";
		} else {
			switch ($FORMAT) {
				case '+':
					$this->_order = "`$this->_tableName`.`" . trim($FIELD) . "` ASC";
					break;
				case '-':
					$this->_order = "`$this->_tableName`.`" . trim($FIELD) . "` DESC";
					break;
			}
		}
		return $this;
	}

	/**
	 * @todo 执行多条查询
	 *
	 * @param bool $RETURN_SQL 是否直接返回sql语句
	 *
	 * @return array|bool|string
	 */
	public function selects($RETURN_SQL = false)
	{
		if (empty($this->_field)) {
			$this->_field = '*';
		}
		$sql = "SELECT $this->_field";
		if (!empty($this->_joinField)) {
			$sql = "SELECT $this->_joinField";
		}
		$sql .= " FROM `$this->_tableName` ";
		if (!empty($this->_joinTable)) {
			$sql .= $this->_joinTable;
		}
		if (!empty($this->_where)) {
			$sql .= " WHERE $this->_where";
		}
		if (!empty($this->_order)) {
			$sql .= " ORDER BY $this->_order";
		}
		if ($RETURN_SQL) {
			return $sql;
		} else {
			return a4mysql($sql);
		}
	}

	/**
	 * @todo 执行单条查询
	 *
	 * @param bool $RETURN_SQL 是否直接返回sql语句
	 *
	 * @return array|bool|string
	 */
	public function select($RETURN_SQL = false)
	{
		if (empty($this->_field)) {
			$this->_field = '*';
		}
		$sql = "SELECT $this->_field";
		if (!empty($this->_joinField)) {
			$sql = "SELECT $this->_joinField";
		}
		$sql .= " FROM `$this->_tableName` ";
		if (!empty($this->_joinTable)) {
			$sql .= $this->_joinTable;
		}
		if (!empty($this->_where)) {
			$sql .= " WHERE $this->_where";
		}
		if (!empty($this->_order)) {
			$sql .= " ORDER BY $this->_order";
		}
		if ($RETURN_SQL) {
			return $sql;
		} else {
			$res = a4mysql($sql);
			return $res{0};
		}
	}

	/**
	 * @todo 设置分页条件
	 *
	 * @param int $PAGE_SIZE 页容量 默认：5
	 * @param string|null $FIELD 查询标准 默认：null *
	 *
	 * @return $this|string
	 */
	public function setPageSize($PAGE_SIZE = 5, $FIELD = null)
	{
		if (empty($this->_where)) {
			return '查询条件不能为空';
		}
		if ($FIELD == null) {
			$FIELD = '*';
		} else {
			is_string($FIELD) ? $FIELD = trim($FIELD) : $FIELD = '*';
		}
		//查询最大条目数
		$sql = "SELECT COUNT($FIELD) FROM `$this->_tableName` WHERE $this->_where";
		$res = a4mysql($sql);
		$this->_count = $res{0}{"COUNT($FIELD)"};
		//设置页容量
		if ($PAGE_SIZE > 0) {
			$this->_pageSize = (int)$PAGE_SIZE;
		} else {
			$this->_pageSize = 5;
		}
		//计算最大页数
		if ($this->_count % $this->_pageSize == 0) {
			$this->_pageMax = (int)($this->_count / $this->_pageSize);
		} else {
			$this->_pageMax = (int)($this->_count / $this->_pageSize) + 1;
		}
		//矫正最大页数
		if ($this->_pageMax < 1) {
			$this->_pageMax = 1;
			$this->_pageSize = $this->_count;
		}
		return $this;
	}

	/**
	 * @todo 分页查询
	 *
	 * @param int $PAGE_NOW 当前页 默认：1
	 * @param bool $RETURN_SQL 是否直接返回sql语句 默认：false
	 *
	 * @return array|bool|string
	 */
	public function limit($PAGE_NOW = 1, $RETURN_SQL = false)
	{
		if ($this->_count < 1) {
			return '获取最大条目数错误';
		}
		if ($this->_pageSize < 1) {
			return '获取页容量错误';
		}
		if ($this->_pageMax < 1) {
			return '获取最大页数错误';
		}
		if (empty($this->_field)) {
			$this->_field = '*';
		}
		//拼接查询条件
		$sql = "SELECT $this->_field FROM `$this->_tableName`";
		if (!empty($this->_where)) {
			$sql .= " WHERE $this->_where";
		}
		//矫正当前页
		if ($PAGE_NOW < 1) {
			$PAGE_NOW = 1;
		} elseif ($PAGE_NOW > $this->_pageMax) {
			$PAGE_NOW = $this->_pageMax;
		} else {
			$PAGE_NOW = (int)$PAGE_NOW;
		}
		//拼接分页查询
		$sql .= " LIMIT " . ($PAGE_NOW - 1) * $this->_pageSize . ",$this->_pageSize";
		if ($RETURN_SQL) {
			return $sql;
		} else {
			$this->_pageNow = $PAGE_NOW;
			return a4mysql($sql);
		}
	}

	/**
	 * @todo 获取最大页
	 *
	 * @return integer
	 */
	public function getPageMax()
	{
		return $this->_pageMax;
	}

	/**
	 * @todo 获取当前页
	 *
	 * @return integer
	 */
	public function getPageNow()
	{
		return $this->_pageNow;
	}

	/**
	 * @todo 内链查询
	 * @author JerichoPH
	 *
	 * @param array $INNER_JOIN_TABLENAME 内链查询表名称
	 * @param array $INNER_JOIN_FIELD 内链查询字段名称
	 *
	 * @return $this
	 */
	public function innerJoin($INNER_JOIN_TABLENAME, $INNER_JOIN_FIELD)
	{
		if (!is_array($INNER_JOIN_TABLENAME) || empty($INNER_JOIN_TABLENAME)) {
			return '联合查询表必须是数组';
		}
		if (!is_array($INNER_JOIN_FIELD)) {
			return '联合查询字段必须是数组';
		}
		$this->join($INNER_JOIN_TABLENAME, $INNER_JOIN_FIELD, 'INNER');
		return $this;
	}

	/**
	 * @todo 做外链查询
	 * @author JerichoPH
	 *
	 * @param array $LEFT_JOIN_TABLENAME 左外链查询表名称
	 * @param array $LEFT_JOIN_FIELD 左外链查询字段名称
	 *
	 * @return $this
	 */
	public function leftJoin($LEFT_JOIN_TABLENAME, $LEFT_JOIN_FIELD)
	{
		if (!is_array($LEFT_JOIN_TABLENAME) || empty($LEFT_JOIN_TABLENAME)) {
			return '联合查询表必须是数组';
		}
		if (!is_array($LEFT_JOIN_FIELD)) {
			return '联合查询字段必须是数组';
		}
		$this->join($LEFT_JOIN_TABLENAME, $LEFT_JOIN_FIELD, 'LEFT');
		return $this;
	}

	/**
	 * @todo 右外链查询
	 * @author JerichoPH
	 *
	 * @param array $RIGHT_JOIN_TABLENAME 右外链查询表名称
	 * @param array $RIGHT_JOIN_FIELD 右外链查询字段名称
	 *
	 * @return $this
	 */
	public function rightJoin($RIGHT_JOIN_TABLENAME, $RIGHT_JOIN_FIELD)
	{
		if (!is_array($RIGHT_JOIN_TABLENAME) || empty($RIGHT_JOIN_TABLENAME)) {
			return '联合查询表必须是数组';
		}
		if (!is_array($RIGHT_JOIN_FIELD)) {
			return '联合查询字段必须是数组';
		}
		$this->join($RIGHT_JOIN_TABLENAME, $RIGHT_JOIN_FIELD, 'RIGHT');
		return $this;
	}

	/**
	 * @todo inner join查询表和字段设置
	 * @author JerichoPH
	 *
	 * @param array $JOIN_TABLENAME join 查询表
	 * @param array $JOIN_FIELD join 字段名
	 * @param array $JOIN_TYPE join 类型(INNER/LEFT/RIGHT)
	 *
	 * @return $this
	 */
	public function join($JOIN_TABLENAME, $JOIN_FIELD, $JOIN_TYPE)
	{
		$joinTableName = array();//连接表名
		$joinField = array();//字段名
		$this->_field = '';//清空普通字段
		$this->_joinTable = '';//清空连接查询表名
		$this->_joinField = '';//清空查询字段名称
		if (is_array($JOIN_TABLENAME)) {
			foreach ($JOIN_TABLENAME as $key => $value) {
				$joinTableName[] = "$JOIN_TYPE JOIN `$key` ON `$this->_tableName`.`$value[0]`=`$key`.`$value[1]`";
			}
			$this->_joinTable = implode(' ', $joinTableName);
		}
		if (is_array($JOIN_FIELD)) {
			foreach ($JOIN_FIELD as $key => $value) {
				foreach ($value as $k => $v) {
					if (is_numeric($k)) {
						$joinField[] = "`$key`.`" . addslashes($v) . "`";
					} else {
						$joinField[] = "`$key`.`" . addslashes($k) . "` AS `" . addslashes($v) . "`";
					}
				}
			}
			$this->_joinField = implode(',', $joinField);
		}
		return $this;
	}

	/**
	 * @todo   向数据库内插入数据
	 * @author JerichoPH
	 *
	 * @param array $PARAM 待插入参数
	 * @param bool $RETURN_SQL 是否直接返回sql语句 默认：false
	 *
	 * @return string
	 */
	public function insert($PARAM, $RETURN_SQL = false)
	{
		//********************执行自动验证
		//检查待查数据中是否都存在于规则中
		$ruleCount = count($this->_insertRule);
		$i = 0;
		foreach ($this->_insertRule as $item) {
			foreach ($PARAM as $key => $value) {
				if ($key == $item{0}) {
					$i++;
				}
			}
		}
		if ($i != $ruleCount) {
			return '插入条件不满足自动验证规则';
		}
		$verifyRes = a4verifyForm($PARAM, $this->_insertRule);
		if ($verifyRes == 0) {
			return $verifyRes;
		}
		//********************执行自动验证<FINISH>
		$sql = "INSERT INTO `$this->_tableName`(";
		foreach ($PARAM as $key => $value) {
			$sql .= '`' . $this->_tableName . '`.`' . $key . '`,';
		}
		$sql = trim($sql, ',');
		$sql .= ') VALUES (';
		//循环参数绑定
		if ($PARAM != null) :
			foreach ($PARAM as $key => $item) {
				switch (gettype($item)) {
					case 'string':
						$item = "'" . $item . "'";
						break;
					case 'integer':
						$item = (int)$item;
						break;
				}
				$sql .= $item . ',';
			}
		endif;
		$sql = trim($sql, ',') . ');';
		if ($RETURN_SQL) {
			return $sql;
		}
		return a4mysql($sql);
	}

	/**
	 * @todo 修改记录
	 *
	 * @param array $PARAM 修改参数
	 * @param bool $RETURN_SQL 是否直接返回sql语句 默认：false
	 *
	 * @return string|integer
	 */
	public function update($PARAM, $RETURN_SQL = false)
	{
		//********************执行自动验证
		//检查待查数据中是否都存在于规则中
		$ruleCount = count($this->_updateRule);
		$i = 0;
		foreach ($this->_updateRule as $item) {
			foreach ($PARAM as $key => $value) {
				if ($key == $item{0}) {
					$i++;
				}
			}
		}
		if ($i != $ruleCount) {
			return '修改条件不满足自动验证规则';
		}
		$verifyRes = a4verifyForm($PARAM, $this->_updateRule);
		if ($verifyRes == 0) {
			return $verifyRes;
		}
		//********************执行自动验证<FINISH>
		if (empty($this->_where)) {
			return '修改条件不能为空';
		}
		$sql = "UPDATE `$this->_tableName` SET ";
		foreach ($PARAM as $key => $value) {
			switch (gettype($value)) {
				case 'string':
					$value = "'" . addslashes($value) . "'";
					break;
				case 'integer':
					$value = (int)addslashes($value);
					break;
			}
			$sql .= "`$this->_tableName`.`$key`=$value,";
		}
		$sql = trim($sql, ',');
		if ($RETURN_SQL) {
			return "$sql WHERE $this->_where;";
		} else {
			return a4mysql("$sql WHERE $this->_where;");
		}
	}

	/**
	 * @todo 删除记录
	 *
	 * @param array $PARAM 删除条件
	 * @param bool $RETURN_SQL 是否直接返回sql语句
	 *
	 * @return array|bool|string
	 */
	public function delete($PARAM, $RETURN_SQL = false)
	{
		//********************执行自动验证
		//检查待查数据中是否都存在于规则中
		$ruleCount = count($this->_deleteRule);
		$i = 0;
		foreach ($this->_deleteRule as $item) {
			foreach ($PARAM as $key => $value) {
				if ($key == $item{0}) {
					$i++;
				}
			}
		}
		if ($i != $ruleCount) {
			return '删除条件不满足自动验证规则';
		}
		$verifyRes = a4verifyForm($PARAM, $this->_deleteRule);
		if ($verifyRes == 0) {
			return $verifyRes;
		}
		//********************执行自动验证<FINISH>

		$this->where($PARAM, 0);/*组合条件语句，不执行自动验证*/
		if (empty($this->_where)) {
			return '删除条件不能为空';
		}
		$sql = "DELETE FROM `$this->_tableName` WHERE $this->_where;";
		if ($RETURN_SQL) {
			return $sql;
		} else {
			return a4mysql($sql);
		}
	}

	/**
	 * @todo 直接执行SQL语句
	 *
	 * @param string $SQL SQL语句
	 * @param array $PARAM 参数
	 * @param bool(false|0) $RETURN_SQL 是否返回SQL语句
	 *
	 * @return array|bool|string
	 */
	public function execute($SQL, $PARAM, $RETURN_SQL = false)
	{
		return a4mysql($SQL, $PARAM, $RETURN_SQL);
	}
}