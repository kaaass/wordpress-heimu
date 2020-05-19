import {__} from '@wordpress/i18n';
import {toggleFormat, registerFormatType} from '@wordpress/rich-text';
import {
    RichTextToolbarButton,
    RichTextShortcut
} from '@wordpress/block-editor';
import {default as iconHeimu} from './icon';

const name = 'heimu/heimu';
const title = __('增加黑幕', 'heimu');

let settings = {
    title,
    tagName: 'heimu',
    className: null,
    edit({value, onChange, onFocus, isActive}) {
        function onToggle() {
            onChange(toggleFormat(value, {type: name}));
        }

        function onClick() {
            onChange(toggleFormat(value, {type: name}));
            onFocus();
        }

        return (
            <>
                <RichTextShortcut
                    type="primary"
                    character="h"
                    onUse={onToggle}
                />
                <RichTextToolbarButton
                    icon={iconHeimu}
                    title={title}
                    onClick={onClick}
                    isActive={isActive}
                />
            </>
        );
    },
};

registerFormatType(name, settings);