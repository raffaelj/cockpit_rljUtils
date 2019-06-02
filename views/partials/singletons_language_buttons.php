
<span id="language_buttons" class="uk-float-right" if="{ languages.length }">

    <button class="uk-button uk-button-large { (!lang || lang == '') ? 'uk-button-success' : 'uk-text-muted' }" value="" onclick="{ updateLanguage }">
        { languages.length < 3 ? App.$data.languageDefaultLabel : '<?php echo $app->retrieve('i18n'); ?>' }
    </button><button class="uk-button uk-button-large uk-margin-small-left { lang == language.code ? 'uk-button-success' : 'uk-text-muted' }" each="{ language,idx in languages }" value="{ language.code }" onclick="{ updateLanguage }">
        { languages.length < 3 ? language.label : language.code }
    </button>

</span>

<script>

    updateLanguage = function(e) {

        e.preventDefault();

        $this.lang = e.target.value;

        // fix language update for wysiwyg field
        // I'm not 100% sure, if this line causes other side effects (e. g. performance)
        $this.trigger('mount');

    }

    jQuery('#language_buttons').appendTo('cp-actionbar > div');

</script>
