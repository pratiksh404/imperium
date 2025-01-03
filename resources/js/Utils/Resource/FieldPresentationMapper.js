// Presentation
import MediaPresentation from '@/Components/Presentation/Fields/MediaPresentation.vue';
import TextPresentation from '@/Components/Presentation/Fields/TextPresentation.vue';
import ListPresentation from '@/Components/Presentation/Fields/ListPresentation.vue';
import StringPresentation from '@/Components/Presentation/Fields/StringPresentation.vue';
import BooleanPresentation from '@/Components/Presentation/Fields/BooleanPresentation.vue';
import RatingPresentation from '@/Components/Presentation/Fields/RatingPresentation.vue';
import ColorPresentation from '@/Components/Presentation/Fields/ColorPresentation.vue';

export function resolveFieldPresentationComponent(presentationType) {
    const componentMap = {
        text: TextPresentation,
        datePicker: StringPresentation,
        checkbox: ListPresentation,
        listBox: ListPresentation,
        number: StringPresentation,
        mask: StringPresentation,
        otp: StringPresentation,
        radio: ListPresentation,
        select: ListPresentation,
        selectButton: BooleanPresentation,
        switch: BooleanPresentation,
        toggleButton: BooleanPresentation,
        filepond: MediaPresentation,
        rating: RatingPresentation,
        textarea: TextPresentation,
        textEditor: TextPresentation,
        colorPicker: ColorPresentation
    };
    return componentMap[presentationType] || TextPresentation;
}