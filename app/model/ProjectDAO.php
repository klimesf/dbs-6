<?php


namespace App\Model;

use PDOException;


/**
 * @package   App\Model
 * @author    Filip Klimes <filipklimes@startupjobs.cz>
 * @copyright 2014, Startupedia s.r.o.
 */
class ProjectDAO extends AbstractDAO
{

	/**
	 * Returns all rows from project table.
	 * @return \Nette\Database\ResultSet
	 */
	public function getAll()
	{
		return $this->getContext()->query('SELECT * FROM `project`');
	}

	/**
	 * Returns all projects with aggregated names of assigned teams.
	 * @return \Nette\Database\ResultSet
	 */
	public function getAllWithTeams()
	{
		$query =
			'SELECT p.id, p.name, GROUP_CONCAT(DISTINCT t.team_name) AS teams FROM `project` p ' .
			'LEFT JOIN team_is_assigned tia ON tia.project_id = p.id ' .
			'LEFT JOIN team t ON tia.team_id = t.id ' .
			'GROUP BY p.id ' .
			'ORDER BY COUNT(DISTINCT t.team_name) DESC';
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
			'SELECT * FROM `project` WHERE `id` = ?';
		return $this->getContext()->query($query, $id)->fetch();
	}

	/**
	 * Updates project with given id.
	 * @param int    $id
	 * @param string $name
	 */
	public function update($id, $name)
	{
		$query =
			'UPDATE `project` SET name = ?' .
			'WHERE id = ?';
		$this->getContext()->query($query, $name, $id);
	}

	/**
	 * Inserts new project.
	 * @param string $name
	 */
	public function insert($name)
	{
		$query =
			'INSERT INTO `project` (name) ' .
			'VALUES (?)';
		$this->getContext()->query($query, $name);
	}

	/**
	 * Deletes project with given id.
	 * @param int $id
	 */
	public function delete($id)
	{
		$query =
			'DELETE FROM `team_is_assigned` WHERE `project_id` = ?';
		$this->getContext()->query($query, $id);

		$query =
			'DELETE FROM `project` WHERE `id` = ?';
		$this->getContext()->query($query, $id);
	}

	/**
	 * Assigns given project to the given team.
	 * @param int $team
	 * @param int $project
	 */
	public function assign($team, $project)
	{
		$query =
			'INSERT INTO `team_is_assigned` (`team_id`, `project_id`) ' .
			'VALUES (?, ?)';
		$this->getContext()->query($query, $team, $project);
	}


}