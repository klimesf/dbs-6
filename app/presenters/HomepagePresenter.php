<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * @package App\Presenters
 * @author Filip Klimes <filip@filipklimes.cz>
 */
class HomepagePresenter extends BasePresenter
{

	/**
	 *
	 */
	public function renderDefault()
	{
		$this->template->teams = $this->teamDAO->getAllWithProjects();
		$this->template->projects = $this->projectDAO->getAllWithTeams();
	}

	/**
	 *
	 */
	public function renderAbout()
	{

	}

}
