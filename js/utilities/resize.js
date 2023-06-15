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

	placeAt_and_Scale(objects, device){
		if(device == 'pc'){
			this.placeAtIndex(750,objects.joyStick);
			this.scaleToGameW(objects.joyStick, .2);
			this.placeAtIndex(47,objects.text_level);
			this.placeAtIndex(39,objects.image_coin);
			this.placeAtIndex(40,objects.text_score);
			this.placeAtIndex(53,objects.image_clock);
			this.placeAtIndex(54.5,objects.text_timer);
			this.placeAtIndex(111.5,objects.image_button);
			this.placeAtIndex(96.5,objects.image_buttonTutorial);
		}else{
			this.placeAtIndex(87,objects.text_level);
			this.placeAtIndex(71,objects.image_coin);
			this.placeAtIndex(72,objects.text_score);
			this.placeAtIndex(101,objects.image_clock);
			this.placeAtIndex(102.5,objects.text_timer);
			this.placeAtIndex(207.5,objects.image_button);
			this.placeAtIndex(176.5,objects.image_buttonTutorial);	
		}

		this.scaleToGameW(objects.text_level, .1);
		this.scaleToGameW(objects.image_coin, .04);
		this.scaleToGameW(objects.text_score, .025);
		this.scaleToGameW(objects.image_clock, .04);
		this.scaleToGameW(objects.text_timer, .05);
		this.scaleToGameW(objects.image_button, .06);
		this.scaleToGameW(objects.image_buttonTutorial, .06);
	}
}