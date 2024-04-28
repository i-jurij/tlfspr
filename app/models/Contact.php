<?php

namespace App\Models;

use App\Lib\CreateContact;
use App\Lib\SanitizeFileName;

class Contact extends Home
{
    use \App\Lib\Traits\ClearFile;
    use \App\Lib\Traits\GetDictionary;
    use \App\Lib\Traits\PutContentToFile;

    protected function dbQuery()
    {
        $this->data['page_db_data'] = [
            ['page_alias' => 'Contact',
            'page_title' => 'Phone dictionary editing',
            'page_meta_description' => 'Phone dictionary editing',
            'page_robots' => 'INDEX, FOLLOW',
            'page_h1' => 'Phone dictionary editing',
            'page_access' => 'user',
            ]];
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            && !empty($_POST['number'])
            && !empty($_POST['name'])) {
            $create = new CreateContact();
            $res = $create->create(\test_input($_POST['name']), \test_input($_POST['number']));
            if ($res === true) {
                $this->data['result'] = 'You saved next data:<br>
                                        Name: '.mb_convert_case(mbStrReplace('_', ' ', SanitizeFileName::run($_POST['name'])), MB_CASE_TITLE).'<br>
                                        Phone: '.phone_number_view(phone_number_to_db($_POST['number'])).'.';
            } else {
                $this->data['result'] = $res;
            }
        } else {
            $this->data['submit_button_text'] = 'Добавить';
            // $this->data['result'] = getOutput(PUBLICROOT.DS.'templates'.DS.'contact_form.php');
        }

        return $this->data;
    }

    public function update($name)
    {
        $dictionary = $this->getDictionary(DICTIONARY);

        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            && !empty($_POST['number'])
            && !empty($_POST['name'])) {
            $san_name = SanitizeFileName::run($_POST['name']);
            $san_number = phone_number_to_db($_POST['number']);
            unset($dictionary[$san_name]);
            $dictionary[$san_name] = $san_number;
            $res = $this->put(DICTIONARY, json_encode($dictionary), 0664, false);
            if ($res === true) {
                $this->data['result'] = 'You updated data:<br>
                                        Name: '.mb_convert_case(mbStrReplace('_', ' ', $san_name), MB_CASE_TITLE).'<br>
                                        Phone: '.phone_number_view($san_number).'.';
            } else {
                $this->data['result'] = $res;
            }
        } else {
            $this->data['name'] = $name[0];
            $this->data['number'] = phone_number_view(phone_number_to_db($dictionary[$name[0]]));
            $this->data['submit_button_text'] = 'Update';
            // $this->data['result'] = \getOutput(PUBLICROOT.DS.'templates'.DS.'contact_form.php');
        }

        return $this->data;
    }

    public function delete($name)
    {
        $dictionary = $this->getDictionary(DICTIONARY);
        unset($dictionary[$name[0]]);
        $res = $this->put(DICTIONARY, json_encode($dictionary), 0664, false);
        if ($res === true) {
            $this->data['result'] = 'Data from contact with name "'.mb_convert_case(mbStrReplace('_', ' ', $name[0]), MB_CASE_TITLE).'" has been deleted.';
        } else {
            $this->data['result'] = $res;
        }

        return $this->data;
    }

    public function clear()
    {
        $this->data['name'] = 'Dictionary cleaning';
        if (self::clearFile(DICTIONARY)) {
            $this->data['res'] = 'Dictionary has been cleared.';
        } else {
            $this->data['res'] = 'WARNING! Dictionary has been NOT cleared.';
        }

        return $this->data;
    }
}
