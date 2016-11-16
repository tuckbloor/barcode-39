<?php

class Bc39 {

    private $code39;
    private $code;
    private $width;
    private $height;

    public function __construct($code, $width, $height)
    {
        $this->code    = $code;
        $this->width   = $width;
        $this->height  = $height;
        $this->padding = 20;

        $this->code39 = array(

            '0' => '0101110001000101', '1' => '0001011101010001', '2' => '0100011101010001', '3' => '0001000111010101',
            '4' => '0101110001010001', '5' => '0001011100010101', '6' => '0100011100010101', '7' => '0101110100010001',
            '8' => '0001011101000101', '9' => '0100011101000101', 'A' => '0001010111010001', 'B' => '0100010111010001',
            'C' => '0001000101110101', 'D' => '0101000111010001', 'E' => '0001010001110101', 'F' => '0100010001110101',
            'G' => '0101011100010001', 'H' => '0001010111000101', 'I' => '0100010111000101', 'J' => '0101000111000101',
            'K' => '0001010101110001', 'L' => '0100010101110001', 'M' => '0001000101011101', 'N' => '0101000101110001',
            'O' => '0001010001011101', 'P' => '0100010001011101', 'Q' => '0101010001110001', 'R' => '0001010100011101',
            'S' => '0100010100011101', 'T' => '0101000100011101', 'U' => '0001110101010001', 'V' => '0111000101010001',
            'W' => '0001110001010101', 'X' => '0111010001010001', 'Y' => '0001110100010101', 'Z' => '0111000100010101',
            '-' => '0111010100010001', '.' => '0001110101000101', ' ' => '0111000101000101', '*' => '0111010001000101',
            '$' => '0111011101110101', '/' => '0111011101011101', '+' => '0111010111011101', '%' => '0101110111011101');

        $this->generate();

    }

    public  function generate() {

        $this->code = strtoupper($this->code);
        $length = strlen($this->code);

        $barcode = imagecreate(($length * 16 * $this->width) + $this->padding * 2, $this->height + $this->padding * 2);

        $background = imagecolorallocate($barcode, 255, 255, 255);
        imagecolortransparent($barcode, $background);
        $black = imagecolorallocate($barcode, 0, 0, 0);
        $chars = str_split($this->code);

        $colors = '';

        foreach ($chars as $char) {
            $colors .= $this->code39[$char];
        }

        $bar_position = $this->padding;

        foreach (str_split($colors) as $i => $color) {

            if ($color == '0') {
                imagefilledrectangle($barcode, $this->width + $bar_position, $this->padding, $this->width +
                                     $bar_position, $this->height + $this->padding - 10, $black);
            }


            $bar_position = $bar_position + $this->width ;
        }


        $centre = ($length * 8 * $this->width) - ($length * 3) + $this->padding;

        imagestring($barcode, 2, $centre, $this->height+20, $this->code, $black);

        header('Content-type: image/png');
        imagepng($barcode);
        imagedestroy($barcode);
    }
}