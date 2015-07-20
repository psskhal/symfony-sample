<?php

class sfWidgetFormSchemaFormatterGeneral extends sfWidgetFormSchemaFormatter {
    protected
        $rowFormat = "%label% \n%error% %field%  %hidden_fields% \n<br />\n",
		$errorListFormatInARow  = "%errors%",
		$errorRowFormatInARow  = "<span class=\"form-error\">&nbsp;&nbsp;&darr;&nbsp;%error%</span>\n";
}