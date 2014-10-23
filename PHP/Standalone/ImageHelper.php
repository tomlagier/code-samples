<?php

/**
 * This file was a part of a project that would construct a custom Google Map out of a set of uploaded images in a
 * progression of resolutions. It worked with ImageMagick (Imagick class in PHP) to slice each image into a set of
 * 256x256 tiles, and would pad out the image with grey so each tile would always be filled. 
 * 
 * Once the image was sliced, it would dump everything in a single directory, to be assembled on the front end.
 * I've got that code to show, but it's pretty seriously incomplete. This stuff is much nicer.
 *
 * Written by Tom Lagier
 */

class ImageHelper {

	/**
	 * Preps a set of images for slicing to ensure that there are an appropriate number of tiles for each image
	 */
	static function sliceImages($inputPath, $names, $outputPath)
	{
		$BACKGROUND_GREY = 'rgb(229, 227, 223)';

		$images = [];

		foreach ($names as $name)
		{
			$images[] = new Imagick($inputPath . $name);
		}

		//Use the smallest image as our sizing base
		$baseDimensions = ImageHelper::paddedImageSize($images[0]);

		foreach($images as $index => $image)
		{
			//Calculate the correct dimensions of the image based on the small image and the power-of-two zoom
			$dimensions = array(
				'width' => $baseDimensions['width'] * pow(2, $index),
				'height' => $baseDimensions['height'] * pow(2, $index),
			);

			//Pad or crop the image to be correctly proportional
			$image = ImageHelper::padImage($image, $dimensions['width'], $dimensions['height'], $BACKGROUND_GREY);

			//Slice the image out
			ImageHelper::sliceImage($image, $outputPath . ($index + 1) . '-');
		}

		return array(
			'rows' => $baseDimensions['rows'],
			'columns' => $baseDimensions['columns']
		);
	}

	/**
	 * Get the image size for an image to be sliced
	 */
	static function paddedImageSize($image)
	{
		$TILE_WIDTH = 256;
		$TILE_HEIGHT = 256;

		$size = $image->getImageGeometry();

		$widthRemainder = $TILE_WIDTH - ($size['width'] % $TILE_WIDTH);
		$heightRemainder = $TILE_HEIGHT - ($size['height'] % $TILE_HEIGHT);

		$width = $size['width'] + $widthRemainder;
		$height = $size['height'] + $heightRemainder;

		$rows = $width / $TILE_WIDTH;
		$cols = $height / $TILE_WIDTH;

		return array(
			'width' => $width,
			'height' => $height,
			'rows' => $rows,
			'columns' => $cols
		);
	}

	/**
	 * Pads an image to the specified dimensions and returns an Imagick instance
	 */
	static function padImage($image, $width, $height, $color)
	{
		$size = $image->getImageGeometry();

		$xOffset = ($width - $size['width']) / 2;
		$yOffset = ($height - $size['height']) / 2;

		$returnImage = new Imagick();
		$returnImage->newImage($width, $height, $color);

		$returnImage->compositeImage($image, Imagick::COMPOSITE_DEFAULT, $xOffset, $yOffset);

		return $returnImage;
	}

	/**
	 * Slices an image into a set of 256 x 256 tiles with appropriate names and puts them in the $outputDir.
	 * Pads "empty" tiles with white.
	 */
	static function sliceImage($image, $outputHandle)
	{
		$TILE_WIDTH = 256;
		$TILE_HEIGHT = 256;

		$dimensions = $image->getImageGeometry();

		//Number of slices in each direction
		$tileCols = $dimensions['width'] / $TILE_WIDTH;
		$tileRows = $dimensions['height'] / $TILE_HEIGHT;

		//Write our individual slices
		for($col = 0; $col < $tileCols; $col++){
			for ($row = 0; $row < $tileRows; $row++){

				$tileXOffset = $col * $TILE_WIDTH;
				$tileYOffset = $row * $TILE_HEIGHT;

				$tile = $image->getImageRegion($TILE_WIDTH, $TILE_HEIGHT, $tileXOffset, $tileYOffset);

				$filename = $outputHandle . $col . '-' . $row . '.jpg';

				$tile->writeImage($filename);
			}
		}
	}
}