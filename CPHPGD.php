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
			$this->fill( 0, 0, 'FFFFFF' );
		}

		// ************************************************** 
		//  fill
		/*!
			@brief Performs a flood fill
			@param $x X-Coordinate
			@param $y Y-Coordinate
			@param $color Color in hex format, like #FFAAFF
		*/
		// ************************************************** 
		public function fill( $x, $y, $color )
		{
			$color_array = $this->colorToArray( $color );
			$color_alloc = imagecolorallocate( $this->image, 
				$color_array[0], $color_array[1], $color_array[2] );

			imagefill( $this->image, $x, $y, $color_alloc );
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
	}

?>
