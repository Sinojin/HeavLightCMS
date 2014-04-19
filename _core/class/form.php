<?php

/*
 * Formaer Class with bootstep
 * by Seyhan YILDIZ
 * 
 *
 */

class form_class {

    private $method = 'POST';
    private $action;
    private $id = 'syForm';
    private $form_title = 'syForm >>>';
    private $on_click = '';
    private $enctype = 'multipart/form-data';
    private $form_class = 'text-left form-horizontal';
    private $submit_button = 'kaydet';
    private $form_elements;
    private $loader;
    #input ekleme

    function add_input($id, $label = '', $value = '', $hold = '', $detail = '') {
        $this->form_elements[] = '
         <div class="form-group">
            <label for="' . $id . '" class="col-lg-2 control-label  text-primary " >' . $label . ':</label>
            <div class="col-lg-10">
                <input type="text" name="' . $id . '" id="' . $id . '" class="input-sm form-control" value="' . $value . '" placeholder="' . $hold . '"/> 
                <span class="help-block">' . $detail . '</span>
            </div>
        </div>   
        ';
        return true;
    }

    #select ekleme

    function add_select($id, $data, $label = '', $change = '') {
        $this->form_elements[] = ' 
            <div class="form-group">
                <label for="' . $id . '" class="col-lg-2 control-label  text-primary ">' . $label . '</label>
                <div class="col-lg-10">
                    <select name="' . $id . '" id="' . $id . '" class="form-control text-info btn-primary" onChange="' . $change . '">
                    ' . $data . ' 
                    </select>
                </div>
            </div>  ';
        return true;
    }

    function add_manuel($id, $label, $data) {
        $this->form_elements[] = ' 
            <div class="form-group">
                <label for="' . $id . '" class="col-lg-2 control-label  text-primary ">' . $label . '</label>
                <div class="col-lg-10">
                   ' . $data . '  
                </div>
            </div>  ';
    }

    #checkbox ekleme

    function add_checkbox_single($id, $data, $check, $label = '', $dec = '') {
        $tmp = ' 
        <div class="form-group">
            <label for="' . $id . '" class="col-lg-2 control-label  text-primary ">' . $label . '</label>
            <div class="col-lg-10">     
                
                <input type="checkbox" name="tasima" value="' . $data . '" ';
        if ($check) {
            $tmp .= 'checked';
        }
        $tmp .=' >' . $dec . ' 
                    
            </div>
        </div>  ';
        $this->form_elements[] = $tmp;
        return TRUE;
    }

    #dosya ekleme

    function add_file($label = '') {
        $this->loader = 1;
        $this->form_elements[] = '
             <div class="form-group">
                <label for="baslik" class="col-lg-2 control-label  text-primary " >' . $label . ':</label>
                <div class="col-lg-10">
                    <input type="file" name="file" id="file" class="btn input form-control btn-warning" /> 
                </div>
            </div>     
        ';
        return TRUE;
    }

    #şifre alanı ekleme

    function add_password($id, $tag, $value = '', $hold = '', $detail = '') {
        $this->form_elements[] = '
         <div class="form-group">
            <label for="' . $id . '" class="col-lg-2 control-label  text-primary " >' . $tag . ':</label>
            <div class="col-lg-10">
                <input type="password" name="' . $id . '" id="' . $id . '" class="input-sm form-control" value="' . $value . '" placeholder="' . $hold . '"/> 
                <span class="help-block">' . $detail . '</span>
            </div>
        </div>   
        ';
        return TRUE;
    }

    function add_hidden($id, $data) {
        $this->form_elements[] = '<input type="hidden" name="' . $id . '" id="' . $id . '" value="' . $data . '">';
        return TRUE;
    }

    #text alanı ekleme

    function add_text($id, $label = '', $value = '', $detail = '', $class='') {
        $this->form_elements[] = '          
          <div class="form-group">
          <label for="' . $id . '" class="col-lg-2 control-label  text-primary ">' . $label . '</label>
            <div class="col-lg-10">
            
                <textarea type="text" name="' . $id . '" id="' . $id . '" class="form-control ' . $class . '" rows="3">' . $value . '</textarea>
                <span class="help-block">' . $detail . '</span>
                    
            </div>
          </div>';
        return TRUE;
    }

    public function set($var, $data) {
        return $this->$var = $data;
    }

    function __destruct() {
        //yıkıcı?
    }

    function display() {
        for ($i = 0 & $data = null; $i < count($this->form_elements); $i++) {
            $data .= $this->form_elements[$i];
        }
        if ($this->loader) {
            $data .= '<div id="yuklemeAni" class="progress"><div id="yuklemeBari" class="progress-bar " style="width: 0%"><div id="bilgilendirme" class="light"> </div></div></div>   <br />';
        }
        return "<div class=\"well \">\n" . ' 
 <form id="' . $this->id . '" name="' . $this->id . '" method="' . $this->method . '" action="' . $this->action . '" enctype="' . $this->enctype . '" onClick="' . $this->on_click . '" class="' . $this->form_class . '">
    <fieldset>
        <legend class="text-success">' . $this->form_title . '<br /><br /></legend>
            ' . $data . '  
        <input type="submit" name="kaydet" id="kaydet" value="' . $this->submit_button . '" class="btn btn-primary"/>
    </fieldset>
</form></div>';
    }

}
