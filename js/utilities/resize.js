export default  class Resize{
    constructor(config){
        this.config = config
        this.cw= 0;
		this.ch= 0;
    }

    update_size(){
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

    static scaleToGameW(obj,per){
		if(window.innerWidth > window.innerHeight)
            obj.displayWidth= window.innerWidth *per;
        else
            obj.displayWidth= window.innerHeight *per;
		obj.scaleY= obj.scaleX;
	}
}