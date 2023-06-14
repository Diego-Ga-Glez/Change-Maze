import Player from "./player.js";
import TILES from "./tile-mapping.js";
import Alert from "./utilities/alert.js";
import TilemapVisibility from "./tilemap-visibility.js";
import WebFontFile from "./utilities/web-font-loader.js";
import Resize from "./utilities/resize.js";

/**
 * Scene that generates a new dungeon
 */
export default class DungeonScene extends Phaser.Scene {
  constructor() {
    super();
    this.level = 0;
    this.coins = 0;
    this.num_resp = 0;
    this.initialTimer = 0;
    this.gameplay = true;
  }

  preload() {
    //Virtual Joystick
    let url = 'https://raw.githubusercontent.com/rexrainbow/phaser3-rex-notes/master/dist/rexvirtualjoystickplugin.min.js';
    this.load.plugin('rexvirtualjoystickplugin', url, true);
    
    this.load.addFile(new WebFontFile(this.load, 'Press Start 2P'));
    this.load.image("tiles", "./js/assets/tilesets/buch-tileset-48px-extruded-blue.png");
    this.load.image("coin", "./js/assets/menu/coin.png");
    this.load.image("clock", "./js/assets/menu/clock.png");
    this.load.image("button", "./js/assets/menu/button.png");
    this.load.spritesheet(
      "characters",
      "./js/assets/spritesheets/buch-characters-64px-extruded.png",
      {
        frameWidth: 64,
        frameHeight: 64,
        margin: 1,
        spacing: 2,
      }
    );
  }

  create() {
    this.alert = new Alert();
    if (this.gameplay){
      this.gameplay = false;
      this.scene.pause();
      this.alert.gameplay(this.scene);
    }

    this.initialTimer = 120;
    this.level++;
    this.hasPlayerReachedStairs = false;

    // Generate a random world with a few extra options:
    //  - Rooms should only have odd number dimensions so that they have a center tile.
    //  - Doors should be at least 2 tiles away from corners, so that we can place a corner tile on
    //    either side of the door location
    this.dungeon = new Dungeon({
      width: 50,
      height: 50,
      doorPadding: 2,
      rooms: {
        width: { min: 7, max: 15, onlyOdd: true },
        height: { min: 7, max: 15, onlyOdd: true },
      },
    });

    //this.dungeon.drawToConsole();

    // Creating a blank tilemap with dimensions matching the dungeon
    const map = this.make.tilemap({
      tileWidth: 48,
      tileHeight: 48,
      width: this.dungeon.width,
      height: this.dungeon.height,
    });
    const tileset = map.addTilesetImage("tiles", null, 48, 48, 1, 2); // 1px margin, 2px spacing
    this.groundLayer = map.createBlankLayer("Ground", tileset).fill(TILES.BLANK);
    this.stuffLayer = map.createBlankLayer("Stuff", tileset);
    const shadowLayer = map.createBlankLayer("Shadow", tileset).fill(TILES.BLANK);

    this.tilemapVisibility = new TilemapVisibility(shadowLayer);

    // Use the array of rooms generated to place tiles in the map
    // Note: using an arrow function here so that "this" still refers to our scene
    this.dungeon.rooms.forEach((room) => {
      const { x, y, width, height, left, right, top, bottom } = room;

      // Fill the floor with mostly clean tiles
      this.groundLayer.weightedRandomize(TILES.FLOOR, x + 1, y + 1, width - 2, height - 2);

      // Place the room corners tiles
      this.groundLayer.putTileAt(TILES.WALL.TOP_LEFT, left, top);
      this.groundLayer.putTileAt(TILES.WALL.TOP_RIGHT, right, top);
      this.groundLayer.putTileAt(TILES.WALL.BOTTOM_RIGHT, right, bottom);
      this.groundLayer.putTileAt(TILES.WALL.BOTTOM_LEFT, left, bottom);

      // Fill the walls with mostly clean tiles
      this.groundLayer.weightedRandomize(TILES.WALL.TOP, left + 1, top, width - 2, 1);
      this.groundLayer.weightedRandomize(TILES.WALL.BOTTOM, left + 1, bottom, width - 2, 1);
      this.groundLayer.weightedRandomize(TILES.WALL.LEFT, left, top + 1, 1, height - 2);
      this.groundLayer.weightedRandomize(TILES.WALL.RIGHT, right, top + 1, 1, height - 2);

      // Dungeons have rooms that are connected with doors. Each door has an x & y relative to the
      // room's location. Each direction has a different door to tile mapping.
      const doors = room.getDoorLocations(); // → Returns an array of {x, y} objects
      for (let i = 0; i < doors.length; i++) {
        if (doors[i].y === 0) {
          this.groundLayer.putTilesAt(TILES.DOOR.TOP, x + doors[i].x - 1, y + doors[i].y);
        } else if (doors[i].y === room.height - 1) {
          this.groundLayer.putTilesAt(TILES.DOOR.BOTTOM, x + doors[i].x - 1, y + doors[i].y);
        } else if (doors[i].x === 0) {
          this.groundLayer.putTilesAt(TILES.DOOR.LEFT, x + doors[i].x, y + doors[i].y - 1);
        } else if (doors[i].x === room.width - 1) {
          this.groundLayer.putTilesAt(TILES.DOOR.RIGHT, x + doors[i].x, y + doors[i].y - 1);
        }
      }
    });

    // Separate out the rooms into:
    //  - The starting room (index = 0)
    //  - A random room to be designated as the end room (with stairs and nothing else)
    //  - An array of 90% of the remaining rooms, for placing random stuff (leaving 10% empty)
    const rooms = this.dungeon.rooms.slice();
    const startRoom = rooms.shift();
    const endRoom = Phaser.Utils.Array.RemoveRandomElement(rooms);
    const otherRooms = Phaser.Utils.Array.Shuffle(rooms).slice(0, rooms.length * 0.9);

    // Place the stairs
    this.stuffLayer.putTileAt(TILES.STAIRS, endRoom.centerX, endRoom.centerY);

    // Probability for stuff in the 90% "othersRooms"
    let prob_coin, prob_pot, prob_trap;
    const randi =  Math.floor(Math.random() * 3)
    if(randi == 0){
      // unlucky
      prob_coin = 0.12; // 12% chance of coin
      prob_pot = 0.50;  // 38% chance of a pot 
      prob_trap = 0.98; // 02% chance of trap and 48% chance of towers
    } else if(randi == 1){
      // normal 
      prob_coin = 0.25; // 25% chance of coin
      prob_pot = 0.50;  // 25% chance of a pot
      prob_trap = 0.90 //  10% chance of trap and 40% chance of towers
    } else{
      // lucky
      prob_coin = 0.50; // 50% chance of coin
      prob_pot = 0.75;  // 25% chance of a pot
      prob_trap = 0.90; // 10% chance of a trap and 15% chanfe of towers
    }
    
    // Place stuff in the 90% "otherRooms"
    otherRooms.forEach((room) => {
      const rand = Math.random();
      if (rand <= prob_coin) {
        this.stuffLayer.putTileAt(TILES.COIN, room.centerX, room.centerY);
      } else if (rand <= prob_pot) {
        //chance of a pot anywhere in the room... except don't block a door!
        const x = Phaser.Math.Between(room.left + 2, room.right - 2);
        const y = Phaser.Math.Between(room.top + 2, room.bottom - 2);
        this.stuffLayer.weightedRandomize(TILES.POT,x, y, 1, 1);
      } else if (rand >= prob_trap){
        this.stuffLayer.putTileAt(TILES.PORTAL, room.centerX, room.centerY);
      } else {
        if (room.height >= 9) {
          this.stuffLayer.putTilesAt(TILES.TOWER, room.centerX - 1, room.centerY + 1);
          this.stuffLayer.putTilesAt(TILES.TOWER, room.centerX + 1, room.centerY + 1);
          this.stuffLayer.putTilesAt(TILES.TOWER, room.centerX - 1, room.centerY - 2);
          this.stuffLayer.putTilesAt(TILES.TOWER, room.centerX + 1, room.centerY - 2);
        } else {
          this.stuffLayer.putTilesAt(TILES.TOWER, room.centerX - 1, room.centerY - 1);
          this.stuffLayer.putTilesAt(TILES.TOWER, room.centerX + 1, room.centerY - 1);
        }
      }
    });

    // Not exactly correct for the tileset since there are more possible floor tiles, but this will
    // do for the example.
    this.groundLayer.setCollisionByExclusion([-1, 6, 7, 8, 26]);
    this.stuffLayer.setCollisionByExclusion([-1, 6, 7, 8, 26]);

    this.stuffLayer.setTileIndexCallback(TILES.STAIRS, () => {
      this.stuffLayer.setTileIndexCallback(TILES.STAIRS, null);
      this.game_over()
    });

    this.stuffLayer.setTileIndexCallback(TILES.PORTAL, async () => {
      
      const playerTileX = this.groundLayer.worldToTileX(this.player.sprite.x);
      const playerTileY = this.groundLayer.worldToTileY(this.player.sprite.y);
      const playerRoom = this.dungeon.getRoomAt(playerTileX, playerTileY)
      this.stuffLayer.removeTileAt(playerRoom.centerX,playerRoom.centerY)

      this.scene.pause()
      const score = await this.alert.score_section();
      const change = await this.alert.change_section(this.scene);
      var datos = new FormData();
      datos.append("num_resp", this.num_resp);
      datos.append("score", score);
      datos.append("change", change);

      $.ajax({
        url:"./ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(ans){
        }
      });

      this.num_resp++;
      if (change == 'si') {
        const rand = Math.floor(Math.random() * 10)
        this.level = rand;
        this.stuffLayer.setTileIndexCallback(TILES.PORTAL, null);
        this.game_over()
      }
    });

    this.stuffLayer.setCollision(TILES.COIN, false)
    this.stuffLayer.setTileIndexCallback(TILES.COIN, () => {
      const coinX = this.groundLayer.worldToTileX(this.player.sprite.x);
      const coinY = this.groundLayer.worldToTileY(this.player.sprite.y);
      if(this.stuffLayer.hasTileAt(coinX,coinY)){
        this.stuffLayer.removeTileAt(coinX,coinY)
        this.coins++
        this.score()
      }
    });

    // Place the player in the first room
    const playerRoom = startRoom;
    const x = map.tileToWorldX(playerRoom.centerX);
    const y = map.tileToWorldY(playerRoom.centerY);
    
    //Virtual Joystick
    let control = 'keyboard';
    this.joyStick = this.plugins.get('rexvirtualjoystickplugin').add(this, {
      radius: 100,
      base: this.add.circle(0, 0, 50, 0x888888),
      thumb: this.add.circle(0, 0, 25, 0xcccccc),
    });

    if (!this.sys.game.device.input.gamepads || this.sys.game.device.input.touch)
      control = 'joyStick' 
    else
      this.joyStick.visible = false;  

    this.player = new Player(this, x, y, control);

    // Watch the player and tilemap layers for collisions, for the duration of the scene:
    this.physics.add.collider(this.player.sprite, this.groundLayer);
    this.physics.add.collider(this.player.sprite, this.stuffLayer);

    // Phaser supports multiple cameras, but you can access the default camera like this:
    const camera = this.cameras.main;

    // Constrain the camera so that it isn't allowed to move outside the width/height of tilemap
    camera.setBounds(0, 0, map.widthInPixels, map.heightInPixels);
    camera.startFollow(this.player.sprite);

    this.text_level = this.add.text(0,0, `Nivel: ${this.level}`, {
        fontFamily: '"Press Start 2P"',
			  fontSize: '18px',
        fill: "#ffffff",
      }).setOrigin(0.5).setScrollFactor(0);

    this.image_coin = this.add.image(0, 0,'coin').setOrigin(0.5).setScrollFactor(0);

    this.text_score = this.add.text(0, 0, this.coins, {
      fontFamily: '"Press Start 2P"',
			fontSize: '18px',
      fill: "#ffffff",
    }).setOrigin(0.5).setScrollFactor(0);

    this.score();

    this.image_clock = this.add.image(0,0, 'clock').setOrigin(0.5).setScrollFactor(0);
    
    //timer text
    this.text_timer = this.add.text(0, 0, this.formatTime(this.initialTimer),{
        fontFamily: '"Press Start 2P"',
			  fontSize: '18px',
        fill: "#ffffff",
    }).setOrigin(0.5).setScrollFactor(0);

    this.timerEvent = this.time.addEvent({ delay: 1000, callback: this.timer, callbackScope: this, loop: true });
    
    this.input.keyboard.on('keyup-A', () => this.enterButtonActiveState());

    // show gameplay and pause game
    this.input.keyboard.on('keyup-G', () => {
          this.scene.pause();
          this.alert.gameplay(this.scene);
      });
    /////////////////////////////////////////////  

    this.image_button = this.add.image(0, 0, 'button')
      .setOrigin(0.5)
      .setScrollFactor(0)
      .setInteractive({ useHandCursor: true })
      .on('pointerdown', () => this.enterButtonActiveState());

    this.resize();
    this.scale.on('resize', this.resize, this); 
  }
  
  update(time, delta) {
    if (this.hasPlayerReachedStairs && this.level < 10) return;
    this.player.update();

    // Find the player's room using another helper method from the dungeon that converts from
    // dungeon XY (in grid units) to the corresponding room object
    const playerTileX = this.groundLayer.worldToTileX(this.player.sprite.x);
    const playerTileY = this.groundLayer.worldToTileY(this.player.sprite.y);
    const playerRoom = this.dungeon.getRoomAt(playerTileX, playerTileY);

    this.tilemapVisibility.setActiveRoom(playerRoom);
  }

  resize(){ 
    if (!this.sys.game.device.input.gamepads || this.sys.game.device.input.touch) {
      var numRows = 47;
      var numCols = 19;
    }
    else {
      var numRows = 35;
      var numCols = 35;
    }
      
    this.rsize = new Resize({rows:numRows,cols:numCols});
    this.rsize.update_size();

    if (!this.sys.game.device.input.gamepads || this.sys.game.device.input.touch) {        
      this.rsize.placeAtIndex(788,this.joyStick);
      Resize.scaleToGameW(this.joyStick, .2);
      this.rsize.placeAtIndex(47,this.text_level);
      this.rsize.placeAtIndex(39,this.image_coin);
      this.rsize.placeAtIndex(40,this.text_score);
      this.rsize.placeAtIndex(52,this.image_clock);
      this.rsize.placeAtIndex(54,this.text_timer);
      this.rsize.placeAtIndex(111,this.image_button);
      this.rsize = null;
    }
    else {
      this.rsize.placeAtIndex(87,this.text_level);
      this.rsize.placeAtIndex(71,this.image_coin);
      this.rsize.placeAtIndex(72,this.text_score);
      this.rsize.placeAtIndex(100,this.image_clock);
      this.rsize.placeAtIndex(102,this.text_timer);
      this.rsize.placeAtIndex(207,this.image_button);
      this.rsize = null;
    }

    Resize.scaleToGameW(this.text_level, .1);
    Resize.scaleToGameW(this.image_coin, .04);
    Resize.scaleToGameW(this.text_score, .03);
    Resize.scaleToGameW(this.image_clock, .04);
    Resize.scaleToGameW(this.text_timer, .06);
    Resize.scaleToGameW(this.image_button, .06);
  }

  enterButtonActiveState() {
    if(this.coins > 0){
      this.initialTimer += 31
      this.coins--
      this.score()
    }
  }
  
  timer(){
    this.initialTimer -= 1; // One second
    if (this.initialTimer == 0){
      if (this.level == 1){
        this.level-=1
      }
      else{
        this.level-= 2
      }
      this.game_over()
    }
    this.text_timer.setText(this.formatTime(this.initialTimer));
  }

  formatTime(seconds){
    var minutes = Math.floor(seconds/60);
    var partInSeconds = seconds%60;
    partInSeconds = partInSeconds.toString().padStart(2,'0');
    return `${minutes}:${partInSeconds}`;
  }

  score(){
    if (this.coins > 9)
      this.text_score.setText(this.coins);
    else
      this.text_score.setText('0' + this.coins);
  }
  
  game_over(restart){
    this.hasPlayerReachedStairs = true;
    this.player.freeze();
    const cam = this.cameras.main;
    cam.fade(250, 0, 0, 0);
    cam.once("camerafadeoutcomplete", () => {

      if (this.level == 10) {
        this.alert.you_win();
        return;
      }
      this.player.destroy();
      this.scene.restart();
      
    });
  }
}