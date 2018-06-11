<?php

/**
 * Copyright (C) 2016-2018  Daniel Dolejška
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Library\RiotAPI\Objects;


/**
 *   Class GameCustomizationObject
 *
 * Used in:
 *   spectator (v3)
 *     @link https://developer.riotgames.com/api-methods/#spectator-v3/GET_getCurrentGameInfoBySummoner
 *
 * @package RiotAPI\Objects
 */
class GameCustomizationObject extends ApiObject
{
	/**
	 *   Category identifier for Game Customization.
	 *
	 * @var string $category
	 */
	public $category;

	/**
	 *   Game Customization content.
	 *
	 * @var string $content
	 */
	public $content;
}
