<?php
namespace Images;
/**
 * @Class Tools 图像处理类
 * @author Alex-黑白
 * @Create Date 2018-09-11
 */
class Images{
    private $imageWidth;//图像宽度
    private $imageHeight;//图像高度
    private $imageMime;//图像类型
    public $imageHandle;//图片句柄

    public function __construct($sourcePath)
    {
        if(gd_info()){
            $imageInfo = getimagesize($sourcePath);
            $this -> imageWidth = $imageInfo[0];
            $this -> imageHeight = $imageInfo[1];
            $this -> imageMime = $imageInfo['mime'];
            $this -> imageHandle = $sourcePath;
        }else{
            die("please open the GD extend");
        }
        
    }

    /**
     * @Function 获取图像文件后缀
     */
    public function getImageExt(){
        //[1=>'gif',2=>'jpeg',3=>'png',4=>'swf',5=>'psd',6=>'bmp',7=>'tiff']
        switch($this -> imageMime){
            case 'image/jpeg':
                return image_type_to_extension(2);
            case 'image/png':
                return image_type_to_extension(3);
            case 'image/gif':
                return image_type_to_extension(1);
        }
        
    }

    /**
     * @Function 向图片写入文字
     * @param $color 字体颜色
     */
    public function imageWriteWord($color='black',$fontSize=16,$angle=0){
        switch($color){
            case 'black':
                if(($this -> imageMime) == 'image/jpeg'){
                    $color = imagecolorallocatealpha(imagecreatefromjpeg($this -> imageHandle),0, 0, 0, 0);//黑色
                }elseif(($this -> imageMime) == 'image/png'){
                    $color = imagecolorallocatealpha(imagecreatefrompng($this -> imageHandle),0, 0, 0, 0);//黑色
                }
        }
        imagejpeg(imagecreatefromjpeg($this -> imageHandle));
        header('Content-Type:'.$this -> imageMime);
        imagettftext(imagecreatefromjpeg($this -> imageHandle),16,0,0,0,$color,'','test word');

    }
}