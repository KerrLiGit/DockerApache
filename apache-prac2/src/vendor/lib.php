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

	function get_shapes() {
		return array(
			0 => 'rect x="10" y="10" width="300" height="300"',
			1 => 'rect x="10" y="10" rx="25" ry="25" width="300" height="300"',
			2 => 'circle cx="200" cy="200" r="150"',
			3 => 'ellipse cx="200" cy="200" rx="150" ry="100"'
		);
	}


	function out_shape($num) {
		$colors = get_colors();
		$shapes = get_shapes();
	
		// ������
		$shapebits = $num & 0b11;
		$shapesvg = $shapes[$shapebits];
		$num >>= 2;
		// ���� �������
		$fillcolorbits = $num & 0b111;
		$fillcolorname = $colors[$fillcolorbits];
		$num >>= 3;
		// ���� �����
		$strokecolorbits = $num & 0b111;
		$strokecolorname = $colors[$strokecolorbits];
		$num >>= 3;

		// �����
		echo      '    <svg width="500" height="500">' . "\n"
			. '        <' . $shapesvg  . "\n"
			. '         stroke="' . $strokecolorname . '"' . "\n"
			. '         stroke-width="4"' . "\n"
			. '         fill="' . $fillcolorname . '"' . "\n"
			. '    />' . "\n";
	}

	function insertion_sort($a) {
 		// ��� ������� $a[$i] ������� �� ������� ��������...
		for ($i = 1; $i < count($a); $i++) {
			$x = $a[$i];
			for ($j = $i - 1; $j >= 0 && $a[$j] > $x; $j--) {
				/* �������� �������� ������, ���� ����������� �������
				   $a[$j] > $a[$i] */
				 $a[$j + 1] = $a[$j];
			}
			// �� ���������� ����� ������ �����, ������ $a[$i]
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
			echo '<p>������� "' . $cmd . '" �� �������!</p>';
		else {
			//$vout = mb_convert_encoding($vout, "utf-8");
			for ($i = 0; $i < count($vout); $i++)
				echo '<p>' . $vout[$i] . '</p>'  . "\n";
		}
	}

?>