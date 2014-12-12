<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @var Model\TeamDAO
	 */
	protected $teamDAO;

	/**
	 * @var Model\ProjectDAO
	 */
	protected $projectDAO;

	/**
	 * Dependency injection.
	 * @param Model\TeamDAO    $teamDAO
	 * @param Model\ProjectDAO $projectDAO
	 */
	public function injectDAOs(Model\TeamDAO $teamDAO, Model\ProjectDAO $projectDAO)
	{
		$this->teamDAO = $teamDAO;
		$this->projectDAO = $projectDAO;
	}

	/**
	 * Subrequest for deleting project with given id.
	 * @param $id
	 */
	public function handleDeleteProject($id)
	{
		$this->projectDAO->delete($id);
		if($this->isAjax()) {
			$this->redrawControl('teams');
			$this->redrawControl('projects');
		} else {
			$this->redirect('Homepage:default');
		}
	}

	/**
	 * Subrequest for deleting team with given id.
	 * @param $id
	 */
	public function handleDeleteTeam($id)
	{
		$this->teamDAO->delete($id);
		if($this->isAjax()) {
			$this->redrawControl('teams');
			$this->redrawControl('projects');
		} else {
			$this->redirect('Homepage:default');
		}
	}

}
