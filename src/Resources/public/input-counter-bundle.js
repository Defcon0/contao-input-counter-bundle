window.InputCounterBundle = {
    init: function()
    {
        this.initCounter();
    },
    initCounter: function()
    {
        // get config from body tag
        var config = document.querySelector('body').getAttribute('data-input-counter');

        if (!config)
        {
            return;
        }

        config = JSON.parse(config);

        if (!Array.isArray(config))
        {
            return;
        }

        function updateCounter(element, configData) {
            var label = document.querySelector('[for="ctrl_' + configData.name + '"]'),
                charCount = element.value.length,
                maxCharCount = configData.max,
                cssClass = 'tl_' + (charCount > maxCharCount ? 'red' : 'green');

            if (!label.getAttribute('data-text'))
            {
                label.setAttribute('data-text', label.innerHTML);
            }

            if (typeof configData.skipColoring !== 'undefined' && configData.skipColoring)
            {
                cssClass = '';
            }

            label.innerHTML = label.getAttribute('data-text') + ' (<span' + (cssClass != '' ? ' class="' + cssClass + '"' : '') + '>' +
                configData.message.replace('%charCount%', charCount).replace('%maxCharCount%', maxCharCount) +
                '</span>)';
        }

        config.forEach(function(configData) {
            var element = document.querySelector('#ctrl_' + configData.name);

            if (element)
            {
                element.addEventListener('input', function() {
                    updateCounter(element, configData);
                }, false);

                updateCounter(element, configData);
            }
        });
    }
};

document.addEventListener('DOMContentLoaded', function() {
    InputCounterBundle.init();
});

document.addEventListener('turbo:load', function() {
    InputCounterBundle.init();
});
