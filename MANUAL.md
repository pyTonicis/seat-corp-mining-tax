[![Latest Stable Version](http://img.shields.io/packagist/v/pytonicis/seat-corp-mining-tax.svg?style=flat-square)]()
![](https://img.shields.io/badge/SeAT-5.0.x-blueviolet?style=flat-square)
![](https://img.shields.io/badge/License-GPLv3-blue.svg)

# Introduction

This plugin was created for our corporation to make it easier for us to work with the mining taxes of our moons within the corporation. The idea was to make the workflow with the taxes and the associated contracts as simple as possible. Over time, some extensions such as statistics, detailed overviews and so on were added to simplify our daily business.

There will be more and more extensions, but please keep in mind that this is a hobby project and I want to have time for EvE, too. Now I wish you a lot of fun with the plugin and hope that it will help you also in your management.

### Features

- Each member has their own dashboard which contains various diagrams with information about yield, taxes to be paid, mined ore.
- Each member has their own mining logbook.
- Reprocessing of mined ores to determine the yield and the minerals contained.
- Mining tax overview for the management of monthly taxes.
- Corporation moons detailed overview with information about mined ores and yields.
- Tax contracts are generated automatically on a monthly basis with status monitoring (not in-Game).
- Event system with various options (e.g. Corp-Mining-Day, Corp-Moon-Mining-Day) and seperated taxing.
- Statistics on taxes received from mining and events, top miners, ...
- individual tax rates for different ore/gas/ice types.

### Future extensions

- Event auto tracking

# Configuration (Settings)

### Schedules (Seat Settings)

This plugin uses 3 different schedules. At a fresh install, all schedules are configured automatically.

**tax:update** This job updates every hour the mining tax and mining ledger  
**tax:generator** This job generate every month at the 2nd day the tax contracts  
**tax:contracts** This job checks every hour the state of generated contracts.  

You can configure all jobs by yourself. Just open Seat->Settings->Schedule and edit the jobs.

### Global Settings

In this area, basic settings are made which are important for the function of this tool.

- **Corporation** You have to select your Corporation name.
- **Ore refining rate** This is the factor of reprocessing yield. With implants, rigged Tatara and full skills it is 90,6%
- **Ore valuation price** Select ore price or refined mineral price for calculation of taxes.
- **Price Provider** Select a price provider to get ore/mineral prices. If you want to use Janice, you need a valid api-key (in Field Price Provider API Key).
- **Price Modifier** Modify base cost of ore/minerals. Normal is 100%
- **Tax Calculation Method** Choose "Accumulated" to get only a tax contract to main Characters or "Individual" to get for every Character a tax Contract.

### Contract Settings

In this area, you have to define the contract issuer and contract parameters.

- **Contract Issuer Character Name** Set the character name of the contract issuer.
- **Contract Tag** This is the Tag for Contracts.
- **Contract min value** Here you can define a minimum tax value for contracts. If tax is smaller then min value, no contract will be created.

### Moon Tax

Here you can set different tax rates for the different moon ore types.

### Tax Selector

Here you specify which types of materials are to be taxed.

# Operating Instructions

### The Mining overview (Dashboard)

![Overview](https://i.imgur.com/sCy80pL.jpeg)

In the dashboard, every user has the opportunity to view their mining income for the last few months. In the upper right area you can switch 
between your all characters or your alt's to check the individual preforms. The monthly earnings and taxes can also be viewed. In a fresh installation, 
however, only data for the current month is visible. If you want to record old data, this can be done manually on the Seat Console.

```php
sudo -H -u www-data bash -c 'php artisan tax:update 2023 10
```

### The Mining Logbook

![Logbook](https://i.imgur.com/kzxSvmp.jpeg)

Here u can check all minings per month and character.


### Mining Tax

![MiningTax](https://i.imgur.com/dBO8mNl.jpeg)

In the Mining Tax Area, you can check actual taxes for every Character. Also it is possible to view old taxes past months.