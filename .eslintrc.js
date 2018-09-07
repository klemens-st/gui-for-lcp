module.exports = {
    "env": {
        "browser": true,
        "es6": true
    },
    "extends": "eslint:recommended",
    "rules": {
        "indent": [
            "error",
            4,
            {"SwitchCase": 1}
        ],
        "linebreak-style": [
            "error",
            "unix"
        ],
        "quotes": [
            "error",
            "single"
        ],
        "semi": [
            "error",
            "always"
        ]
    },
    "globals": {
        "$": false,
        "mainModel": false,
        "MainModel": false,
        "ModalContentView": false,
        "wp": false,
        "_": false,
        "lcpCreateShortcode": false,
        "TaxTermsSubview": false,
        "ajax_object": false
    }
};