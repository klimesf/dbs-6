<?php


namespace App\Model;

use Nette;

/**
 * @package App\Model
 * @author  Filip Klimes <filip@filipklimes.cz>
 */
abstract class AbstractDAO extends Nette\Object
{

	/**
	 * @var Nette\Database\Context
	 */
	private $context;

	/**
	 * @param Nette\Database\Context $context
	 */
	public function __construct(Nette\Database\Context $context)
	{
		$this->context = $context;
	}

	/**
	 * @return Nette\Database\Context
	 */
	protected function getContext()
	{
		return $this->context;
	}

	abstract public function getAll();

	/**
	 * SQL Injection protection.
	 * @param $string
	 * @return string
	 */
	protected function delimite($string)
	{
		return $this->getContext()->getConnection()
			->getSupplementalDriver()->delimite($string);
	}

}