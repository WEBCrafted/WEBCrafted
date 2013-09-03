<?php
/**
 * Classe du cropper (rogneur). Permet de redimmensionner des images.
 * @package fr.solicium.cropper
 * @author Solicium Team
 * @version 2.0
 * @since 1.0
 */
class Cropper extends Core {
	/**
	 * Le constructeur du bundle Cropper
	 */
	public function __construct() {
		parent::__construct();
	}
	
    /**
     * Crée une miniature d'une image
     * @param string $path Le chemin de l'image
     * @param string $name Le nom de l'image
     * @param int $new_width La nouvelle largeur de l'image en pixels
     * @param int $new_height La nouvelle hauteur de l'image en pixels
     * @param string $ext L'extension de l'image
     */
	public function createThumbnail($path, $name, $new_width, $new_height, $ext) {
		if(file_exists("$path" . "$name" . "_" . "$new_width" . "x" . "$new_height.$ext"))
			die(file_get_contents("$path/$name" . "_" . $new_width . "x" . $new_height . ".png"));

		$dimension = getimagesize("$path" . "$name.$ext");

		switch($ext) {
			case "jpeg":
				$image = imagecreatefromjpeg("$path" . "$name.jpeg");
				break;
			case "png":
				$image = imagecreatefrompng("$path" . "$name.png");
				break;
			case "gif":
				$image = imagecreatefromgif("$path" . "$name.gif");
				break;
		}

		$miniature = imagecreatetruecolor($new_width, $new_height);
		imagealphablending($miniature, false);
		imagesavealpha($miniature, true);

		if($dimension[0] > ($new_width / $new_height) * $dimension[1]) {
			$dimY = $new_height;
			$dimX = $new_height * $dimension[0] / $dimension[1];
			$decalX =- ($dimX - $new_width) / 2;
			$decalY = 0;
		}
		if($dimension[0] < ($new_width / $new_height) * $dimension[1]) {
			$dimX = $new_width;
			$dimY = $new_width * $dimension[1] / $dimension[0];
			$decalY =- ($dimY - $new_height) / 2;
			$decalX = 0;
		}
		if($dimension[0] == ($new_width / $new_height) * $dimension[1]) {
			$dimX = $new_width;
			$dimY = $new_height;
			$decalX = 0;
			$decalY = 0;
		}

		imagecopyresampled($miniature, $image, $decalX, $decalY, 0, 0, $dimX, $dimY, $dimension[0], $dimension[1]);
		imagepng($miniature, "$path" . "$name" . "_" . $new_width . "x" . $new_height . ".png");
		die(file_get_contents("$path" . "$name" . "_" . $new_width . "x" . $new_height . ".png"));
	}
}
