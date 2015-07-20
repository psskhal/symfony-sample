<?php

class sfWidgetFormSchemaFormatterDiv extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<div class=\"form-row\">\n %label%\n <div class=\"content\">%field%\n %error%\n</div>%help%\n %hidden_fields%</div>\n",
    $helpFormat      = '<div class="sf_admin_edit_help">%help%</div>',
    $errorListFormatInARow  = "%errors%",
    $errorRowFormatInARow  = "\n<div class=\"form-error\">&larr;&nbsp;%error%</div>\n",
    $decoratorFormat = "<fieldset>\n%content%</fieldset>";
}