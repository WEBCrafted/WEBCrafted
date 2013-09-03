<?php
class TimeUtils {
	/**
	 * Récupère la différence de temps entre l'heure actuelle et l'heure donnée
	 */
	public static function getTimeDiff($time) {
		$timePosted = date_timestamp_get(date_create($time));
		$now = time();
		$diff = $now - $timePosted;

		// Les unités
		$sec   = 1;
		$min   = $sec   * 60;
		$hours = $min   * 60;
		$day   = $hours * 24;
		$week  = $day   * 7;
		$month = $day   * 30;
		$year  = $day   * 365;

		if($diff / $year >= 1)
			return "il y a " . (int)($diff / $year)  . " année"   . ((int)($diff / $year)  >= 1 ? "s" : "");

		else if($diff / $month >= 1)
			return "il y a " . (int)($diff / $month) . " mois";

		else if($diff / $week >= 1)
			return "il y a " . (int)($diff / $week)  . " semaine" . ((int)($diff / $week)  >= 1 ? "s" : "");

		else if($diff / $day >= 1)
			return "il y a " . (int)($diff / $day)   . " jour"    . ((int)($diff / $week)  >= 1 ? "s" : "");

		else if($diff / $hours >= 1)
			return "il y a " . (int)($diff / $hours) . " heure"   . ((int)($diff / $hours) >= 1 ? "s" : "");

		else if($diff / $min >= 1)
			return "il y a " . (int)($diff / $min)   . " minute"  . ((int)($diff / $min)   >= 1 ? "s" : "");

		else if($diff / $sec >= 1)
			return "il y a " . (int)($diff / $sec)   . " seconde" . ((int)($diff / $sec)   >= 1 ? "s" : "");

		else
			return "à l'instant";
	}
}
