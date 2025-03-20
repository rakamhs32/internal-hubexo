<style>
    .trp-language-switcher .trp-ls-shortcode-current-language {
        background-color: var(--plum);
        border-radius: 120px;
        position: relative;
    }

    .trp-ls-shortcode-disabled-language.trp-ls-disabled-language,
    .trp-language-switcher>div>a.trp-ls-shortcode-disabled-language {
        color: var(--earth);
        font-size: 1rem;
    }

    .trp-ls-shortcode-language a {
        color: var(--plum);
    }

    .trp-language-switcher:hover .trp-ls-shortcode-disabled-language,
    .trp-language-switcher:hover .trp-ls-disabled-language {
        color: var(--plum);
    }

    .trp-ls-shortcode-current-language {
        visibility: visible !important;
    }

    .trp-language-switcher .trp-ls-shortcode-current-language,
    .trp-language-switcher>div {
        background-image: none;
    }

    .trp-ls-shortcode-disabled-language.trp-ls-disabled-language::after {
        border-style: solid;
        border-width: 0.2em 0.2em 0 0;
        content: '';
        display: inline-block;
        height: 0.45em;
        right: 10%;
        position: relative;
        top: .9em;
        transform: rotate(135deg);
        vertical-align: top;
        width: 0.45em;
        position: absolute;
        color: var(--earth);
        z-index: 90000;
    }

    .trp-language-switcher:hover .trp-ls-shortcode-disabled-language.trp-ls-disabled-language::after {
        color: var(--plum);
    }

    .trp-language-switcher:hover .trp-ls-shortcode-language .trp-ls-shortcode-disabled-language.trp-ls-disabled-language::after {
        display: none;
    }

    .trp-language-switcher:focus .trp-ls-shortcode-language,
    .trp-language-switcher:hover .trp-ls-shortcode-language {
        border-radius: 1.5rem;
    }
</style>

<div class="language-bar">
    <div class="container">
        <div class="bar-container">
            <?php echo do_shortcode('[language-switcher]'); ?>
        </div>
    </div>
</div>