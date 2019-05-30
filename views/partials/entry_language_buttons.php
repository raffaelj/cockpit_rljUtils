
<span id="language_buttons" class="uk-float-right" if="{ languages.length }">

    <button class="uk-button uk-button-large {lang == '' ? 'uk-button-success' : 'uk-text-muted'}" value="" onclick="{updateLanguage}">
        { App.$data.languageDefaultLabel }
    </button>

    <button class="uk-button uk-button-large {lang == language.code ? 'uk-button-success' : 'uk-text-muted'}" each="{ language,idx in languages }" value="{ language.code }" onclick="{updateLanguage}">
        { language.label }
    </button>

</span>

<script>

    updateLanguage = function(e) {

        e.preventDefault();

        $this.lang = e.target.value;
        App.session.set('collections.entry.'+this.collection._id+'.lang', e.target.value);

        // fix langage update for wysiwyg field
        // I'm not 100% sure, if this line causes other side effects (e. g. performance)
        $this.trigger('mount');

    }

    jQuery('#language_buttons').appendTo('cp-actionbar > div');

</script>
