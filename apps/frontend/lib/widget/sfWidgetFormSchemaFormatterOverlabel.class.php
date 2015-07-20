<?php

class sfWidgetFormSchemaFormatterOverlabel extends sfWidgetFormSchemaFormatter {
    protected
        $rowFormat = '<div class="overlabel_container">%label%%field%%hidden_fields%</div>';
}