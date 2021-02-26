<?php

namespace app\models;

use app\traits\Singleton;

class Game
{
	use Singleton;

	private const PLAYER1 = "X";
	private const PLAYER2 = "O";

	/**
	 * @var string
	 */
	private string $turn   = self::PLAYER1;
	/**
	 * @var string
	 */
	private string $winner = "nobody";


	/**
	 * contain number of available rows for each column
	 * @var array
	 */
	private array $columnsArray;


	public function start(): void {

		$boardInstance = $this->resetGame();
		$endGame       = false;
		$cell          = new Cell();

		do {

			$boardInstance->printBoard();
			$col = readline("insert column (player {$this->turn}): ");

			try {
				$col = $this->validateColumnNumber($col);
				$row = $this->getAvailableRow($col);
				$cell->setRow($row)->setCol($col);
				$boardInstance->setPoint($cell, $this->turn);
				$endGame = $this->isEndGame($cell);
				$this->decreaseRowNumber($col);
				$this->nextPlayerTurn();
				system("clear");
			}
			catch (\Exception $e) {//continue play after exception, current player playing.
				system("clear");
				echo "Error: " . $e->getMessage() . "\n";
			}


		}while(!$endGame);


		$boardInstance->printBoard();
		echo "winner is: {$this->winner}\n";


	}

	private function isEndGame(Cell $cell): bool {

		//end game without winner
		if(!$this->hasAvailableCell()) {
			return true;
		}

		if($this->hasWinner($cell)) {
			$this->setWinner();
			return true;
		}

		return false;

	}

	/**
	 * @param Cell $cell
	 * @return bool
	 */
	private function hasWinner(Cell $cell): bool {

		$gameRuleInstance = GameRules::getInstance();

		if($gameRuleInstance->checkVertical($cell, $this->turn)) {
			return true;
		}

		if($gameRuleInstance->checkHorizontal($cell, $this->turn)) {
			return true;
		}

		if($gameRuleInstance->checkDiagonal1($cell, $this->turn)) {
			return true;
		}

		if($gameRuleInstance->checkDiagonal2($cell, $this->turn)) {
			return true;
		}

		return false;

	}

	/**
	 *
	 */
	private function setWinner(): void {
		$this->winner = $this->turn;
	}

	/**
	 * @return bool
	 */
	private function hasAvailableCell(): bool {
		return array_sum($this->columnsArray) > 0;
	}

	/**
	 * @return Board
	 */
	private function resetGame(): Board {
		system("clear");
		$board = Board::getInstance();
		$board->resetBoard();
		$this->resetCols();

		return $board;
	}

	/**
	 * return available row by column.
	 *
	 * @param int $col
	 * @return int
	 * @throws \Exception
	 */
	private function getAvailableRow(int $col): int {

		if ($col >= Board::COLS || $col < 0) {
			throw new \Exception("Illegal column #{$col}");
		}

		if($this->columnsArray[$col]-1 < 0) {
			throw new \Exception("column #{$col} is already full.");
		}

		return $this->columnsArray[$col]-1;

	}

	/**
	 * check if given col is numeric and integer
	 *
	 * @param $col
	 * @return int
	 * @throws \Exception
	 */
	private function validateColumnNumber($col): int {

		if(!is_numeric($col)) {
			throw new \Exception("Invalid column #{$col}");
		}

		return (int)$col;

	}

	/**
	 * decrease availability from columns array
	 *
	 * @param int $col
	 */
	private function decreaseRowNumber(int $col) {
		$this->columnsArray[$col]--;
	}

	/**
	 * change player
	 */
	private function nextPlayerTurn() {
		$this->turn = $this->turn === self::PLAYER1 ? self::PLAYER2 : self::PLAYER1;
	}

	/**
	 *
	 */
	private function resetCols(): void {

		for ($i = 0; $i < Board::COLS; $i++) {
			$this->columnsArray[$i] = Board::ROWS;
		}

	}


}