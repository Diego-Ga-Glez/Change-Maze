export default  class Resize{
    constructor(config){
        this.config = config
        this.cw= 0;
		this.ch= 0;
    }

    update_size(rows,cols){
		this.config.cols = cols;
		this.config.rows = rows;
		this.cw= window.innerWidth/this.config.cols;
		this.ch= window.innerHeight/this.config.rows;
    }

    placeAt(xx,yy,obj){
		//calc position based upon the cellwidth and cellheight
		var x2=this.cw*xx+this.cw/2;
		var y2=this.ch*yy+this.ch/2;
		obj.x=x2;
		obj.y=y2;
	}

	placeAtIndex(index,obj){
		var yy=Math.floor(index/this.config.cols);
		var xx=index-(yy*this.config.cols);
		this.placeAt(xx,yy,obj);
	}

    scaleToGameW(obj,per){
		if(window.innerWidth > window.innerHeight)
            obj.displayWidth= window.innerWidth *per;
        else
            obj.displayWidth= window.innerHeight *per;
		obj.scaleY= obj.scaleX;
	}

	placeAt_and_Scale(game){
		if(!game.sys.game.device.input.gamepads || game.sys.game.device.input.touch){
			this.update_size(45,19);
			this.placeAtIndex(750,game.joyStick);
			this.scaleToGameW(game.joyStick, .2);
			this.placeAtIndex(47,game.text_level);
			this.placeAtIndex(39,game.image_coin);
			this.placeAtIndex(40,game.text_score);
			this.placeAtIndex(53,game.image_clock);
			this.placeAtIndex(54.5,game.text_timer);
			//this.placeAtIndex(111.5,game.image_button);
			this.placeAtIndex(96.5,game.image_buttonTutorial);
		}else{
			this.update_size(35,35)
			this.placeAtIndex(87,game.text_level);
			this.placeAtIndex(71,game.image_coin);
			this.placeAtIndex(72,game.text_score);
			this.placeAtIndex(101,game.image_clock);
			this.placeAtIndex(102.5,game.text_timer);
			//this.placeAtIndex(207.5,game.image_button);
			this.placeAtIndex(176.5,game.image_buttonTutorial);	
		}

		this.scaleToGameW(game.text_level, .1);
		this.scaleToGameW(game.image_coin, .04);
		this.scaleToGameW(game.text_score, .025);
		this.scaleToGameW(game.image_clock, .04);
		this.scaleToGameW(game.text_timer, .05);
		//this.scaleToGameW(game.image_button, .06);
		this.scaleToGameW(game.image_buttonTutorial, .06);
	}
}