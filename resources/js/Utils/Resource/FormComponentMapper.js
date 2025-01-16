// Fields
import TextField from '@/Components/Form/Fields/TextField.vue'
import DefaultInputWrapper from '@/Components/Form/DefaultInputWrapper.vue';
import NumberField from '@/Components/Form/Fields/NumberField.vue';
import MaskField from '@/Components/Form/Fields/MaskField.vue';
import SelectField from '@/Components/Form/Fields/SelectField.vue';
import CheckBoxField from '@/Components/Form/Fields/CheckBoxField.vue';
import ColorPickerField from '@/Components/Form/Fields/ColorPickerField.vue';
import DatePickerField from '@/Components/Form/Fields/DatePickerField.vue';
import OtpField from '@/Components/Form/Fields/OtpField.vue';
import ListboxField from '@/Components/Form/Fields/ListboxField.vue';
import RadioField from '@/Components/Form/Fields/RadioField.vue';
import RatingField from '@/Components/Form/Fields/RatingField.vue';
import SelectButtonField from '@/Components/Form/Fields/SelectButtonField.vue';
import TextareaField from '@/Components/Form/Fields/TextareaField.vue';
import ToggleButtonField from '@/Components/Form/Fields/ToggleButtonField.vue';
import SwitchField from '@/Components/Form/Fields/SwitchField.vue';
import FilepondField from '@/Components/Form/Fields/FilepondField.vue';
import TextEditorField from '@/Components/Form/Fields/TextEditorField.vue';
import PasswordField from '@/Components/Form/Fields/PasswordField.vue';

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