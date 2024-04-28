<?php
namespace App\Lib\Traits;

trait CssAdd
{
    public function cssAdd($abs_path_to_css = PUBLICROOT.DS.'css'.DS.'first')
    {
        $x = explode('/', URLROOT);
        $x = array_pop($x);
        $np = explode($x, $abs_path_to_css);
        $np = str_replace('\\', '/', array_pop($np));

        $css_files = array();
        if (file_exists($abs_path_to_css) && is_dir($abs_path_to_css) && is_readable($abs_path_to_css)) {
            if (file_exists($abs_path_to_css.DS.'normalize.css')) {
                $css_files[0] = URLROOT.'/'.$np.'/normalize.css';
            }
            if (file_exists($abs_path_to_css.DS.'style.css')) {
                $css_files[1] = URLROOT.'/'.$np.'/style.css';
            }
            $f = scandir($abs_path_to_css);
            foreach ($f as $file){
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $name = pathinfo($file, PATHINFO_BASENAME);
                //if(preg_match('/\.(css)/', $file)){
                if ( $ext === 'css' && $name != "normalize.css" && $name != 'style.css' ) {
                    $css_files[] = URLROOT.'/'.$np.'/'.$name;
                }
            }
        }
        return $css_files;
    }
}
?>
