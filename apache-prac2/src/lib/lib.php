<?php
	function get_colors() {
		return array(
			0 => 'orange',
			1 => 'green',
			2 => 'yellow',
			3 => 'red',
			4 => 'blue',
			5 => 'brown',
			6 => 'magenta',
			7 => 'black'
		);
	}

	function get_shapes($size) {
		return array(
			0 => 'rect x="10" y="10" width="' . $size . '" height="' . $size . '"',
			1 => 'rect x="10" y="10" rx="25" ry="25" width="' . $size . '" height="' . $size . '"',
			2 => 'circle cx="' . $size / 2 + 10 . '" cy="' . $size / 2 + 10 . '" r="' . $size / 2 . '"',
			3 => 'ellipse cx="' . $size / 2 + 10 . '" cy="' . $size / 2 + 10 . '" rx="' . $size / 2 . '" ry="' . $size / 3 . '"'
		);
	}

	function get_size() {
		return array(
			0 => '100',
			1 => '200',
			2 => '300',
			3 => '500'
		);			
	}


	function out_shape($num) {
		$colors = get_colors();
		$sizes = get_size();
	
		// размер
		$sizebits = $num & 0b11;
		$sizesvg = $sizes[$sizebits];
		$num >>= 2;
		// фигура
		$shapes = get_shapes($sizesvg);
		$shapebits = $num & 0b11;
		$shapesvg = $shapes[$shapebits];
		$num >>= 2;
		// цвет заливки
		$fillcolorbits = $num & 0b111;
		$fillcolorname = $colors[$fillcolorbits];
		$num >>= 3;
		// цвет рамки
		$strokecolorbits = $num & 0b111;
		$strokecolorname = $colors[$strokecolorbits];
		$num >>= 3;

		// вывод
		echo      '    <svg width="' . $sizesvg + 20 . '" height="' . $sizesvg + 20 . '">' . "\n"
			. '        <' . $shapesvg  . "\n"
			. '         stroke="' . $strokecolorname . '"' . "\n"
			. '         stroke-width="4"' . "\n"
			. '         fill="' . $fillcolorname . '"' . "\n"
			. '    />' . "\n";
	}

	function insertion_sort($a) {
 		// для каждого $a[$i] начиная со второго элемента...
		for ($i = 1; $i < count($a); $i++) {
			$x = $a[$i];
			for ($j = $i - 1; $j >= 0 && $a[$j] > $x; $j--) {
				/* сдвигаем элементы вправо, пока выполняется условие
				   $a[$j] > $a[$i] */
				 $a[$j + 1] = $a[$j];
			}
			// на оставшееся после сдвига место, ставим $a[$i]
			$a[$j + 1] = $x;
		}
		return $a;
	}

	function out_sort_array($s) {
		$vs = explode(',', $s);
		$vn = array();
		for ($i = 0; $i < count($vs); $i++)
			$vn[$i] =  intval($vs[$i]);
		$vn = insertion_sort($vn);
		echo "    <p>";
		for ($i = 0; $i < count($vn); $i++)
			echo ($i == 0 ? "" : ", ") . strval($vn[$i]);
		echo "</p>";
	}

	function out_command_result($cmd) {
		$vout = array();
		$s = exec($cmd, $vout);
		if (!$s)
			echo '<p>Команда "' . $cmd . '" не найдена!</p>';
		else {
			//$vout = mb_convert_encoding($vout, "utf-8");
			for ($i = 0; $i < count($vout); $i++)
				echo '<p>' . $vout[$i] . '</p>'  . "\n";
		}
	}

?>