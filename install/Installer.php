<?php

class Installer {

    public $options;

    public function __construct( $arr=array() ){

        $this->options = $arr;

    }

    public function put( $key, $value ){

        $this->options[$key] = $value;

    }

    public function convertOptions(){

        $arr = $this->options;
        $data = "<?php\n\n";

        foreach( $arr as $key => $value ){

            $data .= "define( '" . $key . "', '" . $value . "' );";
            $data .= "\n\n";

        }

        return $data;

    }

    public function install( $filename, $dir='' ){

        if( file_put_contents( $dir . $filename, $this->convertOptions() ) ){

            return true;

        }

        return false;

    }

}