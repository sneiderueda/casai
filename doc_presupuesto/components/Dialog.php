<?php

class Dialog {

    public static function Message($title = null, $message = null, $autoOpen = true, $caseButons = 0, $textButton = 'OK', $modal = true, $idResponse = null, $codUnidad = null) {
        $dialog = '';
        $open = 'autoOpen:' . $autoOpen;
        $idDialog = rand(0, 9999);
        $dialog .= '<style>
                        .ui-dialog-titlebar-close {
                            visibility: hidden;
                        }
                    </style>';
        $dialog .= '<div id="' . $idDialog . '" title="' . $title . '">';
        $dialog .= '<p>' . $message . '</p>';
        $dialog .='</div>';
        $butons = '';
        switch ($caseButons) {
            case 0:
                $butons = Dialog::crearDialogButton($textButton);
                break;
            case 1:
                $butons .= self::crearButtons('Confirmar', 'alert("ok");', 'Cancelar', '$(this).dialog("close")');
                break;            
            case 2:
                $butons .= self::crearButtons($textButton, '$(this).dialog("close");var elm =  window.location.assign("../../../index.php");');
                break;            
            case 3:
                $butons .= self::crearButtons($textButton, '$(this).dialog("close");var elm =  window.location.assign("../../../Olvido.php");');
                break;            
        }
        echo $dialog;
        if ($modal == false) {
            echo '<script>$("#' . $idDialog . '").dialog({' . $open . ',' . $butons . '},{ closeOnEscape: false });</script>';
        } else {
            echo '<script>$("#' . $idDialog . '").dialog({modal:' . $modal . ',' . $open . ',' . $butons . '},{ closeOnEscape: false });</script>';
        }
    }

    private static function crearButtons($buttonText1 = null, $action1 = null, $buttonText2 = null, $action2 = null) {
        $butons = '';
        if (!is_null($buttonText1) && !is_null($action1) && !is_null($buttonText2) && !is_null($action2)) {
            $butons.='buttons: {';
            $butons.="'" . $buttonText1 . "':function(){" . $action1 . "},";
            $butons.="'" . $buttonText2 . "':function(){" . $action2 . "}";
            $butons.='}';
            return $butons;
        } else if (!is_null($buttonText1) && !is_null($action1)) {
            $butons.='buttons: {';
            $butons.="'" . $buttonText1 . "':function(){" . $action1 . "}";
            $butons.='}';
            return $butons;
        }
    }

    private static function crearDialogButton($textButton = null, $action = 'close') {
        $button = '';
        $button .= 'buttons:{"' . $textButton . '":function(){$(this).dialog("' . $action . '");}}';
        return $button;
    }

}

?>
