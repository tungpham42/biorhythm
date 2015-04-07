<link href="/min/f=css/2048.css&amp;6" rel="stylesheet" type="text/css">
<div class="container">
	<div class="heading">
		<h1 class="title">2048</h1>
		<div class="scores-container">
			<div class="score-container">0</div>
			<div class="best-container">0</div>
		</div>
	</div>

	<div class="above-game">
		<p class="game-intro">Kết hợp các số để được <strong>khối 2048!</strong></p>
		<p class="game-intro">Join the numbers and get to the <strong>2048 tile!</strong></p>
		<a class="restart-button">New Game</a>
	</div>

	<div class="game-container">
		<div class="game-message">
			<p></p>
			<div class="lower">
				<a class="keep-playing-button">Keep going</a>
				<a class="retry-button">Try again</a>
			</div>
		</div>

		<div class="grid-container">
			<div class="grid-row">
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
			</div>
			<div class="grid-row">
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
			</div>
			<div class="grid-row">
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
			</div>
			<div class="grid-row">
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
				<div class="grid-cell"></div>
			</div>
		</div>

		<div class="tile-container">

		</div>
	</div>

	<p class="game-explanation">
		<strong class="important">Cách chơi:</strong> Dùng <strong>phím mũi tên</strong> để di chuyển các khối. Hai khối cùng số chạm nhau sẽ <strong>nhập làm một và nhân hai!</strong>
		<strong class="important">How to play:</strong> Use your <strong>arrow keys</strong> to move the tiles. When two tiles with the same number touch, they <strong>merge into one!</strong>
	</p>
	<hr>
	<p>
	Created by <a href="http://gabrielecirulli.com" target="_blank">Gabriele Cirulli.</a>
	</p>
</div>
<script src="/min/b=js/2048&amp;f=bind_polyfill.js,classlist_polyfill.js,animframe_polyfill.js,keyboard_input_manager.js,html_actuator.js,grid.js,tile.js,local_storage_manager.js,game_manager.js,application.js&amp;1"></script>