import FormSelect from "./components/FormSelect.vue";

panel.plugin("libis/forms", {
  blocks: {
    formselect: FormSelect,
    "formfields/input": {
        template: `
            <div @click="open">
                {{ content.text }}
            </div>
        `
    },
    "formfields/textarea": {
        template: `
            <div @click="open">
                {{ content.text }}
            </div>
        `
    },
    "formfields/checkbox": {
        template: `
            <div @click="open">
                {{ content.text }}
            </div>
        `
    },
    "formfields/select": {
        template: `
            <div @click="open">
                {{ content.text }}
            </div>
        `
    },
    "formfields/selectoption": {
        template: `
            <div @click="open">
                {{ content.text }}
            </div>
        `
    },
    "formfields/file": {
        template: `
            <div @click="open">
                {{ content.text }}
            </div>
        `
    },
  }
});