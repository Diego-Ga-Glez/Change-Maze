/**
 * Author: Michael Hadley, mikewesthad.com
 * Asset Credits:
 *  - Tileset, Michele "Buch" Bucelli (tileset artist) & Abram Connelly (tileset sponsor):
 *     https://opengameart.org/content/top-down-dungeon-tileset
 *  - Character, Michele "Buch" Bucelli:
 *      https://opengameart.org/content/a-platformer-in-the-forest
 */

import DungeonScene from "./dungeon-scene.js";

const config = {
  type: Phaser.AUTO,
  scale: {
    mode: Phaser.Scale.FIT,
    parent: 'game-container',
    autoCenter: Phaser.Scale.CENTER_BOTH,
    width: "100%",
    height: "100%"
  },
  backgroundColor: "#000",
  pixelArt: true,
  scene: DungeonScene,
  physics: {
    default: "arcade",
    arcade: {
      gravity: { y: 0 },
      debug: true
    },
  },
};

const game = new Phaser.Game(config);
