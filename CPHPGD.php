<?php

	/* 
	CPHPGD - Class for PHP GD library handling
	Copyright (C) 2011 Aleksi Räsänen <aleksi.rasanen@runosydan.net>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as
	published by the Free Software Foundation, either version 3 of the
	License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	*/
	 
	// ************************************************** 
	//  CPHPGD
	/*!
		@brief Class for PHP GD Library handling
		@author Aleksi Räsänen
		@email aleksi.rasanen@runosydan.net
		@copyright Aleksi Räsänen, 2011
		@license GNU AGPL
	*/
	// ************************************************** 
	class CPHPGD
	{
		private $image;
		private $color;

		// ************************************************** 
		//  __destruct
		/*!
			@brief Class destructor. Removes image from memory.
		*/
		// ************************************************** 
		public function __destruct()
		{
			imagedestroy( $this->image );
		}

		// ************************************************** 
		//  createImage
		/*!
			@brief Create a new white image canvas
			@param $width Image width
			@param $height Image height
		*/
		// ************************************************** 
		public function createImage( $width, $height )
		{
			$this->image = imagecreatetruecolor( $width, $height );	
			$this->setColor( '#FFFFFF' );
			$this->fill( 0, 0 );
		}

		// ************************************************** 
		//  fill
		/*!
			@brief Performs a flood fill. Color used is set via setColor.
			@param $x X-Coordinate
			@param $y Y-Coordinate
		*/
		// ************************************************** 
		public function fill( $x, $y )
		{
			$color = $this->createColorAllocation();
			imagefill( $this->image, $x, $y, $color );
		}

		// ************************************************** 
		//  saveImage
		/*!
			@brief Save the final image
			@param $filename Filename
		*/
		// ************************************************** 
		public function saveImage( $filename )
		{
			$ext = $this->getFileExtension( $filename );

			switch( $ext )
			{
				case 'png':
					imagepng( $this->image, $filename );
					break;

				case 'jpg':
				case 'jpeg':
				default:
					imagejpeg( $this->image, $filename );
					break;
			}
		}

		// ************************************************** 
		//  drawRectangle
		/*!
			@brief Draws a rectangle with current color what
			  is set using method setColor. By default it is black.
			@param $x1 X start point
			@param $y1 Y start point
			@param $x2 X end point
			@param $y2 Y end point
		*/
		// ************************************************** 
		public function drawRectangle( $x1, $y1, $x2, $y2 )
		{
			$color = $this->createColorAllocation();
			imagerectangle( $this->image, $x1, $y1, $x2, $y2, $color );
		}

		// ************************************************** 
		//  drawFilledRectangle
		/*!
			@brief Draws a rectangle what will be floodfilled
			  with current color.
			@param $x1 X start point
			@param $y1 Y start point
			@param $x2 X end point
			@param $y2 Y end point
		*/
		// ************************************************** 
		public function drawFilledRectangle( $x1, $y1, $x2, $y2 )
		{
			$color = $this->createColorAllocation();
			imagefilledrectangle( $this->image, $x1, $y1, 
				$x2, $y2, $color );
		}


		// ************************************************** 
		//  drawEllipse
		/*!
			@brief Draws an ellipse
			@param $cx Center's X coordinate
			@param $cy Center's Y coordinate
			@param $width The ellipse width
			@param $height The ellipse height
		*/
		// ************************************************** 
		public function drawEllipse( $cx, $cy, $width, $height )
		{
			$color = $this->createColorAllocation();
			imageellipse( $this->image, $cx, $cy, $width, 
				$height, $color );
		}

		// ************************************************** 
		//  drawFilledEllipse
		/*!
			@brief Draws an filled ellipse
			@param $cx Center's X coordinate
			@param $cy Center's Y coordinate
			@param $width The ellipse width
			@param $height The ellipse height
		*/
		// ************************************************** 
		public function drawFilledEllipse( $cx, $cy, $width, $height )
		{
			$color = $this->createColorAllocation();
			imagefilledellipse( $this->image, $cx, $cy, $width, 
				$height, $color );
		}

		// ************************************************** 
		//  drawPolygon
		/*!
			@brief Draws a polygon
			@param $points Array of points, must be in format where
			  every second item is x and every other is y.
		*/
		// ************************************************** 
		public function drawPolygon( $points )
		{
			$color = $this->createColorAllocation();
			imagepolygon( $this->image, $points, 
				( count( $points ) ) / 2, $color );
		}

		// ************************************************** 
		//  drawPolygon
		/*!
			@brief Draws a filled polygon
			@param $points Array of points, must be in format where
			  every second item is x and every other is y.
		*/
		// ************************************************** 
		public function drawFilledPolygon( $points )
		{
			$color = $this->createColorAllocation();
			imagefilledpolygon( $this->image, $points, 
				( count( $points ) ) / 2, $color );
		}

		// ************************************************** 
		//  drawPixel
		/*!
			@brief Draw one pixel
			@param $x X position
			@param $y Y position
		*/
		// ************************************************** 
		public function drawPixel( $x, $y )
		{
			$color = $this->createColorAllocation();
			imagesetpixel( $this->image, $x, $y, $color );
		}

		// ************************************************** 
		//  drawArc
		/*!
			@brief Draws an arc
			@param $cx X center
			@param $cy Y center
			@param $width Width of an arc
			@param $height Height of an arc
			@param $start Start angle in decrees
			@param $end End angle in decrees.
		*/
		// ************************************************** 
		public function drawArc( $cx, $cy, $width, $height, $start, $end )
		{
			$color = $this->createColorAllocation();
			imagearc( $this->image, $cx, $cy, $width, $height,
				$start, $end, $color );
		}

		// ************************************************** 
		//  setColor
		/*!
			@brief Set color what will be used in next action
			@param $color Color in HEX-value
		*/
		// ************************************************** 
		public function setColor( $color )
		{
			$this->color = $this->colorToArray( $color );
		}

		// ************************************************** 
		//  getFileExtension
		/*!
			@brief Get file extension from filename
			@param $filename Filename
			@return File extension without leading dot
		*/
		// ************************************************** 
		private function getFileExtension( $filename )
		{
			$filename = explode( '.', basename( $filename ) );
			$max = count( $filename ) -1;

			if( $max > 0 )
				return $filename[$max];

			return '';
		}

		// ************************************************** 
		//  colorToArray
		/*!
			@brief Create array from color code what is
			  formatted hexadecimal way. If not enough letters
			  are given, we create white color.
			@param $color Color in hexadecimal, with or without leading #
			@return Array
		*/
		// ************************************************** 
		private function colorToArray( $color )
		{
			if( strlen( $color ) != 6 && strlen( $color ) != 7 )
				return array( 255, 255, 255 );

			if( strlen( $color ) == 7 )
				$color = substr( $color, 1 );

			$color_array = str_split( $color, 2 );

			for( $i=0; $i < count( $color_array ); $i++ )
				$color_array[$i] = hexdec( $color_array[$i] );

			return $color_array;
		}

		// ************************************************** 
		//  createColorAllocation
		/*!
			@brief Create color allocation
			@return Color allocation
		*/
		// ************************************************** 
		private function createColorAllocation()
		{
			$col = $this->color;
			return imagecolorallocate( $this->image, $col[0], 
				$col[1], $col[2] );
		}
	}

?>
