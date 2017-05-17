<?php
namespace App\Validators;

class FilesValidator {

    /**
     * Determine if the attribute is validatable.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function validDocument($attribute, $value, $parameters)
    {
        $validTypes = [
            'application/pdf',                  // .pdf
            'application/octet-stream',
            'application/zip',					// .zip
            'application/x-zip-compressed',     // .zip
            'application/x-rar-compressed',		// .rar
            'application/msword', 				// .doc
            'application/vnd.ms-excel', 		// .xls
            'application/vnd.ms-powerpoint', 	// .ppt
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',   // .docx
            'application/vnd.openxmlformats-officedocument.presentationml.presentation', // .pptx
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        return in_array($value->getClientMimeType(), $validTypes);
    }

    /**
     * Determine if the attribute is validatable.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function validAudio($attribute, $value, $parameters)
    {
        $validTypes = [
            'audio/mpeg',       // .mp3
            'audio/mpeg3',      // .mp3
            'audio/x-mpeg3',    // .mp3
            'audio/x-mpeg3',    // .mp3
            'audio/mp3',        // .mp3
        ];
        return in_array($value->getClientMimeType(), $validTypes);

    }

    /**
     * Determine if the attribute is validatable.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function validLink($attribute, $value, $parameters)
    {
        return ( !filter_var($value, FILTER_VALIDATE_URL) === false );
    }

    /**
     * Determine if the attribute is validatable.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function validImage($attribute, $value, $parameters)
    {
        $validTypes = [
            'image/jpeg',   // .jpeg, .jpg
            'image/png',    // .png
            'image/gif',    // .gif
            'image/tiff',   // .tiff
            'image/bmp',    // .bmp
        ];
        return in_array($value->getClientMimeType(), $validTypes);
    }

}


