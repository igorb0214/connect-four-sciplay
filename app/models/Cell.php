<?php


namespace app\models;


class Cell
{
	private int $row;
	private int $col;

	/**
	 * @return int
	 */
	public function getRow(): int {
		return $this->row;
	}

	/**
	 * @return int
	 */
	public function getCol(): int {
		return $this->col;
	}

	/**
	 * @param int $row
	 * @return $this
	 */
	public function setRow(int $row): self {
		$this->row = $row;
		return $this;
	}

	/**
	 * @param int $col
	 * @return $this
	 */
	public function setCol(int $col): self {
		$this->col = $col;
		return $this;
	}

}