<?php


namespace App\Model;


/**
 * @package App\Model
 * @author  Filip Klimes <filip@filipklimes.cz>
 */
class TeamDAO extends AbstractDAO
{

	/**
	 * Returns all rows from team table.
	 * @return \Nette\Database\ResultSet
	 */
	public function getAll()
	{
		return $this->getContext()->query('SELECT * FROM `team`');
	}

	/**
	 * Returns all projects with aggregated names of assigned teams.
	 * @return \Nette\Database\ResultSet
	 */
	public function getAllWithProjects()
	{
		$query =
			'SELECT t.id, t.team_name, GROUP_CONCAT(DISTINCT p.name) AS projects FROM `team` t ' .
			'LEFT JOIN team_is_assigned tia ON tia.team_id = t.id ' .
			'LEFT JOIN project p ON tia.project_id = p.id ' .
			'GROUP BY t.id ' .
			'ORDER BY COUNT(DISTINCT p.name) DESC';
		return $this->getContext()->query($query);
	}

	/**
	 * Returns single row with given id.
	 * @param $id
	 * @return \Nette\Database\IRow
	 */
	public function get($id)
	{
		$query =
			'SELECT * FROM `team` WHERE `id` = ?';
		return $this->getContext()->query($query, $id)->fetch();
	}

	/**
	 * @param $id
	 * @param $name
	 */
	public function update($id, $name)
	{
		$query =
			'UPDATE `team` SET `team_name` = ?' .
			'WHERE `id` = ?';
		$this->getContext()->query($query, $name, $id);
	}

	/**
	 * @param $name
	 */
	public function insert($name)
	{
		$query =
			'INSERT INTO `team` (`team_name`) ' .
			'VALUES (?)';
		$this->getContext()->query($query, $name);
	}

	/**
	 * @param $id
	 */
	public function delete($id)
	{
		$query =
			'DELETE FROM `team_is_assigned` WHERE `team_id` = ?';
		$this->getContext()->query($query, $id);

		$query =
			'DELETE FROM `team` WHERE `id` = ?';
		$this->getContext()->query($query, $id);
	}

} 