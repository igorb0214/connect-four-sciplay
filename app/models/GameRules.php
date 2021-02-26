<?php

namespace app\models;

use app\traits\Singleton;

class GameRules
{
	use Singleton;

	private const FOUR = 4;


	/**
	 * check diagonal type: \
	 * @param Cell $cell
	 * @param string $turn
	 * @return bool
	 */
	public function checkDiagonal1(Cell $cell, string $turn): bool {

		$board         = Board::getInstance()->getBoard();
		$row           = $cell->getRow();
		$col           = $cell->getCol();
		$rightLeft     = [1, -1];
		$diagonalCount = 0;

		foreach ($rightLeft as $side) {//check left and right \

			for ($i = 1; $i < self::FOUR; $i++) {
				if (!isset($board[$row + ($i * $side)][$col + ($i * $side)])) {//invalid cell
					break;
				} elseif (!($turn == $board[$row + ($i * $side)][$col + ($i * $side)])) {//other player OR empty cell
					break;
				} else {
					$diagonalCount++;
				}
			}
		}

		return $diagonalCount +1 >= self::FOUR;//+1 for current cell

	}

	/**
	 * check diagonal type: /
	 * @param Cell $cell
	 * @param string $turn
	 * @return bool
	 */
	public function checkDiagonal2(Cell $cell, string $turn): bool {

		$board         = Board::getInstance()->getBoard();
		$row           = $cell->getRow();
		$col           = $cell->getCol();
		$rightLeft     = [1, -1];
		$diagonalCount = 0;

		foreach ($rightLeft as $side) {//check left and right /

			for ($i = 1; $i < self::FOUR; $i++) {
				if (!isset($board[$row - ($i * $side)][$col + ($i * $side)])) {//invalid cell
					break;
				} elseif (!($turn == $board[$row - ($i * $side)][$col + ($i * $side)])) {//other player OR empty cell
					break;
				} else {
					$diagonalCount++;
				}
			}
		}

		return $diagonalCount +1 >= self::FOUR;//+1 for current cell

	}

	/**
	 * @param Cell $cell
	 * @param string $turn
	 * @return bool
	 */
	public function checkVertical(Cell $cell, string $turn): bool {

		$board     = Board::getInstance()->getBoard();
		$row       = $cell->getRow();
		$col       = $cell->getCol();
		$downCount = 0;

		for ($i = 1; $i < self::FOUR; $i++) {//check down
			if (!isset($board[$row + $i][$col])) {//invalid cell
				break;
			} elseif (!($turn == $board[$row + $i][$col])) {//other player OR empty cell
				break;
			} else {
				$downCount++;
			}
		}

		return $downCount +1 >= self::FOUR;//+1 for current cell

	}

	/**
	 * @param Cell $cell
	 * @param string $turn
	 * @return bool
	 */
	public function checkHorizontal(Cell $cell, string $turn): bool {

		$board     = Board::getInstance()->getBoard();
		$row       = $cell->getRow();
		$col       = $cell->getCol();
		$rightLeft = [1,-1];
		$horizontalCount = 0;

		foreach ($rightLeft as $side) {//check left and right

			for ($i = 1; $i < self::FOUR; $i++) {

				if (!isset($board[$row][$col + ($i * $side)])) {//invalid cell
					break;
				} elseif (!($turn == $board[$row][$col + ($i * $side)])) {//other player OR empty cell
					break;
				} else {
					$horizontalCount++;
				}
			}

		}

		return $horizontalCount +1 >= self::FOUR;//+1 for current cell
	}


}