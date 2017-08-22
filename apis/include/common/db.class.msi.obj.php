<?php
	class DB
	{
		var $defaultDebug = false;
		var $mtStart;
		var $nbQueries;
		var $lastResult;
		var $links;
		var $db;

		public function DB($con)
		{
			$this->db = $con;
			$this->mtStart = $this->getMicroTime();
			$this->nbQueries = 0;
			$this->lastResult = NULL;

			$this->links = new mysqli($con[0], $con[1], $con[2], $con[3]);
		}

		function query($sql, $debug = false)
		{
			$this->nbQueries++;

			$this->lastResult = $this->links->query($sql);
			$this->debug($debug, $sql, $this->lastResult);
			return $this->lastResult;
		}

		function numRows($rs)
		{
			if(empty($rs))
			{
				$rs = $this->lastResult;
			}

			if(!empty($rs))
			{
				return $rs->num_rows;
			}
			else
			{
				return false;
			}
		}

		function fetchData($rs = false)
		{
			if(empty($rs))
			{
				$rs = $this->lastResult;
			}

			if(empty($rs) || mysqli_num_rows($rs) <= 0)
			{
				return NULL;
			}
			else
			{
				return $rs->fetch_assoc();
			}
		}

		function close()
		{
			unset($this->db);
			if ($this->links)
			{
				return $this->links->close();
			}
			else
			{
				return false;
			}
		}

		## Get the id of the very last inserted row.
		## @return The id of the very last inserted row (in any table).

		function lastInsertedId()
		{
			return $this->links->insert_id;
		}

		## Internal method to get the current time.
		## @return The current time in seconds with microseconds (in float format).

		function getMicroTime()
		{
			list($msec, $sec) = explode(' ', microtime());
			return floor($sec / 1000) + $msec;
		}

		## Get the number of queries executed from the begin of this object.
		## @return The number of queries executed on the database server since the
		## creation of this object.

		function getQueriesCount()
		{
			return $this->nbQueries;
		}

		## Internal function to debug a MySQL query.\n
		## Show the query and output the resulting table if not NULL.
		## @param $debug The parameter passed to query() functions. Can be boolean or -1 (default).
		## @param $query The SQL query to debug.
		## @param $result The resulting table of the query, if available.

		function debug($debug, $query, $result = NULL)
		{
			if ($debug === -1 && $this->defaultDebug === false)
			{
				return;
			}
			if ($debug === false)
			{
				return;
			}

			$reason = ($debug === -1 ? 'Default Debug' : 'Debug');
			$this->debugQuery($query, $reason);
			if ($result == NULL)
			{
				echo '<br /><p style="border-top:1px solid #e2e2e2;font:15px verdana;margin:2px;">Number of affected rows: ' . $this->links->affected_rows . '</p></div>';
			}
			else
			{
				$this->debugResult($result);
			}

			exit;
		}

		## Internal function to output a query for debug purpose.\n
		## Should be followed by a call to debugResult() or an echo of "</div>".
		## @param $query The SQL query to debug.
		## @param $reason The reason why this function is called: "Default Debug", "Debug" or "Error".

		function debugQuery($query, $reason = "Debug")
		{
			$color = ($reason == "Error" ? "red" : "green");
			echo '<div style="font:16px verdana;border:solid ' . $color . ' 1px;margin:2px;">' .
			'<p style="margin:0px 0px 2px 0px;padding:0;background-color:#D6EACC;">' .
			'<strong style="padding:0px 31px 1px 0px;background-color:' . $color . ';color:white;"> ' . $reason . ':</strong>' .
			'<span style="font-family:monospace;">&nbsp;<pre>' . htmlentities($query) . '</pre></span></p>' .
			'<strong style="padding:0px 31px 1px 0px;background-color:' . $color . ';color:white;"> Server:</strong>' .
			'<span style="font-family:monospace;">&nbsp;' . $this->db[0] . ", " . $this->db[1] . ", " . $this->db[2] . ", " . $this->db[3] . '</span></p>' .
			'<p style="margin:5px 0px 2px 0px;padding:0;background-color:#FFECF1;">' .
			'<strong style="padding:0px 40px 2px 2px;background-color:red;color:white;">Error:</strong>' .
			'<span style="font-family:monospace;">&nbsp;<b>' . $this->links->error . '</b></span></p>';
		}

		## Internal function to output a table representing the result of a query, for debug purpose.\n
		## Should be preceded by a call to debugQuery().
		## @param $result The resulting table of the query.

		function debugResult($result)
		{
			echo '<table border="0" style="border:0px solid gray;margin:2px;font-family:georgia;color:#330066;"><thead style="font-size:80%">';

			$numFields = $result->field_count;

			// BEGIN HEADER
			$tables = array();
			$nbTables = -1;
			$lastTable = "";
			$fields = array();
			$nbFields = -1;

			while ($column = $result->fetch_field())
			{
				if ($column->table != $lastTable)
				{
					$nbTables++;
					$tables[$nbTables] = array("name" => $column->table, "count" => 1);
				}
				else
				{
					$tables[$nbTables]["count"]++;
				}

				$lastTable = $column->table;
				$nbFields++;
				$fields[$nbFields] = $column->name;
			}

			for ($i = 0; $i <= $nbTables; $i++)
			{
				echo '<th colspan="' . $tables[$i]['count'] . '" style="background-color:#606060;color:#FFFF00;">Table &raquo; ' . $tables[$i]['name'] . '</th>';
			}
			echo '</thead>';
			echo '<thead style="font-size:80%;background-color:#e2e2e2;color:#0066FF;">';

			for ($i = 0; $i <= $nbFields; $i++)
			{
				echo '<th>' . $fields[$i] . '</th>';
			}
			echo '</thead>';

			// END HEADER
			while ($row = $result->fetch_array())
			{
				echo '<tr>';
				for ($i = 0; $i < $numFields; $i++)
				{
					echo '<td align="center" style="background-color:#e2e2e2;color:#0042A4;">' . htmlentities($row[$i]) . '</td>';
				}
				echo '</tr>';
			}
			echo '</table></div>';
			$this->resetFetch($result);
		}

		## Go back to the first element of the result line.
		## @param $result The resssource returned by a query() function.

		function resetFetch($result)
		{
			if ($result->num_rows > 0)
			{
				$result->data_seek(0);
			}
		}
	}
?>
