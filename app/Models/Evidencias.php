<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cevidencia
 * @property integer $cactividad
 * @property string $descripcion
 * @property string $nombre
 * @property string $path
 * @property string $fregistro
 * @property string $created_at
 * @property string $updated_at
 * @property Actividades $actividad
 */
class Evidencias extends Model
{
	protected $primaryKey = "cevidencia";
	/**
	 * @var array
	 */
	protected $fillable = ['cactividad', 'descripcion', 'nombre', 'path', 'fregistro', 'created_at', 'updated_at'];
	
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function actividad(){
		return $this->belongsTo('asies\Models\Actividades', 'cactividad', 'cactividad');
	}
	
	
	protected $appends = ["previewimg", ];
	public function getPreviewimgAttribute(){
		$ext_img = array("ani","bmp","cal","fax","gif","img","jbg","jpe","jpe","jpg","mac","pbm","pcd","pcx","pct","pgm","png","ppm","psd","ras","tga","tif","wmf");
		$evidencia = $this;
		$ext = pathinfo($evidencia->path, PATHINFO_EXTENSION);
		if ( in_array($ext, $ext_img) ){
			$previewimg = $evidencia->path;
		}else if ( in_array($ext, array("doc","docx")) ){
			$previewimg = "/img/evidencias/preview/word.png";
		}else if ( in_array($ext, array("pdf")) ){
			$previewimg = "/img/evidencias/preview/pdf.png";
		}else if ( in_array($ext, array("ppt","pptx","pps")) ){
			$previewimg = "/img/evidencias/preview/power-point.png";
		}else if ( in_array($ext, array("csv","xls","xlsx","xml")) ){
			$previewimg = "/img/evidencias/preview/excel.png";
		}else if ( in_array($ext, array("mp3","mpa","wam","aif")) ){
			$previewimg = "/img/evidencias/preview/audio.png";
		}else if ( in_array($ext, array("mkv","mp4","mpg","avi","3gp","wmv")) ){
			$previewimg = "/img/evidencias/preview/video.png";
		}else if ( in_array($ext, array("zip","rar","7z")) ){
			$previewimg = "/img/evidencias/preview/zip.png";
		}else{
			$previewimg = "/img/evidencias/preview/generic-file.png";
		}
		return $previewimg;

	}
}
