<?php


namespace App\Presenters;

use Nette\Application\UI\Form;
use Nette;
use PDOException;


/**
 * @package App\Presenters
 * @author  Filip Klimes <filip@filipklimes.cz>
 */
class EditPresenter extends BasePresenter
{

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var Nette\Database\IRow
	 */
	private $project;

	/**
	 * @var Nette\Database\IRow
	 */
	private $team;

	/* ** TEAM ******************************************************** */

	public function actionTeam($id = null)
	{
		$this->id = $id;
		if ($id !== null) {
			$this->team = $this->teamDAO->get($id);
			$this['addTeamForm']->setDefaults(array(
				'name' => $this->team->team_name
			));
		}
	}

	public function renderTeam()
	{
		$this->template->id = $this->id;
	}

	public function createComponentAddTeamForm()
	{
		$form = new Form();

		$form->addText('name', 'Jméno')
			->setRequired();
		$form->addSubmit('save', 'Uložit');

		$form->onSuccess[] = callback($this, 'addTeam');
		return $form;
	}

	public function addTeam(Form $form)
	{
		$values = $form->getValues();
		if ($this->id !== null) {
			$this->teamDAO->update($this->id, $values->name);
		} else {
			$this->teamDAO->insert($values->name);
		}
		$this->redirect('Homepage:default');
	}

	/* ** PROJECT ***************************************************** */

	public function actionProject($id = null)
	{
		$this->id = $id;
		if ($id !== null) {
			$this->project = $this->projectDAO->get($id);
			$this['addProjectForm']->setDefaults(array(
				'name' => $this->project->name
			));
		}
	}

	public function renderProject()
	{
		$this->template->id = $this->id;
	}

	public function createComponentAddProjectForm()
	{
		$form = new Form();

		$form->addText('name', 'Jméno')
			->setRequired();
		$form->addSubmit('save', 'Uložit');

		$form->onSuccess[] = callback($this, 'addProject');
		return $form;
	}

	public function addProject(Form $form)
	{
		$values = $form->getValues();
		if ($this->id !== null) {
			$this->projectDAO->update($this->id, $values->name);
		} else {
			$this->projectDAO->insert($values->name);
		}
		$this->redirect('Homepage:default');
	}

	/* ** ASSIGN ****************************************************** */

	public function renderAssign()
	{}

	public function createComponentAssignForm()
	{
		$form = new Form();

		$form->addSelect('team', 'Tým', $this->teamDAO->getAll()->fetchPairs('id', 'team_name'));
		$form->addSelect('project', 'Projekt', $this->projectDAO->getAll()->fetchPairs('id', 'name'));
		$form->addSubmit('assign', 'Přiřadit');

		$form->onSuccess[] = callback($this, 'assign');
		return $form;
	}

	public function assign(Form $form)
	{
		$values = $form->getValues();
		try {
			$this->projectDAO->assign($values->team, $values->project);
		} catch(PDOException $e) {
			$this->flashMessage('Tým je k projektu již přiřazen.', 'error');
		}

		$this->redirect('Homepage:default');
	}


} 