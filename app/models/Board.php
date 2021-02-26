<?php

namespace app\models;

use app\traits\Singleton;

class Board
{
	use Singleton;

	private const CELL_LEFT_SPACE  = 3;
	private const CELL_RIGHT_SPACE = self::CELL_LEFT_SPACE - 1;
	public  const ROWS             = 6;
	public  const COLS             = 7;
	private array $board;


	/**
	 * set empty values for all cells
	 */
	public function resetBoard(): void {
		for ($i=0; $i<self::ROWS; $i++) {
			for ($j=0; $j<self::COLS; $j++) {
				$this->board[$i][$j] = "";
			}
		}
	}

	/**
	 *
	 */
	public function printBoard(): void {

		$this->printRowDelimiter(true);

		for ($i=0; $i<self::ROWS; $i++) {
			$this->printRow($i);
			$this->printRowDelimiter();
		}
	}

	/**
	 * @param Cell $cell
	 * @param string $value
	 * @throws \Exception
	 */
	public function setPoint(Cell $cell, string $value): void {

		$row = $cell->getRow();
		$col = $cell->getCol();

		if(!isset($this->board[$row][$col])) {
			throw new \Exception("Illegal cell");
		}

		$this->board[$row][$col] = $value;

	}

	/**
	 * @return array
	 */
	public function getBoard(): array {
		return $this->board;
	}

	/**
	 * @param bool $firstRow
	 */
	private function printRowDelimiter(bool $firstRow = false): void {
		echo $this->getRowDelimiterFormat($firstRow) . "\n";
	}

	/**
	 * @param bool $firstRow
	 * @return string
	 */
	private function getRowDelimiterFormat(bool $firstRow): string {

		$format = "+";
		for ($i=0; $i<self::COLS; $i++) {
			$condition = self::CELL_LEFT_SPACE + self::CELL_RIGHT_SPACE;
			if ($firstRow) {//for first row, print column number above
				$format .= $i;
				$condition -= 1;
			}
			for ($j=0; $j<$condition; $j++) {
				$format .= "-";
			}
			$format .= "+";
		}

		return $format;

	}

	/**
	 * @param int $rowNum
	 */
	private function printRow(int $rowNum): void {
		echo vsprintf($this->getRowFormat(), $this->board[$rowNum]) . "\n";
	}

	/**
	 * @return string
	 */
	private function getRowFormat(): string {

		$format = "";

		for ($i=0; $i<self::COLS; $i++) {
			$format .= $this->getCellFormat();
		}

		return $format . "|";

	}

	/**
	 * @return string
	 */
	private function getCellFormat(): string {

		$rightSpace = "";

		for ($i = 0; $i<self::CELL_RIGHT_SPACE; $i++) {
			$rightSpace .= " ";
		}

		return "|%" . self::CELL_LEFT_SPACE . "s{$rightSpace}";
	}
}