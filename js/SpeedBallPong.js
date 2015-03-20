var __extends = this.__extends || function(c, d) {
		function g() {
			this.constructor = c
		}
		for (var b in d) d.hasOwnProperty(b) && (c[b] = d[b]);
		g.prototype = d.prototype;
		c.prototype = new g
	},
	ram64;
(function(c) {
	var d = function(c) {
		function b() {
			c.apply(this, arguments)
		}
		__extends(b, c);
		b.prototype.preload = function() {
			this.game.load.image("preload_fill", "/js/pong/images/preload_bar_fill.png");
			this.game.load.image("preload_bg", "/js/pong/images/preload_bar_bg.png")
		};
		b.prototype.create = function() {
			this.input.maxPointers = 1;
			this.stage.disableVisibilityChange = !0;
			this.game.add.text(0, 0, "fix", {
				font: "24px Computerfont",
				fill: "#e5e5e5"
			}).visible = !1;
			this.game.device.desktop ? (this.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL, this.scale.minWidth = 400, this.scale.minHeight = 300, this.scale.maxWidth = 800, this.scale.maxHeight = 600, this.scale.pageAlignHorizontally = !0, this.scale.pageAlignVertically = !0) : (this.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL, this.scale.minWidth = 400, this.scale.minHeight = 300, this.scale.maxWidth = 1280, this.scale.maxHeight = 800, this.scale.pageAlignHorizontally = !0, this.scale.pageAlignVertically = !0, this.scale.forceOrientation(!0, !1), this.scale.hasResized.add(this.gameResized, this), this.scale.enterIncorrectOrientation.add(this.enterIncorrectOrientation, this), this.scale.leaveIncorrectOrientation.add(this.leaveIncorrectOrientation, this));
			this.scale.setScreenSize(!0);
			this.game.state.start("SPreload", !0, !1)
		};
		b.prototype.gameResized = function(a, b) {};
		b.prototype.enterIncorrectOrientation = function() {
			alert("Incorrect orientation entered")
		};
		b.prototype.leaveIncorrectOrientation = function() {};
		return b
	}(Phaser.State);
	c.SBoot = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b() {
			c.apply(this, arguments)
		}
		__extends(b, c);
		b.prototype.create = function() {
			var a = this.game;
			this.background = a.add.group();
			this.background.create(0, 0, "commonBg");
			this.background.create(160, 256, "mainMenuBgFX");
			this.startGameBtn = a.add.button(20, 210, "newGameBtn", this.onNewGameClick, this);
			this.startGameBtn.input.useHandCursor = !0;
			this.instructionsBtn = a.add.button(20, 253, "instructionsBtn", this.instructionsClick, this);
			this.instructionsBtn.input.useHandCursor = !0;
			this.highscoresBtn = a.add.button(20, 296, "scoreTableBtn", this.onHighScoresClick, this);
			this.highscoresBtn.input.useHandCursor = !0
		};
		b.prototype.onNewGameClick = function() {
			console.log("going to new game screen");
			this.game.state.start("SChoosePlayer", !0, !1)
		};
		b.prototype.instructionsClick = function() {
			console.log("Going to instructions screen");
			this.game.state.start("SInstructions", !0, !1)
		};
		b.prototype.onHighScoresClick = function() {
			console.log("Going to high scores screen");
			this.game.state.start("SHighScores", !0, !1)
		};
		return b
	}(Phaser.State);
	c.SMainMenu = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b() {
			c.apply(this, arguments)
		}
		__extends(b, c);
		b.prototype.preload = function() {
			this.stage.backgroundColor = "#362f2d";
			this.add.sprite(250, 291, "preload_bg");
			this.preloadBar = this.add.sprite(254, 295, "preload_fill");
			this.load.setPreloadSprite(this.preloadBar);
			var a = this.load;
			a.image("ball", "/js/pong/images/ball.png");
			a.image("touchCircle", "/js/pong/images/circ-max.png");
			a.image("touchRing", "/js/pong/images/ring-max.png");
			a.spritesheet("chosePlayerSS", "/js/pong/images/chosePlayerSS.png", 154, 135, 2);
			a.image("commonBg", "/js/pong/images/commonBg.jpg");
			a.image("instructionsBgFX", "/js/pong/images/instructionsBgFX.png");
			a.image("mainMenuBgFX", "/js/pong/images/mainMenuBgFX.jpg");
			a.image("scoresBgFX", "/js/pong/images/scoresBgFX.png");
			a.image("scoreFX", "/js/pong/images/scoreFX.png");
			a.image("newGameBg", "/js/pong/images/newGameBg.jpg");
			a.image("newGameBtn", "/js/pong/images/newGameBtn.png");
			a.image("backToMainBtn", "/js/pong/images/backToMainBtn.png");
			a.image("retryBtn", "/js/pong/images/retryBtn.png");
			a.image("submitBtn", "/js/pong/images/submitBtn.png");
			a.image("instructionsBtn", "/js/pong/images/instructionsBtn.png");
			a.image("scoreTableBtn", "/js/pong/images/scoreTableBtn.png");
			a.spritesheet("pauseResumeSS", "/js/pong/images/pauseResumeSS.png", 123, 19, 2);
			a.spritesheet("playerPaddlesSS", "/js/pong/images/playerPaddlesSS.png", 71, 136, 2);
			a.image("tableBg", "/js/pong/images/tableBg.jpg");
			a.audio("sfx", ["/js/pong/audio/fx_sounds.ogg", "/js/pong/audio/fx_sounds.mp3"])
		};
		b.prototype.create = function() {
			this.game.state.start("SMainMenu", !0, !1)
		};
		return b
	}(Phaser.State);
	c.SPreload = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b(a, h) {
			c.call(this, a, 0, 0, "playerPaddlesSS", 0);
			this.prevY = this.prevX = this._y = this._x = 0;
			this.paddleType = h;
			this.rectangle = new Phaser.Rectangle(0, 0, 0, 0);
			h == b.GREEN ? (this.anchor.setTo(0, 0.5), this.rectangle.setTo(0, 0, 30, 115), this.xOff = 50, this.yOff = 0) : h == b.RED ? (this.frame = 1, this.anchor.setTo(1, 0.5), this.rectangle.setTo(0, 0, 30, 115), this.xOff = -50, this.yOff = 0) : console.error("Invalid Paddle type defined")
		}
		__extends(b, c);
		Object.defineProperty(b.prototype, "x", {
			get: function() {
				return this._x
			},
			set: function(a) {
				this.rectangle && (this.rectangle.centerX = a + this.xOff);
				this.prevX = this._x;
				this._x = a;
				this.position.x = this._x
			},
			enumerable: !0,
			configurable: !0
		});
		Object.defineProperty(b.prototype, "y", {
			get: function() {
				return this._y
			},
			set: function(a) {
				this.rectangle && (this.rectangle.centerY = a + this.yOff);
				this.prevY = this._y;
				this._y = a;
				this.position.y = this._y
			},
			enumerable: !0,
			configurable: !0
		});
		b.GREEN = "green";
		b.RED = "red";
		return b
	}(Phaser.Sprite);
	c.Paddle = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b(a, b) {
			"undefined" === typeof b && (b = 12.5);
			c.call(this, a, 0, 0, "ball", 0);
			this.isOut = !1;
			this.prevY = this.prevX = this._y = this._x = 0;
			this.anchor.setTo(0.5, 0.5);
			this.circle = new Phaser.Circle(this.x, this.y, 2 * b);
			this.xSpeed = 5;
			this.ySpeed = 2;
			this.aSpeed = 1.5
		}
		__extends(b, c);
		Object.defineProperty(b.prototype, "x", {
			get: function() {
				return this._x
			},
			set: function(a) {
				this.circle && (this.circle.x = a);
				this.prevX = this._x;
				this._x = a;
				this.position.x = this._x
			},
			enumerable: !0,
			configurable: !0
		});
		Object.defineProperty(b.prototype, "y", {
			get: function() {
				return this._y
			},
			set: function(a) {
				this.circle && (this.circle.y = a);
				this.prevY = this._y;
				this._y = a;
				this.position.y = this._y
			},
			enumerable: !0,
			configurable: !0
		});
		b.MAX_X_SPEED = 10;
		b.MAX_Y_SPEED = 15;
		return b
	}(Phaser.Sprite);
	c.Ball = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b(a) {
			c.call(this, a);
			this._isDownFlag = !1;
			var b = this._circle = new Phaser.Sprite(a, 0, 0, "touchCircle");
			b.anchor.setTo(0.5, 0.5);
			this._ring = new Phaser.Sprite(a, 0, 0, "touchRing");
			this._ring.anchor.setTo(0.5, 0.5);
			this.add(this._circle);
			this.add(this._ring);
			b.inputEnabled = !0;
			b.input.useHandCursor = !0;
			b.events.onInputDown.add(this.animateHandler, this);
			b.events.onInputUp.add(this.animateHandler, this);
			this.onActivate = new Phaser.Signal;
			this.onDeactivate = new Phaser.Signal
		}
		__extends(b, c);
		b.prototype.animateHandler = function() {
			this._isDownFlag = !this._isDownFlag;
			this._tweenC && this.game.tweens.remove(this._tweenC);
			this._tweenR && this.game.tweens.remove(this._tweenR);
			this._tweenC = this.game.add.tween(this._circle.scale);
			this._tweenR = this.game.add.tween(this._ring.scale);
			this._isDownFlag ? (this._tweenC.to({
				x: 0.1,
				y: 0.1
			}, 250, Phaser.Easing.Sinusoidal.Out, !0), this._tweenR.to({
				x: 0.3,
				y: 0.3
			}, 250, Phaser.Easing.Sinusoidal.Out, !0, 250).onComplete.add(this.onActivateHandle, this)) : (this._tweenC.to({
				x: 1,
				y: 1
			}, 250, Phaser.Easing.Sinusoidal.Out, !0, 250).onComplete.add(this.onDeactivateHandler, this), this._tweenR.to({
				x: 1,
				y: 1
			}, 250, Phaser.Easing.Sinusoidal.Out, !0))
		};
		b.prototype.onActivateHandle = function() {
			this._circle.input.useHandCursor = !1;
			this.onActivate.dispatch()
		};
		b.prototype.onDeactivateHandler = function() {
			this._circle.input.useHandCursor = !0;
			this.onDeactivate.dispatch()
		};
		b.prototype.isDownFlag = function() {
			return this._isDownFlag
		};
		return b
	}(Phaser.Group);
	c.PaddleDriver = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b(a) {
			c.call(this, a);
			this.createPlayerNames();
			this.createScoreFields();
			this.createTimerField()
		}
		__extends(b, c);
		b.prototype.createPlayerNames = function() {
			var a;
			a = {
				font: "36px Computerfont",
				fill: "#E6FFC5"
			};
			a = new Phaser.Text(this.game, 0, 5, "Player 1", a);
			a.x = 10;
			this.add(a);
			a = {
				font: "36px Computerfont",
				fill: "#FFC5E2"
			};
			a = new Phaser.Text(this.game, 0, 5, "Player 2", a);
			a.anchor.setTo(1, 0);
			a.x = this.game.width - 10;
			this.add(a)
		};
		b.prototype.createScoreFields = function() {
			var a = {
				font: "60px Computerfont",
				fill: "#FFC5E2",
				align: "right"
			};
			this.p1ScoreField = new Phaser.Text(this.game, 0, 50, "0", a);
			this.p1ScoreField.anchor.setTo(1, 0);
			this.p1ScoreField.x = 0.5 * this.game.width - 10;
			this.add(this.p1ScoreField);
			a = {
				font: "60px Computerfont",
				fill: "#E6FFC5",
				align: "left"
			};
			this.p2ScoreField = new Phaser.Text(this.game, 0, 50, "0", a);
			this.p2ScoreField.anchor.setTo(0, 0);
			this.p2ScoreField.x = 0.5 * this.game.width + 10;
			this.add(this.p2ScoreField)
		};
		b.prototype.createTimerField = function() {
			this.timerField = new Phaser.Text(this.game, 0, 0, "00:00", {
				font: "36px Computerfont",
				fill: "#fbf8cd",
				align: "center"
			});
			this.timerField.anchor.setTo(0.5, 1);
			this.timerField.x = 0.5 * this.game.width;
			this.timerField.y = this.game.height;
			this.add(this.timerField)
		};
		b.prototype.setP1Score = function(a) {
			this.p1ScoreField.text = a
		};
		b.prototype.setP2Score = function(a) {
			this.p2ScoreField.text = a
		};
		b.prototype.updateTime = function(a) {
			if (a) {
				var b = Math.floor(a / 60).toString(),
					b = 1 == String(b).length ? "0" + b : b;
				a = (a - 60 * Math.floor(a / 60)).toString();
				a = 1 == String(a).length ? "0" + a : a;
				this.timerField.text = b + ":" + a
			} else this.timerField.text = "PAUSED"
		};
		b.prototype.reset = function() {
			this.setP1Score(0);
			this.setP2Score(0);
			this.updateTime(0)
		};
		return b
	}(Phaser.Group);
	c.HUD = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(d) {
		function b() {
			d.apply(this, arguments);
			this.fBallCollision = this.isOnPause = !0;
			this.fDebug = !1;
			this.fBallUpdate = !0;
			this.ballDirection = 1;
			this.playerSide = "left"
		}
		__extends(b, d);
		b.prototype.init = function(a) {
			"undefined" === typeof a && (a = "left");
			this.playerSide = a;
			console.log(a)
		};
		b.prototype.create = function() {
			var a = this.game;
			this.background = a.add.sprite(0, 0, "tableBg");
			this.zoneRect = new Phaser.Rectangle(50, 50, 700, 500);
			this.addBall();
			this.createPlayer();
			this.createCPU();
			"left" != this.playerSide ? this.swapPlayers() : null;
			this.createPaddleDriver();
			this.hud = new c.HUD(this.game);
			this.game.add.existing(this.hud);
			this.hud.updateTime(!1);
			a.input.keyboard.addKey(Phaser.Keyboard.D).onDown.add(function() {
				this.fDebug = !this.fDebug
			}, this);
			a.input.keyboard.addKey(Phaser.Keyboard.P).onDown.add(function() {
				this.isOnPause = !this.isOnPause
			}, this);
			this.sfx = a.add.audio("sfx");
			this.sfx.addMarker("wallHit", 0, 0.525, 0.7);
			this.sfx.addMarker("paddleHit", 0.594, 0.416);
			this.sfx.addMarker("winnerFX", 1.2, 1.609);
			this.sfx.addMarker("loserFX", 3, 0.976);
			this.p1Score = this.p2Score = this.passedTime = 0;
			this.startTime()
		};
		b.prototype.addBall = function() {
			this.ball = new c.Ball(this.game);
			this.ball.x = this.game.world.centerX;
			this.ball.y = this.game.world.centerY;
			this.game.add.existing(this.ball)
		};
		b.prototype.createPlayer = function() {
			this.human = this.p1 = new c.Paddle(this.game, c.Paddle.GREEN);
			this.game.add.existing(this.p1);
			this.p1.y = 0.5 * this.game.height;
			this.p1.x = 25
		};
		b.prototype.createCPU = function() {
			this.cpu = this.p2 = new c.Paddle(this.game, c.Paddle.RED);
			this.game.add.existing(this.p2);
			this.p2.x = this.game.width - 25;
			this.p2.y = 0.5 * this.game.height
		};
		b.prototype.createPaddleDriver = function() {
			this.paddleDriver = new c.PaddleDriver(this.game);
			this.paddleDriver.x = this.human.x - 50 * this.human.anchor.x + 25;
			this.paddleDriver.y = this.human.y;
			this.paddleDriver.onActivate.add(function() {
				this.isOnPause = !1
			}, this);
			this.paddleDriver.onDeactivate.add(function() {
				this.isOnPause = !0
			}, this)
		};
		b.prototype.update = function() {
			this.isOnPause || (this.fBallUpdate && this.updateBall(), this.updatePlayer(), this.updateCPU(), this.checkCollisions())
		};
		b.prototype.swapPlayers = function() {
			this.human = this.human == this.p1 ? this.p2 : this.p1;
			this.cpu = this.cpu == this.p2 ? this.p1 : this.p2
		};
		b.prototype.updatePlayer = function() {
			var a = this.paddleDriver;
			a.isDownFlag() ? (a.x = this.game.input.x, a.y = this.game.input.y, this.human.y += 0.2 * (a.y - this.human.y)) : (a.x += 0.2 * (this.human.x - 50 * this.human.anchor.x + 25 - a.x), a.y += 0.2 * (this.human.y - a.y));
			this.human.rectangle.bottom > this.zoneRect.bottom ? this.human.y = this.zoneRect.bottom - 0.5 * this.human.rectangle.height : this.human.rectangle.top < this.zoneRect.top && (this.human.y = this.zoneRect.top + 0.5 * this.human.rectangle.height)
		};
		b.prototype.updateCPU = function() {
			this.cpu.y += 0.15 * (this.ball.y - this.cpu.y);
			this.cpu.rectangle.bottom > this.zoneRect.bottom ? this.cpu.y = this.zoneRect.bottom - 0.5 * this.human.rectangle.height : this.cpu.rectangle.top < this.zoneRect.top && (this.cpu.y = this.zoneRect.top + 0.5 * this.cpu.rectangle.height)
		};
		b.prototype.updateBall = function() {
			var a = this.ball;
			a.x += a.xSpeed;
			a.y += a.ySpeed;
			a.angle += a.aSpeed;
			if (a.circle.left <= this.zoneRect.left || a.circle.right >= this.zoneRect.right) a.isOut = !0;
			a.isOut && (this.fBallCollision = !1, a.xSpeed -= 0.15 * a.xSpeed, a.ySpeed -= 0.15 * a.ySpeed, 0 > a.circle.left ? (a.x = a.circle.radius, a.xSpeed *= -1) : a.circle.right > this.game.width && (a.x = this.game.width - a.circle.radius, a.xSpeed *= -1), 0.001 > Math.abs(a.xSpeed) && 0.001 > Math.abs(a.ySpeed) && (this.fBallUpdate = !1, this.checkWin(), this.reset()));
			a.circle.top < this.zoneRect.top ? (a.y = this.zoneRect.top + a.circle.radius, a.ySpeed *= -1, this.sfx.play("wallHit")) : a.circle.bottom > this.zoneRect.bottom && (a.y = this.zoneRect.bottom - a.circle.radius, a.ySpeed *= -1, this.sfx.play("wallHit"))
		};
		b.prototype.checkCollisions = function() {
			this.fBallCollision && (this.ball.circle.left < this.p1.rectangle.right && this.ball.circle.top < this.p1.rectangle.bottom && this.ball.circle.bottom > this.p1.rectangle.top && (this.ball.x = this.p1.rectangle.right + this.ball.circle.radius, this.ball.y = this.ball.prevY, this.ball.xSpeed = -c.Ball.MAX_X_SPEED * this.calculateXSpeed(this.p1, this.ball.x), this.ball.ySpeed = this.calculateYSpeed(this.p1, this.ball.y), this.sfx.play("paddleHit")), this.ball.circle.right > this.p2.rectangle.left && this.ball.circle.top < this.p2.rectangle.bottom && this.ball.circle.bottom > this.p2.rectangle.top && (this.ball.x = this.p2.rectangle.left - this.ball.circle.radius, this.ball.y = this.ball.prevY, this.ball.xSpeed = -c.Ball.MAX_X_SPEED * this.calculateXSpeed(this.p2, this.ball.x), this.ball.ySpeed = this.calculateYSpeed(this.p2, this.ball.y), this.sfx.play("paddleHit")))
		};
		b.prototype.calculateXSpeed = function(a, b) {
			var c = -(b - a.rectangle.centerX) / (0.5 * a.rectangle.width);
			return 0 > c ? -1 : 1
		};
		b.prototype.calculateYSpeed = function(a, b) {
			return c.Ball.MAX_Y_SPEED * (b - a.rectangle.centerY) / (0.5 * a.rectangle.height)
		};
		b.prototype.checkWin = function() {
			this.ball.x < 0.5 * this.game.width ? (this.hud.setP2Score(++this.p2Score), this.ballDirection = -1) : this.ball.x > 0.5 * this.game.width && (this.hud.setP1Score(++this.p1Score), this.ballDirection = 1);
			(10 <= this.p1Score || 10 <= this.p2Score) && this.endGame()
		};
		b.prototype.endGame = function() {
			var a = this.getWinner();
			console.log(a.paddleType);
			var b = 1E3 * (this.p1Score - this.p2Score),
				b = 0 > b ? -b : b;
			a == this.human ? (this.sfx.play("winnerFX"), this.game.state.start("SScoreScreen", !0, !1, {
				status: !0,
				score: b,
				passedTime: this.passedTime
			})) : (this.sfx.play("loserFX"), this.game.state.start("SScoreScreen", !0, !1, {
				status: !1,
				score: 0,
				passedTime: this.passedTime
			}))
		};
		b.prototype.getWinner = function() {
			console.log(this.p1Score, " - ", this.p2Score);
			return this.p1Score > this.p2Score ? this.p1 : this.p2
		};
		b.prototype.reset = function() {
			this.ball.x = 400;
			this.ball.y = 300;
			this.ball.xSpeed = 8 * this.ballDirection;
			this.ball.ySpeed = 10 * Math.random() - 5;
			this.fBallUpdate = this.fBallCollision = !0;
			this.ball.isOut = !1
		};
		b.prototype.startTime = function() {
			this.timer && clearInterval(this.timer);
			this.timer = setInterval(this.timerTick.bind(this), 1E3)
		};
		b.prototype.timerTick = function() {
			this.isOnPause ? this.hud.updateTime(!1) : this.hud.updateTime(++this.passedTime)
		};
		b.prototype.shutdown = function() {
			this.timer && clearInterval(this.timer);
			this.game.input.keyboard.removeKey(Phaser.Keyboard.P);
			this.game.input.keyboard.removeKey(Phaser.Keyboard.D)
		};
		b.prototype.render = function() {
			this.fDebug && (this.game.debug.geom(this.zoneRect, "rgba(0,0,255,.6)"), this.game.debug.geom(this.ball.circle, "rgba(255,165,0,.8"), this.game.debug.geom(this.p1.rectangle, "rgba(0, 255, 0, 0.8)"), this.game.debug.geom(this.p2.rectangle, "rgba(255, 0, 0, 0.8"))
		};
		return b
	}(Phaser.State);
	c.SPlayGame = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b() {
			c.apply(this, arguments)
		}
		__extends(b, c);
		b.prototype.create = function() {
			var a = this.game;
			this.background = a.add.group();
			this.background.create(0, 0, "commonBg");
			this.background.create(80, 150, "instructionsBgFX");
			this.backToMainBtn = a.add.button(270, 530, "backToMainBtn", this.backToMain, this);
			this.backToMainBtn.input.useHandCursor = !0
		};
		b.prototype.backToMain = function() {
			this.game.state.start("SMainMenu", !0, !1)
		};
		return b
	}(Phaser.State);
	c.SInstructions = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b() {
			c.apply(this, arguments)
		}
		__extends(b, c);
		b.prototype.create = function() {
			var a = this.game;
			console.log("Showing High Scores");
			this.background = a.add.group();
			this.background.create(0, 0, "commonBg");
			this.background.create(200, 160, "scoresBgFX");
			this.getScores();
			this.backToMainBtn = a.add.button(270, 530, "backToMainBtn", this.backToMain, this);
			this.backToMainBtn.input.useHandCursor = !0
		};
		b.prototype.getScores = function() {
			console.log("Scores are being loaded");
			var a = null,
				b = this,
				a = new XMLHttpRequest;
			a.onreadystatechange = function() {
				if (4 == a.readyState && 200 == a.status) {
					console.log(a.response);
					var c = JSON.parse(a.response);
					b.scores = [];
					for (var d in c) console.log(d), b.scores.push(c[d]);
					b.updateScores()
				}
			};
			a.open("GET", "/triggers/pong/get_scores.php", !0);
			a.responseType = "json";
			a.send()
		};
		b.prototype.updateScores = function() {
			this.list && this.list.destroy();
			this.list = this.game.add.group();
			for (var a, b, c = this.game, d = {
					font: "24px Computerfont",
					fill: "#e3e3e3"
				}, g, e, f = 0; f < this.scores.length; f++) e = c.add.group(), g = this.scores[f], a = 0 == f ? "1st" : 1 == f ? "2nd" : 2 == f ? "3rd" : (f + 1).toString() + "th", b = 200 + 29 * f, a = c.add.text(40, 0, a, d), a.anchor.setTo(1, 0), e.add(a), a = c.add.text(125, 0, g.name, d), a.anchor.setTo(0.5, 0), e.add(a), a = c.add.text(260, 0, g.score, d), a.anchor.setTo(1, 0), e.add(a), a = c.add.text(360, 0, this.convertTime(g.time), d), a.anchor.setTo(1, 0), e.add(a), e.x = 200, e.alpha = 0, e.y = b, c.add.tween(e).to({
				x: 220,
				alpha: 1
			}, 300, Phaser.Easing.Cubic.In, !0, 50 * f)
		};
		b.prototype.convertTime = function(a) {
			var b = Math.floor(a / 60).toString(),
				b = 1 == String(b).length ? "0" + b : b;
			a = (a - 60 * Math.floor(a / 60)).toString();
			a = 1 == String(a).length ? "0" + a : a;
			return b + ":" + a
		};
		b.prototype.backToMain = function() {
			this.game.state.start("SMainMenu", !0, !1)
		};
		return b
	}(Phaser.State);
	c.SHighScores = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b() {
			c.apply(this, arguments)
		}
		__extends(b, c);
		b.prototype.create = function() {
			var a = this.game;
			console.log("Choosing Player");
			this.background = a.add.group();
			this.background.create(0, 0, "newGameBg");
			this.p1 = a.add.button(100, 210, "chosePlayerSS", this.onPlayerChoose, this, 0, 0, 0, 0);
			this.p2 = a.add.button(550, 210, "chosePlayerSS", this.onPlayerChoose, this, 1, 1, 1, 1);
			this.p1.input.useHandCursor = this.p2.input.useHandCursor = !0
		};
		b.prototype.onPlayerChoose = function(a) {
			a == this.p1 ? console.log("Playing as Player ONE") : console.log("Playing as Player TWO");
			this.game.add.tween(a).to({
				x: 323
			}, 500, Phaser.Easing.Cubic.InOut, !0);
			this.game.add.tween(a == this.p1 ? this.p2 : this.p1).to({
				y: 600,
				alpha: 0
			}, 600, Phaser.Easing.Cubic.Out, !0).onComplete.add(this.startGame, this)
		};
		b.prototype.startGame = function(a) {
			this.game.state.start("SPlayGame", !0, !1, a == this.p1 ? "right" : "left")
		};
		return b
	}(Phaser.State);
	c.SChoosePlayer = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(c) {
		function b() {
			c.apply(this, arguments);
			this.winner = !1;
			this.passedTime = this.score = 0
		}
		__extends(b, c);
		b.prototype.init = function(a) {
			null == a ? (this.winner = !1, this.score = this.passedTime = 0) : (this.winner = a.status ? a.status : !1, this.score = a.score ? a.score : 0, this.passedTime = a.passedTime ? a.passedTime : 0)
		};
		b.prototype.create = function() {
			var a = this.game;
			this.background = a.add.group();
			this.background.create(0, 0, "commonBg");
			this.background.create(245, 342, "scoreFX");
			this.backToMainBtn = a.add.button(270, 530, "backToMainBtn", this.backToMain, this);
			this.backToMainBtn.input.useHandCursor = !0;
			this.winner ? (this.retryBtn = a.add.button(260, 300, "retryBtn", this.retryGame, this), this.retryBtn.input.useHandCursor = !0, this.submitBtn = a.add.button(415, 300, "submitBtn", this.submitScore, this), this.submitBtn.input.useHandCursor = !0) : (this.retryBtn = a.add.button(345, 300, "retryBtn", this.retryGame, this), this.retryBtn.input.useHandCursor = !0);
			var b = {
				font: "48px Computerfont",
				fill: "#dfdfdf",
				align: "center"
			};
			this.message = this.winner ? a.add.text(400, 215, "Congratulations, you won!", b) : a.add.text(400, 215, "Better luck next time!", b);
			this.message.anchor.setTo(0.5, 0.5);
			b.font = "30px Computerfont";
			b.align = "right";
			this.scoreField = a.add.text(485, 360, this.score.toString(), b);
			this.timeField = a.add.text(485, 402, this.convertTime(this.passedTime), b);
			this.scoreField.anchor.setTo(1, 0);
			this.timeField.anchor.setTo(1, 0)
		};
		b.prototype.convertTime = function(a) {
			var b = Math.floor(a / 60).toString(),
				b = 1 == String(b).length ? "0" + b : b;
			a = (a - 60 * Math.floor(a / 60)).toString();
			a = 1 == String(a).length ? "0" + a : a;
			return b + ":" + a
		};
		b.prototype.backToMain = function() {
			this.game.state.start("SMainMenu", !0, !1)
		};
		b.prototype.retryGame = function() {
			this.game.state.start("SChoosePlayer", !0, !1)
		};
		b.prototype.submitScore = function() {
			this.game.submitWidget.setScore(this.score, this.passedTime);
			this.game.submitWidget.show()
		};
		return b
	}(Phaser.State);
	c.SScoreScreen = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function() {
		function c(b) {
			this.data = {
				score: 0,
				time: 0,
				name: ""
			};
			this.contentString = "<div id='scoreSubmit' style='font-family: Computerfont;'><h2 class='scoreSubmitText' style='font-size: 30px; margin: 0px;'>   <span>Score:</span> <span id='scoreValue'>00000</span></h2><h4 class='scoreSubmitText' style='font-size: 20px; margin: 0px;'><span>Time taken:</span> <span id='timeValue'>00:00</span></h4><label id='nameLabel' class='scoreSubmitText' for='playerName'>Your name:</label>   <input id='playerName' class='scoreSubmitText' type='text' name='playerName' size='5' value=''><hr><input id='submitButton' class='scoreSubmitText' type='submit' name='Submit score' value='Submit Score'></div>";
			this.game = b;
			b = document.getElementById(b.parent);
			this.overlayer = document.createElement("div");
			this.overlayer.innerHTML = this.contentString;
			this.overlayer.id = "scoreOverlayer";
			this.form = this.overlayer.firstElementChild;
			var a = this.form.lastElementChild;
			a.onclick = this.submitScore.bind(this);
			this.valueF = a.previousSibling.previousSibling;
			b.appendChild(this.overlayer)
		}
		c.prototype.setScore = function(b, a) {
			var c = Math.floor(a / 60).toString(),
				c = 1 == String(c).length ? "0" + c : c,
				d = (a - 60 * Math.floor(a / 60)).toString(),
				d = 1 == String(d).length ? "0" + d : d;
			this.data = {
				score: b,
				time: a,
				name: ""
			};
			document.getElementById("scoreValue").innerText = b;
			document.getElementById("timeValue").innerText = c + ":" + d
		};
		c.prototype.submitScore = function() {
			console.log("Submiting score");
			var b = this,
				a = this.valueF.value;
			if (null == a.match(/^[a-zA-Z0-9]{3,5}$/)) alert("Name can contain letters (A-Z) and numbers (0-9) only and must have a length of 3 to 5 characters.");
			else {
				this.data.name = a;
				var c = new XMLHttpRequest;
				c.onreadystatechange = function() {
					4 == c.readyState && 200 == c.status && (b.game.state.start("SMainMenu"), b.hide(), console.log(c.response))
				};
				c.open("POST", "/triggers/pong/submit_score.php", !0);
				c.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				c.send("name=" + this.data.name + "&score=" + this.data.score + "&time=" + this.data.time)
			}
		};
		c.prototype.show = function() {
			this.overlayer.style.display = "block"
		};
		c.prototype.hide = function() {
			this.overlayer.style.display = "none"
		};
		return c
	}();
	c.ScoreSubmitWidget = d
})(ram64 || (ram64 = {}));
(function(c) {
	var d = function(d) {
		function b(a) {
			d.call(this, 800, 600, Phaser.CANVAS, a, null, !1, !0);
			this.state.add("SBoot", c.SBoot, !1);
			this.state.add("SPreload", c.SPreload, !1);
			this.state.add("SMainMenu", c.SMainMenu, !1);
			this.state.add("SPlayGame", c.SPlayGame, !1);
			this.state.add("SChoosePlayer", c.SChoosePlayer, !1);
			this.state.add("SInstructions", c.SInstructions, !1);
			this.state.add("SHighScores", c.SHighScores, !1);
			this.state.add("SScoreScreen", c.SScoreScreen, !1);
			this.state.start("SBoot");
			this.submitWidget = new c.ScoreSubmitWidget(this);
			this.submitWidget.hide()
		}
		__extends(b, d);
		return b
	}(Phaser.Game);
	c.GameBase = d
})(ram64 || (ram64 = {}));