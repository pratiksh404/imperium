// Fields
import TextField from '@/Imperium/Components/Form/Fields/TextField.vue'
import DefaultInputWrapper from '@/Imperium/Components/Form/DefaultInputWrapper.vue';
import NumberField from '@/Imperium/Components/Form/Fields/NumberField.vue';
import MaskField from '@/Imperium/Components/Form/Fields/MaskField.vue';
import SelectField from '@/Imperium/Components/Form/Fields/SelectField.vue';
import CheckBoxField from '@/Imperium/Components/Form/Fields/CheckBoxField.vue';
import ColorPickerField from '@/Imperium/Components/Form/Fields/ColorPickerField.vue';
import DatePickerField from '@/Imperium/Components/Form/Fields/DatePickerField.vue';
import OtpField from '@/Imperium/Components/Form/Fields/OtpField.vue';
import ListboxField from '@/Imperium/Components/Form/Fields/ListboxField.vue';
import RadioField from '@/Imperium/Components/Form/Fields/RadioField.vue';
import RatingField from '@/Imperium/Components/Form/Fields/RatingField.vue';
import SelectButtonField from '@/Imperium/Components/Form/Fields/SelectButtonField.vue';
import TextareaField from '@/Imperium/Components/Form/Fields/TextareaField.vue';
import ToggleButtonField from '@/Imperium/Components/Form/Fields/ToggleButtonField.vue';
import SwitchField from '@/Imperium/Components/Form/Fields/SwitchField.vue';
import FilepondField from '@/Imperium/Components/Form/Fields/FilepondField.vue';
import TextEditorField from '@/Imperium/Components/Form/Fields/TextEditorField.vue';
import PasswordField from '@/Imperium/Components/Form/Fields/PasswordField.vue';

import { IconField, FloatLabel, IftaLabel, InputGroup, Select, MultiSelect } from 'primevue';

export function resolveFieldComponent(fieldType) {
    const componentMap = {
        text: TextField,
        number: NumberField,
        mask: MaskField,
        select: SelectField,
        checkbox: CheckBoxField,
        colorPicker: ColorPickerField,
        datePicker: DatePickerField,
        otp: OtpField,
        listBox: ListboxField,
        radio: RadioField,
        rating: RatingField,
        selectButton: SelectButtonField,
        textarea: TextareaField,
        toggleButton: ToggleButtonField,
        switch: SwitchField,
        filepond: FilepondField,
        textEditor: TextEditorField,
        floatLabel: FloatLabel,
        iftaLabel: IftaLabel,
        inputGroup: InputGroup,
        iconField: IconField,
        defaultInputWrapper: DefaultInputWrapper,
        primeSelect: Select,
        primeMultiSelect: MultiSelect,
        password: PasswordField
    };

    return componentMap[fieldType] || null; // Return null if no matching component
}