# Analytics GoogleBundle

This is based on the original AntiMattr/GoogleBundle. It is solely for Analytics using the Universal Analytics API

## Installation

### Application Kernel

Add GoogleBundle to the `registerBundles()` method of your application kernel:

    public function registerBundles()
    {
        return array(
            new Strego\GoogleBundle\GoogleBundle(),
        );
    }

## Configuration

### Google Analytics

#### Application config.yml

Enable loading of the Google Analytics service by adding the following to
the application's `config.yml` file:

        strego_google:
            default_tracker: default
            trackers:
                default:
                    accountId: xXxxXx
                    domain: .example.com
                    allowHash: false
                    allowLinker: true
                    trackPageLoadTime: false

#### View

Include the Google Analytics Async template in the `head` tag or just before the `</body>` of your layout (The template will lazy load _gaq).

With twig:

    {% include "StregoGoogleBundle:Analytics:async.html.twig" %}

#### Features
