/**
 * @author alex-黑白
 * @QQ     392999164
 * createTime 2018-08-03
 */
;var alex = {

    /**
     * @Func Func 返回ctx实例
     */
    getCtx:function(){
        var c = document.getElementById("Wrap");
        return c.getContext("2d");
    },

    /**
     * @Func Func     创建空心矩形
     * @param xStart  横坐标起点
     * @param yStart  纵坐标起点
     * @param xWidth  矩形宽度
     * @param yHeight 矩形高度
     */
    createRect:function(xStart,yStart,xEnd,yEnd){
        var ctx = this.getCtx();
        ctx.rect(xStart,yStart,xEnd,yEnd);
        console.log('create');
        return ctx;       
    },

    /**
     * @Func Func     绘制填充的矩形
     * @param xStart  横坐标起点
     * @param yStart  纵坐标起点
     * @param xWidth  矩形宽度
     * @param yHeight 矩形高度
     */
    fillRect:function(xStart,yStart,xEnd,yEnd){
        var ctx = this.getCtx();
        ctx.fillRect(xStart,yStart,xEnd,yEnd);
        return ctx;
    },


    /**
     * @Func Func     绘制空心矩形
     * @param xStart  横坐标起点
     * @param yStart  纵坐标起点
     * @param xWidth  矩形宽度
     * @param yHeight 矩形高度
     */
    strokeRect:function(xStart,yStart,xEnd,yEnd,stroke){
        var ctx = this.getCtx();
        console.log('stroke');
        ctx.strokeRect(xStart,yStart,xEnd,yEnd);
        return ctx;       
    },

    /**
     * @init MainFunc 入口
     */
    init:function(){
        window.alex = this;
        var ctx = this.getCtx();
        ctx.fillStyle='#3e8831';
        var x = parseInt(100*Math.random(0,1));
        var y = parseInt(100*Math.random(0,1));
        var xd = true;
        var yd = true;

        setInterval(function(){
            if((x>=0 && x<=355)&&(y>=0 && y<=387)){
                
                if(x == 355){
                    xd = false;
                }else if(x == 0){
                    xd = true;
                }
                if(y == 387){
                    yd = false;
                }else if(y == 0){
                    yd = true;
                }
                
                if(xd == true && yd == true){
                    ctx.clearRect(x,y,20,160);
                    x++;
                    y++;
                    document.getElementById("area").innerHTML = 'x:'+x+'y:'+y;
                    ctx.fillRect(x,y,20,160);
                }else if(xd == false && yd == true){
                    ctx.clearRect(x,y,20,160);
                    x--;
                    y++;
                    document.getElementById("area").innerHTML = 'x:'+x+'y:'+y;
                    ctx.fillRect(x,y,20,160);
                }else if(xd == true && yd == false){
                    ctx.clearRect(x,y,20,160);
                    x++;
                    y--;
                    document.getElementById("area").innerHTML = 'x:'+x+'y:'+y;
                    ctx.fillRect(x,y,20,160);
                }else if(xd == false && yd == false){
                    ctx.clearRect(x,y,20,160);
                    x--;
                    y--;
                    document.getElementById("area").innerHTML = 'x:'+x+'y:'+y;
                    ctx.fillRect(x,y,20,160);
                }      
            }
        },16)
    }
}