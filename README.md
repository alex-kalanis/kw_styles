# kw_styles

[![Build Status](https://app.travis-ci.com/alex-kalanis/kw_styles.svg?branch=master)](https://app.travis-ci.com/github/alex-kalanis/kw_styles)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_styles/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_styles/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_styles/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_styles)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_styles.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_styles)
[![License](https://poser.pugx.org/alex-kalanis/kw_styles/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_styles)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_styles/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_styles/?branch=master)

Store styles for simplified render after everything has been prepared.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_styles": "1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader). Use example as reference.

2.) Initialize styles by calling "\kalanis\kw_styles\Styles::init()" in bootstrap

3.) Create render which uses "\kalanis\kw_styles\Styles::getAll()".

4.) Call "\kalanis\kw_styles\Styles::want()" in your controllers.

5.) Just run your site.
