<?php
namespace QRGenerator;
require_once '../vendor/autoload.php';
require_once '../vendor/phpqrcode/qrlib.php';

use QRcode;
use const QR_ECLEVEL_L;

class QRGenerator {
    private static $qrCodePath = '../tempdump/'; // Path to save QR codes
    private static $fontPath = '../fonts/Roboto-Bold.ttf'; // Path to the font file
    private static $WIDTH_PIXELS = 280; // Width of the QR code image
    private static $HEIGHT_PIXELS = 150; // Height of the QR code image

    /**
     * Generates a QR code image with text and additional information.
     * The QR Code contains the filename without the extension
     * 
     * @param string $filename Name of the file to be generated (e.g. '123_SKU456_LOT789_ROLL1.png')
     * @param string $text Text to be displayed below the QR code (e.g. 'SKU456_ProductName')
     * @param string[] $lines Array of lines to be printed on the right side of QR code
     * @param string|null $content Optional content for the QR code (if not provided, filename without extension is used)
     * @return string Path to the generated QR code image
     */

    public static function generateQR($filename, $text, $lines, $content = null) {
        $finalImage = imagecreatetruecolor(self::$WIDTH_PIXELS, self::$HEIGHT_PIXELS);
        $white = imagecolorallocate($finalImage, 255, 255, 255);
        imagefill($finalImage, 0, 0, $white);

        $qrSize = min(self::$WIDTH_PIXELS, self::$HEIGHT_PIXELS) / 2;
        $qrCode = self::$qrCodePath . $filename;
        $qrcontent = $content ?? pathinfo($filename, PATHINFO_FILENAME);
        QRcode::png($qrcontent, $qrCode, QR_ECLEVEL_L, $qrSize / 25);

        $qrImage = imagecreatefrompng($qrCode);
        $padding = 20;
        $qrX = $padding;
        $qrY = (self::$HEIGHT_PIXELS - imagesy($qrImage)) - $padding;

        imagecopy($finalImage, $qrImage, $qrX, $qrY, 0, 0, imagesx($qrImage), imagesy($qrImage));
        $fontSize = 10;
        $fontColor = imagecolorallocate($finalImage, 0, 0, 0);
        
        $bbox = imagettfbbox($fontSize, 0, self::$fontPath, $text);
        $textX = 25;
        $textY = $qrY + imagesy($qrImage) + 10;
        $qrX = $padding;
        $qrY = (self::$HEIGHT_PIXELS - imagesy($qrImage)) - $padding;

        imagecopy($finalImage, $qrImage, $qrX, $qrY, 0, 0, imagesx($qrImage), imagesy($qrImage));
        $fontSize = 10;
        $fontColor = imagecolorallocate($finalImage, 0, 0, 0);
        
        $bbox = imagettfbbox($fontSize, 0, self::$fontPath, $text);
        $textWidth = $bbox[2] - $bbox[0];
        $textX = 25;
        $textY = $qrY + imagesy($qrImage) + 10;
        imagettftext($finalImage, $fontSize, 0, $textX, $textY, $fontColor, self::$fontPath, $text);
        $rightPadding = 10;
        $textXRight = imagesx($qrImage) + $qrX + $rightPadding;

        $lineHeight = 25;
        $textYStart = $qrY + 25;
        
        $fontSize = 11;
        foreach ($lines as $index => $line) {
            $textY = $textYStart + ($lineHeight * $index);
            imagettftext($finalImage, $fontSize, 0, $textXRight, $textY, $fontColor, self::$fontPath, $line);
        }
        
        $filepath = self::$qrCodePath . $filename;
        imagepng($finalImage, $filepath);
        imagedestroy($finalImage);
        imagedestroy($qrImage);

        return $filepath;

}
    /**
     * Set custom dimensions for the QR code image
     * 
     * @param int $width Width in pixels (default is 280)
     * @param int $height Height in pixels (default is 150)
     */
    public static function setDimensions($width = 280, $height = 150) {
        self::$WIDTH_PIXELS = $width;
        self::$HEIGHT_PIXELS = $height;
    }
    /**
     * Set custom font path for the text in the QR code image
     * 
     * @param string $path Path to the font file(e.g. '../fonts/Roboto-Bold.ttf')
     */
    public static function setFontPath($path = '../fonts/Roboto-Bold.ttf') {
        self::$fontPath = $path;
    }
    
    /**
     * Set custom QR code path for saving images
     * 
     * @param string $path Path to the directory for QR code images (e.g. '../tempdump/')
     */
    public static function setQrCodePath($path = '../tempdump/') {
        self::$qrCodePath = $path;
    }

}

?>
