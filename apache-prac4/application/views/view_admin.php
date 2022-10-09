<link rel="stylesheet" href="/css/anchor.css">
<link rel="stylesheet" href="/css/cboard.css">

<div id="unic_content">
	<div class="anchor_wrapper">
		<nav><div class="anchor_menu" id="anchor_content">
				<div><a id="panel" href="#log" style="font-size: 18px; padding-bottom: 10px;">Логи</a></div>
			</div></nav>
		<div class="anchor_main">
			<a class="anchor" id="log"></a>
			<article>Список логов</article>
			<div style="padding-bottom: 10px;">
				<form action="" method="post">
					<input type="hidden" name="query" value="log">
					<table>
						<tr>
							<td><label>Период</label></td>
							<td><label><input type="date" name="datefrom" title="От" required
											  value="<?php echo date("Y-m-d") ?>">&nbsp;-</label>
								<label><input type="date" name="dateto" title="До" required
											  value="<?php echo date("Y-m-d") ?>"><br></label></td>
						</tr>
						<tr>
							<td><label>Тип</label></td>
							<td>
								<select name="action" required>
									<option value="all">Все</option>
									<option value="INSERT">INSERT</option>
									<option value="UPDATE">UPDATE</option>
									<option value="DELETE">DELETE</option>
								</select>
							</td>
					</table>
					<button type="submit" title="Вывести список логов">Вывести</button>
				</form>
			</div>
			<div style="padding-bottom: 10px;">
				<?php
				if (array_key_exists(0, $log)) {
					echo '<table class="cboard" style="font-size:0.7em;">';
					echo '<tr>';
					echo '<td style="width:10em"><b>eventdate</b></td>';
					echo '<td><b>login</b></td>';
					echo '<td><b>action</b></td>';
					echo '<td><b>tablename</b></td>';
					echo '<td><b>descript</b></td>';
					echo '</tr>';
					for ($i = 0; $i < count($log); $i++) {
						echo '<tr>';
						echo '<td>' . $log[$i]['eventdate'] . '</td>';
						echo '<td>' . $log[$i]['login'] . '</td>';
						echo '<td>' . $log[$i]['action'] . '</td>';
						echo '<td>' . $log[$i]['tablename'] . '</td>';
						echo '<td>' . $log[$i]['descript'] . '</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
				?>
			</div>
			<!--<a class="anchor" id="another"></a>
				<article>Пустой блок</article>
				<div style="padding-bottom: 10px;">
					Текст...
				</div>-->
		</div>
		<!--<div class="anchor_button"></div>-->
	</div>
	<!--<a href="#openModal">Открыть модальное окно</a>
	<div id="openModal" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Название</h3>
					<a href="#close" title="Close" id="close" color='floralwhite'>&times;</a>
				</div>
				<div class="modal-body">
					<p>Содержимое модального окна...</p>
				</div>
			</div>
		</div>
	</div>-->
</div>

<!--<script>
	document.addEventListener("DOMContentLoaded", function () {
		var scrollbar = document.body.clientWidth - window.innerWidth + 'px';
		console.log(scrollbar);
		document.querySelector('[href="#openModal"]').addEventListener('click', function () {
			document.body.style.overflow = 'hidden';
			document.querySelector('#openModal').style.marginLeft = scrollbar;
		});
		document.querySelector('[href="#close"]').addEventListener('click', function () {
			document.body.style.overflow = 'visible';
			document.querySelector('#openModal').style.marginLeft = '0px';
		});
	});
</script>-->