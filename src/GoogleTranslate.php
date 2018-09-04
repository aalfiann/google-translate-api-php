<?php
namespace aalfiann;
/**
     * A class for access the Google Translate
     *
     * @package    GoogleTranslate Class
     * @author     M ABD AZIZ ALFIAN <github.com/aalfiann>
     * @copyright  Copyright (c) 2018 M ABD AZIZ ALFIAN
     * @license    https://github.com/aalfiann/google-translate-api-php/blob/master/LICENSE.md  MIT License
     */
class GoogleTranslate
{

    // model variable that use in class
    var $target,$text,$response,$source='',$resultArray=null;

    /**
     * Set source
     * @param $source = input with two chars of language code. Default is empty, means google will detect automatically.
     * @return this for chaining
     */
    public function setSource($source=''){
        $this->source = $source;
        return $this;
    }

    /**
     * Set target
     * @param $target = input with two chars of language code. Default is en.
     * @return this for chaining
     */
    public function setTarget($target='en'){
        $this->target = $target;
        return $this;
    }

    /**
     * Set text to translate
     * @param $text = input text to translate.
     * @return this for chaining
     */
    public function setText($text){
        $this->text = $text;
        return $this;
    }

    /**
     * Process translate
     * @return this for chaining
     */
    public function translate()
    {
        $this->response = $this->requestTranslation();
        if (!empty($this->response)) $this->resultArray = json_decode($this->response, true);
        return $this;
    }

    /**
     * Make array
     * @return array
     */
    public function makeArray() {
        if (!empty($this->resultArray)) return $this->resultArray;
        return null;
    }

    /**
     * Get All data result from Google Translate
     * @return string
     */
    public function getAll() {
        if (!empty($this->response)) return $this->response;
        return null;
    }

    /**
     * Get text only
     * @return string
     */
    public function getText() {
        if (!empty($this->resultArray["sentences"])){
            $sentences = "";
            foreach ($this->resultArray["sentences"] as $s) {
                $sentences .= isset($s["trans"]) ? $s["trans"] : '';
            }
            return $sentences;
        }
        return null;
    }

    /**
     * Get confidence (accuracy in numbers)
     * @return mixed int/string
     */
    public function getConfidence() {
        if (!empty($this->resultArray["confidence"])) return $this->resultArray["confidence"];
        return null;
    }

    /**
     * Get Source of detected language to translate
     * @return string
     */
    public function getSource() {
        if (!empty($this->resultArray["ld_result"]['srclangs'])) return $this->resultArray["ld_result"]['srclangs'][0];
        return null;
    }

    /**
     * Make a request translation service to the Google Translate
     * @return string json data 
     */
    public function requestTranslation() {
        if (!empty($this->text)){
            $url = "https://translate.google.com/translate_a/single?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=es-ES&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e";
            $fields = array(
                'sl' => urlencode($this->source),
                'tl' => urlencode($this->target),
                'q' => urlencode($this->text)
            );
            if(strlen($fields['q'])>=5000) throw new \Exception("Maximum number of characters exceeded: 5000");
        
            // Build data parameter for the POST
            $fields_string = "";
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');
            // Open connection
            $ch = curl_init();
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');
            // Execute post
            $result = curl_exec($ch);
            // Close connection
            curl_close($ch);
            return $result;
        }
        return '';    
    }

}