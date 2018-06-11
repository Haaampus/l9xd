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

namespace App\Library\DataDragonAPI;

use App\Library\DataDragonAPI\Utils\Html;

use App\Library\RiotAPI\RiotAPI;
use App\Library\RiotAPI\Objects\SummonerDto;
use App\Library\RiotAPI\Objects\StaticData\StaticImageDto;
use App\Library\RiotAPI\Objects\StaticData\StaticRealmDto;
use App\Library\RiotAPI\Objects\StaticData\StaticChampionDto;
use App\Library\RiotAPI\Objects\StaticData\StaticItemDto;
use App\Library\RiotAPI\Objects\StaticData\StaticMapDetailsDto;
use App\Library\RiotAPI\Objects\StaticData\StaticMasteryDto;
use App\Library\RiotAPI\Objects\StaticData\StaticRuneDto;
use App\Library\RiotAPI\Objects\StaticData\StaticChampionSpellDto;
use App\Library\RiotAPI\Objects\StaticData\StaticSummonerSpellDto;

use App\Library\DataDragonAPI\Exception\RequestException;
use App\Library\DataDragonAPI\Exception\SettingsException;


class DataDragonAPI
{
	/** Settings constants. */
	const
		SET_ENDPOINT            = 'datadragon-cdn',
		SET_VERSION             = 'version',
		SET_CUSTOM_IMG_ATTRS    = 'custom-attrs',
		SET_DEFAULT_CLASS       = 'class-default',
		SET_PROFILE_ICON_CLASS  = 'class-profile',
		SET_MASTERY_ICON_CLASS  = 'class-mastery',
		SET_RUNE_ICON_CLASS     = 'class-rune',
		SET_CHAMP_SPLASH_CLASS  = 'class-champ_splash',
		SET_CHAMP_LOADING_CLASS = 'class-champ_loading',
		SET_CHAMP_ICON_CLASS    = 'class-champ_icon',
		SET_SPRITE_CLASS        = 'class-champ_icon_sprite',
		SET_SPELL_ICON_CLASS    = 'class-spell',
		SET_ITEM_ICON_CLASS     = 'class-item',
		SET_UI_ICON_CLASS       = 'class-scoreboard',
		SET_MINIMAP_CLASS       = 'class-minimap';


	/**
	 *   Contains library settings.
	 * 
	 * @var $settings array
	 */
	static protected $settings = array(
		self::SET_ENDPOINT            => 'http://ddragon.leagueoflegends.com/cdn/',
		self::SET_DEFAULT_CLASS       => 'dd-icon',
		self::SET_PROFILE_ICON_CLASS  => 'dd-icon-profile',
		self::SET_MASTERY_ICON_CLASS  => 'dd-icon-mastery',
		self::SET_RUNE_ICON_CLASS     => 'dd-icon-rune',
		self::SET_CHAMP_SPLASH_CLASS  => 'dd-splash',
		self::SET_CHAMP_LOADING_CLASS => 'dd-loading',
		self::SET_CHAMP_ICON_CLASS    => 'dd-icon-champ',
		self::SET_SPRITE_CLASS        => 'dd-sprite',
		self::SET_SPELL_ICON_CLASS    => 'dd-icon-spell',
		self::SET_ITEM_ICON_CLASS     => 'dd-icon-item',
		self::SET_UI_ICON_CLASS       => 'dd-icon-ui',
		self::SET_MINIMAP_CLASS       => 'dd-minimap',
	);

	static protected $initialized = false;


	/**
	 *   Creates new instance by fetching latest Realm info from DataDragon.
	 *
	 * @param array $customSettings
	 *
	 * @throws RequestException
	 */
	public static function initByCdn( array $customSettings = [] )
	{
		$data = file_get_contents("https://ddragon.leagueoflegends.com/api/versions.json");
		if ($data == false)
			throw new RequestException('Version list failed to be fetched from DataDragon.');

		$obj = json_decode($data);

		self::setSettings([
			self::SET_VERSION  => reset($obj),
			self::SET_ENDPOINT => "http://ddragon.leagueoflegends.com/cdn/",
		]);

		if (!empty($customSettings))
			self::setSettings($customSettings);

		self::$initialized = true;
	}

	/**
	 *   Creates new instance by fetching latest Realm info from DataDragon.
	 *
	 * @param string $region_name
	 * @param array  $customSettings
	 *
	 * @throws RequestException
	 */
	public static function initByRegion( string $region_name, array $customSettings = [] )
	{
		$region_name = strtolower($region_name);
		$data = file_get_contents("https://ddragon.leagueoflegends.com/realms/$region_name.json");
		if ($data == false)
			throw new RequestException('Version list failed to be fetched from DataDragon.');

		$obj = json_decode($data);

		self::setSettings([
			self::SET_VERSION  => $obj->dd,
			self::SET_ENDPOINT => $obj->cdn . "/",
		]);

		if (!empty($customSettings))
			self::setSettings($customSettings);

		self::$initialized = true;
	}

	/**
	 *   Creates new instance by specifying CDN version.
	 *
	 * @param string $version
	 * @param array  $customSettings
	 */
	public static function initByVersion( string $version, array $customSettings = [] )
	{
		self::setSettings([
			self::SET_VERSION  => $version,
			self::SET_ENDPOINT => "http://ddragon.leagueoflegends.com/cdn/",
		]);

		if (!empty($customSettings))
			self::setSettings($customSettings);

		self::$initialized = true;
	}

	/**
	 *   Creates new instance by fetching latest Realm info by API static-data endpoint
	 * request.
	 *
	 * @param RiotAPI $api
	 * @param array   $customSettings
	 *
	 * @throws \RiotAPI\Exceptions\RequestException
	 * @throws \RiotAPI\Exceptions\ServerException
	 * @throws \RiotAPI\Exceptions\ServerLimitException
	 */
	public static function initByApi( RiotAPI $api, array $customSettings = [] )
	{
		self::initByRealmObject($api->getStaticRealm());

		if (!empty($customSettings))
			self::setSettings($customSettings);

		self::$initialized = true;
	}

	/**
	 *   Creates new instance from Realm object.
	 *
	 * @param StaticRealmDto $realm
	 * @param array          $customSettings
	 */
	public static function initByRealmObject( StaticRealmDto $realm, array $customSettings = [] )
	{
		self::setSettings([
			self::SET_ENDPOINT => $realm->cdn . "/",
			self::SET_VERSION  => $realm->dd,
		]);

		if (!empty($customSettings))
			self::setSettings($customSettings);

		self::$initialized = true;
	}


	/**
	 *   Returns vaue of requested key from settings.
	 *
	 * @param string     $name
	 * @param mixed|null $defaultValue
	 *
	 * @return mixed
	 */
	public static function getSetting( string $name, $defaultValue = null )
	{
		return self::isSettingSet($name)
			? self::$settings[$name]
			: $defaultValue;
	}

	/**
	 *   Sets new value for specified key in settings.
	 *
	 * @param string $name
	 * @param mixed  $value
	 */
	public static function setSetting( string $name, $value )
	{
		self::$settings[$name] = $value;
	}

	/**
	 *   Sets new values for specified set of keys in settings.
	 *
	 * @param array $values
	 */
	public static function setSettings( array $values )
	{
		foreach ($values as $name => $value)
			self::setSetting($name, $value);
	}

	/**
	 *   Checks if specified settings key is set.
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	public static function isSettingSet( string $name ): bool
	{
		return isset(self::$settings[$name]) && !empty(self::$settings[$name]);
	}

	/**
	 *   Checks whether the library has been initialized.
	 *
	 * @throws SettingsException
	 */
	public static function checkInit()
	{
		if (!self::$initialized)
			throw new SettingsException('DataDragon class was not initialized - version is potentially unknown.');
	}


	/**
	 * ==================================================================d=d=
	 *     Available methods
	 *     @link https://developer.riotgames.com/docs/static-data
	 * ==================================================================d=d=
	 **/

	/**
	 *   Returns profile icon in img HTML TAG.
	 *
	 * @param int   $profile_icon_id
	 * @param array $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getProfileIcon( int $profile_icon_id, array $attributes = [] )
	{
		self::checkInit();

		$attrs = array_merge([ 'alt' => 'Profile Icon' ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_PROFILE_ICON_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['src'] = self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/profileicon/{$profile_icon_id}.png";

		// return Html::el('img', $attrs);
		return self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/profileicon/{$profile_icon_id}.png";
	}

	/**
	 *   Returns profile icon in img HTML TAG.
	 *
	 * @param string $summoner_name
	 * @param string $platform_id
	 * @param array  $attributes
	 *
	 * @return Html
	 */
	public static function getProfileIconByName( string $summoner_name, string $platform_id, array $attributes = [] ): Html
	{
		$attrs = array_merge([ 'alt' => 'Profile Icon' ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_PROFILE_ICON_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['src'] = "https://avatar.leagueoflegends.com/{$platform_id}/{$summoner_name}.png";

		return Html::el('img', $attrs);
	}

	/**
	 *   Returns profile icon from API static-data Summoner object in img HTML TAG.
	 *
	 * @param SummonerDto $summoner
	 * @param array       $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getProfileIconO( SummonerDto $summoner, array $attributes = [] ): Html
	{
		return self::getProfileIcon($summoner->profileIconId, $attributes);
	}

	/**
	 *   Returns champion splash in img HTML TAG.
	 *
	 * @param string $champion_name
	 * @param int    $skin
	 * @param array  $attributes
	 *
	 * @return Html
	 */
	public static function getChampionSplash( string $champion_name, int $skin = 0, array $attributes = [] ): Html
	{
		$attrs = array_merge([ 'alt' => $champion_name ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_CHAMP_SPLASH_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['src'] = self::getSetting(self::SET_ENDPOINT) . "img/champion/splash/{$champion_name}_{$skin}.jpg";

		return Html::el('img', $attrs);
	}

	/**
	 *   Returns champion splash from API static-data Champion object in img HTML TAG.
	 *
	 * @param StaticChampionDto $champion
	 * @param int               $skin
	 * @param array             $attributes
	 *
	 * @return Html
	 */
	public static function getChampionSplashO( StaticChampionDto $champion, int $skin = 0, array $attributes = [] ): Html
	{
		return self::getChampionSplash($champion->key, $skin, $attributes);
	}

	/**
	 *   Returns champion loading screen image in img HTML TAG.
	 *
	 * @param string $champion_name
	 * @param int    $skin
	 * @param array  $attributes
	 *
	 * @return Html
	 */
	public static function getChampionLoading( string $champion_name, int $skin = 0, array $attributes = [] ): Html
	{
		$attrs = array_merge([ 'alt' => $champion_name ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_CHAMP_LOADING_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['src'] = self::getSetting(self::SET_ENDPOINT) . "img/champion/loading/{$champion_name}_{$skin}.jpg";

		return Html::el('img', $attrs);
	}

	/**
	 *   Returns champion loading screen image from API static-data Champion object in
	 * img HTML TAG.
	 *
	 * @param StaticChampionDto $champion
	 * @param int               $skin
	 * @param array             $attributes
	 *
	 * @return Html
	 */
	public static function getChampionLoadingO( StaticChampionDto $champion, int $skin = 0, array $attributes = [] ): Html
	{
		return self::getChampionLoading($champion->key, $skin, $attributes);
	}

	/**
	 *   Returns champion icon in img HTML TAG.
	 *
	 * @param string $champion_name
	 * @param array  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getChampionIcon( string $champion_name, array $attributes = [] ): String
	{
		self::checkInit();

		$attrs = array_merge([ 'alt' => $champion_name ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_CHAMP_ICON_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		// $attrs['src'] = self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/champion/{$champion_name}.png";

		// return Html::el('img', $attrs);
		//$champion_name = str_replace("'", " ", $champion_name);
		return self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/champion/{$champion_name}.png";
	}

	/**
	 *   Returns champion icon from API static-data Champion object in img HTML TAG.
	 *
	 * @param StaticChampionDto $champion
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getChampionIconO( StaticChampionDto $champion, array $attributes = [] ): Html
	{
		return self::getChampionIcon($champion->key, $attributes);
	}

	/**
	 *   Returns icon from icon sprite in img HTML TAG.
	 *
	 * @param string $source
	 * @param int    $x
	 * @param int    $y
	 * @param int    $w
	 * @param int    $h
	 * @param array  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getFromSprite( string $source, int $x, int $y, int $w = 48, int $h = 48, array $attributes = [] ): Html
	{
		self::checkInit();

		$attrs = array_merge([ 'alt' => 'Sprite Icon' ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_SPRITE_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['style'] = 'background: transparent url(' . self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/sprite/{$source}" . ") -{$x}px -{$y}px; width: {$w}px; height: {$h}px;";
		$attrs['src'] = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
		
		return Html::el('img', $attrs);
	}

	/**
	 *   Returns icon from API static-data ImageDto object in img HTML TAG.
	 *
	 * @param StaticImageDto $image
	 * @param array          $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getFromSpriteO( StaticImageDto $image, array $attributes = [] ): Html
	{
		return self::getFromSprite($image->sprite, $image->x, $image->y, $image->w, $image->h, $attributes);
	}

	/**
	 *   Returns summoner spell icon in img HTML TAG.
	 *
	 * @param string $spell_name
	 * @param array  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getSpellIcon( string $spell_name, array $attributes = [] ): String
	{
		self::checkInit();

		$attrs = array_merge([ 'alt'   => $spell_name ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_SPELL_ICON_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		// $attrs['src'] = self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/spell/{$spell_name}.png";

		// return Html::el('img', $attrs);
		if ($spell_name === "Ignite") {
			$spell_name = "Dot";
		}
		return self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/spell/Summoner{$spell_name}.png";
	}

	/**
	 *   Returns summoner spell icon from API static-data SummonerSpell object in img
	 * HTML TAG.
	 *
	 * @param StaticSummonerSpellDto $summonerSpell
	 * @param array                  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getSummonerSpellIconO( StaticSummonerSpellDto $summonerSpell, array $attributes = [] ): Html
	{
		return self::getSpellIcon($summonerSpell->key, $attributes);
	}

	/**
	 *   Returns spell icon from API static-data ChampionSpell object in img
	 * HTML TAG.
	 *
	 * @param StaticChampionSpellDto $championSpell
	 * @param array                  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getChampionSpellIconO(StaticChampionSpellDto $championSpell, array $attributes = [] ): Html
	{
		return self::getSpellIcon($championSpell->key, $attributes);
	}

	/**
	 *   Returns item icon in img HTML TAG.
	 *
	 * @param int    $item_id
	 * @param array  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getItemIcon( int $item_id, array $attributes = [] ): String
	{
		self::checkInit();

		$attrs = array_merge([ 'alt'   => $item_id ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_ITEM_ICON_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		// $attrs['src'] = self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/item/{$item_id}.png";

		// return Html::el('img', $attrs);
		return self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/item/{$item_id}.png";
	}

	/**
	 *   Returns item icon from API static-data Item object in img HTML TAG.
	 *
	 * @param StaticItemDto $item
	 * @param array         $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getItemIconO( StaticItemDto $item, array $attributes = [] ): Html
	{
		return self::getItemIcon($item->id, $attributes);
	}

	/**
	 *   Returns mastery icon in img HTML TAG.
	 *
	 * @param int    $mastery_id
	 * @param array  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getMasteryIcon( int $mastery_id, array $attributes = [] ): Html
	{
		self::checkInit();

		$attrs = array_merge([ 'alt'   => $mastery_id ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_MASTERY_ICON_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['src'] = self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/mastery/{$mastery_id}.png";

		return Html::el('img', $attrs);
	}

	/**
	 *   Returns mastery icon from API static-data Mastery object in img HTML TAG.
	 *
	 * @param StaticMasteryDto $mastery
	 * @param array            $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getMasteryIconO( StaticMasteryDto $mastery, array $attributes = [] ): Html
	{
		return self::getMasteryIcon($mastery->id, $attributes);
	}

	/**
	 *   Returns rune icon in img HTML TAG.
	 *
	 * @param int    $rune_id
	 * @param array  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getRuneIcon( int $rune_id, array $attributes = [] ): Html
	{
		self::checkInit();

		$attrs = array_merge([ 'alt'   => $rune_id ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_RUNE_ICON_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['src'] = self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/rune/{$rune_id}.png";

		return Html::el('img', $attrs);
	}

	/**
	 *   Returns rune icon from API static-data Rune object in img HTML TAG.
	 *
	 * @param StaticRuneDto $rune
	 * @param array         $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getRuneIconO( StaticRuneDto $rune, array $attributes = [] ): Html
	{
		return self::getRuneIcon($rune->id, $attributes);
	}

	/**
	 *   Returns minimap in img HTML TAG.
	 *
	 * @param int    $map_id
	 * @param array  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getMinimap( int $map_id, array $attributes = [] ): Html
	{
		self::checkInit();

		$attrs = array_merge([ 'alt' => $map_id ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_MINIMAP_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['src'] = self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/map/map{$map_id}.png";

		return Html::el('img', $attrs);
	}

	/**
	 *   Returns minimap from API static-data MapDetails object in img HTML TAG.
	 *
	 * @param StaticMapDetailsDto $mapDetails
	 * @param array               $attributes
	 * 
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getMinimapO( StaticMapDetailsDto $mapDetails, array $attributes = [] ): Html
	{
		return self::getMinimap($mapDetails->mapId, $attributes);
	}

	/**
	 *   Returns UI icon in img HTML TAG.
	 *
	 * @param string $name
	 * @param array  $attributes
	 *
	 * @return Html
	 * @throws SettingsException
	 */
	public static function getScoreboardIcon( string $name, array $attributes = [] ): Html
	{
		self::checkInit();

		$attrs = array_merge([ 'alt' => $name ], self::getSetting(self::SET_CUSTOM_IMG_ATTRS, []), $attributes);
		$attrs['class'] = implode(' ', [
			self::getSetting(self::SET_DEFAULT_CLASS),
			self::getSetting(self::SET_UI_ICON_CLASS),
			@self::getSetting(self::SET_CUSTOM_IMG_ATTRS, [])['class'],
			@$attributes['class'],
		]);
		$attrs['src'] = self::getSetting(self::SET_ENDPOINT) . self::getSetting(self::SET_VERSION) . "/img/ui/{$name}.png";

		return Html::el('img', $attrs);
	}
}