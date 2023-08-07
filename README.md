[![Latest Stable Version](http://img.shields.io/packagist/v/pytonicis/seat-corp-mining-tax.svg?style=flat-square)]()
![](https://img.shields.io/badge/SeAT-4.0.x-blueviolet?style=flat-square)
![](https://img.shields.io/github/license/H4zz4rdDev/seat-buyback?style=flat-square)

# Seat Corporation Mining Tax

This plugin provides an extension to calculate mining taxes within the corporation. It simplifies the handling of taxes and gives an overview of mined ores of each member. Some additional features will very helpful to control the mining part.


## Quick Installation

### For non-Docker
```php
sudo -H -u www-data bash -c 'php artisan down'
sudo -H -u www-data bash -c 'composer require pyTonicis/seat-corp-mining-tax'
sudo -H -u www-data bash -c 'php artisan vendor:publish --force --all'
sudo -H -u www-data bash -c 'php artisan migrate'
sudo -H -u www-data bash -c 'php artisan seat:cache:clear'
sudo -H -u www-data bash -c 'php artisan config:cache'
sudo -H -u www-data bash -c 'php artisan route:cache'
sudo -H -u www-data bash -c 'php artisan up'
```
### For Docker

```
Edit your `.env` file,locate the line `SEAT_PLUGINS` and append `pyTonicis/seat-corp-mining-tax`
at the end.
```

Then , run `docker-compose up -d` to take effect.

### For Update

```
sudo -H -u www-data bash -c 'composer require pyTonicis/seat-corp-mining-tax'
```

## First Steps
In the first step, please open the settings page and select your corporation under the global settings. All other settings such as tax rate can be set as desired.

If you want to use EvE Janice as a price provider, you need to apply for a valid API Key and enter it in the field "Price Provider API Key".

## Screenshots

**Overview (Dashboard)**

![Overview](https://i.imgur.com/X09UX7R.png)

**Reprocessing**

![Refine](https://i.imgur.com/55wWf94.png)

**Corporation Mining Tax**

![Tax](https://i.imgur.com/FnGhI5E.png)

**Corporation Moon Minings** (Moons owned by Corporation)

![enter image description here](https://i.imgur.com/CBGBZ7a.png)