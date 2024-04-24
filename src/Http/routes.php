<?php

Route::group([
    'namespace' => 'pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale'],
], function () {
    Route::prefix('/corpminingtax')
        ->group(function () {

            Route::get('/')
                ->name('corpminingtax.home')
                ->uses('CorpMiningOverviewController@getHome');

            Route::get('/logbook')
                ->name('corpminingtax.logbook')
                ->uses('CorpMiningLog@index');

            Route::get('/overview/{sid}')
                ->name('corpminingtax.overviewdata')
                ->uses('CorpMiningOverviewController@getOverviewData');

            Route::post('/getMiningData')
                ->name('corpminingtax.data')
                ->uses('CorpMiningTaxController@getData');

            Route::get('/getCorporations')
                ->name('getCorporations')
                ->uses('CorpMiningTaxController@getCorporations');

            Route::get('/getMoonObservers')
                ->name('getMoonObservers')
                ->uses('CorpMiningMoonMinings@getMoonObservers');

            Route::get('/statistics')
                ->name('corpminingtax.statistics')
                ->uses('CorpMiningStatistics@getHome');

            Route::get('/settings')
                ->name('corpminingtax.settings')
                ->uses('CorpMiningTaxSettingController@getSettings');

            Route::get('/thieves')
                ->name('corpminingtax.thieves')
                ->uses('CorpMiningThievesController@getData');

            Route::get('/miningtax')
                ->name('corpminingtax.tax')
                ->uses('CorpMiningTaxController@getHome');

            Route::get('/contracts')
                ->name('corpminingtax.contracts')
                ->uses('CorpMiningContracts@getHome');

            Route::get('/contracts/{cid}')
                ->name('corpminingtax.contractdata')
                ->uses('CorpMiningContracts@getDetails');

            Route::post('/updatecontractstatus')
                ->name('corpminingtax.contractstatus')
                ->uses('CorpMiningContracts@setContractOffered');

            Route::post('/complitecontract')
                ->name('corpminingtax.complitecontract')
                ->uses('CorpMiningContracts@setContractCompleted');

            Route::post('/removecontract')
                ->name('corpminingtax.contractremove')
                ->uses('CorpMiningContracts@removeContract');

            Route::get('/corpmoonmining')
                ->name('corpminingtax.corpmoonmining')
                ->uses('CorpMiningMoonMinings@getHome');

            Route::post('/updatesettings')
                ->name('corpminingtax.settings.update')
                ->uses('CorpMiningTaxSettingController@saveSettings');

            Route::get('/miningevents')
                ->name('corpminingtax.events')
                ->uses('CorpMiningEvents@getHome');

            Route::get('/getCharacters')
                ->name('getCharacters')
                ->uses('CorpMiningEvents@getCharacters');

            Route::get('/miningevents/{cid}')
                ->name('corpminingtax.eventdetails')
                ->uses('CorpMiningEvents@getDetails');

            Route::get('/miningeventsview/{cid}')
                ->name('corpminingtax.eventdetailsraw')
                ->uses('CorpMiningEvents@getDetailsRaw');

            Route::post('/createevent')
                ->name('corpminingtax.createevent')
                ->uses('CorpMiningEvents@createEvent');

            Route::post('/addmining')
                ->name('corpminingtax.addmining')
                ->uses('CorpMiningEvents@addMining');

            Route::post('/removeeventmining')
                ->name('corpminingtax.removeeventmining')
                ->uses('CorpMiningEvents@delMining');

            Route::post('/removeevent')
                ->name('corpminingtax.removeevent')
                ->uses('CorpMiningEvents@removeEvent');

            Route::get('/refining')
                ->name('corpminingtax.refining')
                ->uses('CorpMiningRefiningController@getHome');

            Route::post('/getRefinings')
                ->name('corpminingtax.refinings')
                ->uses('CorpMiningRefiningController@reprocessItems');
        });
});