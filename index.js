(function(){"use strict";function n(t,e,o,d,m,f,p,u){var c=typeof t=="function"?t.options:t;return e&&(c.render=e,c.staticRenderFns=o,c._compiled=!0),{exports:t,options:c}}const i={props:{content:Object,fieldset:Object},data(){return{selectedForm:null}},computed:{icon(){return this.fieldset.icon??"box"}},mounted(){this.fetchSelectedForm()},watch:{"content.formpage"(t,e){t!==e&&this.fetchSelectedForm()}},methods:{async fetchSelectedForm(){try{const t=this.content.formpage;if(!t)return;const e=await this.$api.pages.get(t);this.selectedForm=e}catch(t){console.error("Fout bij ophalen formulier:",t)}}}};var s=function(){var e=this,o=e._self._c;return o("div",{staticClass:"form-block"},[o("k-icon",{staticClass:"k-block-icon",attrs:{type:e.icon}}),o("span",{staticClass:"k-block-title-text"},[e.selectedForm?o("span",{staticClass:"k-block-name"},[e._v(e._s(e.selectedForm.title))]):o("span",{staticClass:"k-block-name"},[e._v("Geen formulier geselecteerd")])])],1)},l=[],r=n(i,s,l);const a=r.exports;panel.plugin("libis/forms",{blocks:{formselect:a,"formfields/input":{template:`
            <div @click="open">
                {{ content.text }}
            </div>
        `},"formfields/textarea":{template:`
            <div @click="open">
                {{ content.text }}
            </div>
        `},"formfields/checkbox":{template:`
            <div @click="open">
                {{ content.text }}
            </div>
        `},"formfields/select":{template:`
            <div @click="open">
                {{ content.text }}
            </div>
        `},"formfields/selectoption":{template:`
            <div @click="open">
                {{ content.text }}
            </div>
        `},"formfields/file":{template:`
            <div @click="open">
                {{ content.text }}
            </div>
        `}}})})();
