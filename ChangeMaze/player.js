export default class Player {
  constructor(scene, x, y, control) {
    this.scene = scene;

    const anims = scene.anims;
    anims.create({
      key: "player-walk",
      frames: anims.generateFrameNumbers("characters", { start: 23, end: 26 }),
      frameRate: 8,
      repeat: -1,
    });
    anims.create({
      key: "player-walk-back",
      frames: anims.generateFrameNumbers("characters", { start: 42, end: 45 }),
      frameRate: 8,
      repeat: -1,
    });

    this.sprite = scene.physics.add.sprite(x, y, "characters", 0).setSize(15, 10).setOffset(25, 40);

    this.sprite.anims.play("player-walk-back");

    if(control == 'joyStick')
      this.keys= scene.joyStick.createCursorKeys();
    else
      this.keys = scene.input.keyboard.createCursorKeys();
  }

  freeze() {
    this.sprite.body.moves = false;
  }

  update() {
    const keys = this.keys;
    const sprite = this.sprite;
    const speed = 300;
    const prevVelocity = sprite.body.velocity.clone();

    // Stop any previous movement from the last frame
    sprite.body.setVelocity(0);

    // Horizontal movement
    if (keys.left.isDown) {
      sprite.body.setVelocityX(-speed);
      sprite.setFlipX(true);
    } else if (keys.right.isDown) {
      sprite.body.setVelocityX(speed);
      sprite.setFlipX(false);
    }

    // Vertical movement
    if (keys.up.isDown) {
      sprite.body.setVelocityY(-speed);
    } else if (keys.down.isDown) {
      sprite.body.setVelocityY(speed);
    }

    // Normalize and scale the velocity so that sprite can't move faster along a diagonal
    sprite.body.velocity.normalize().scale(speed);

    // Update the animation last and give left/right animations precedence over up/down animations
    if (keys.left.isDown || keys.right.isDown || keys.down.isDown) {
      sprite.anims.play("player-walk", true);
    } else if (keys.up.isDown) {
      sprite.anims.play("player-walk-back", true);
    } else {
      sprite.anims.stop();

      // If we were moving, pick and idle frame to use
      if (prevVelocity.y < 0) sprite.setTexture("characters", 42);
      else sprite.setTexture("characters", 23);
    }
  }

  destroy() {
    this.sprite.destroy();
  }
}