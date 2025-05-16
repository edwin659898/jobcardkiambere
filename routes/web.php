<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeedExtractionController;
use App\Models\Tree;
use Inertia\Inertia;
use App\Models\JobCard;
use App\Models\ChildActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\StockTimerController;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/upload/tree', function () {
    for ($i = 1; $i <= 1112; $i++) {
        if($i < 100) {
            Tree::create([
                'tree_number' => 'BGF0'.$i,
                'location' => 'Kiambere'
            ]);
        }else {
            Tree::create([
                'tree_number' => 'BGF'.$i,
                'location' => 'Kiambere'
            ]);
        }

    }
    return redirect('login');
});


Route::get('/dashboard', function () {
    $jobcards = JobCard::with('childactivity','childactivity.parent')->get();
    return Inertia::render('Dashboard',['Jobcards' => $jobcards]);
})->middleware(['auth', 'verified'])->name('Dashboard');

Route::middleware(['auth'])->group(function () {
    //Users Roles
    Route::get('/manage/user/roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('user.roles');
    Route::get('/manage/user/roles/{id}', [\App\Http\Controllers\RoleController::class, 'editUserRoles'])->name('Edit.user.roles');
    Route::patch('/update/user/roles/{id}', [\App\Http\Controllers\RoleController::class, 'updateUser'])->name('Update.user.roles');
    Route::get('/manage/activity/roles', [\App\Http\Controllers\RoleController::class, 'ActivityIndex'])->name('activity.roles');
    Route::get('/manage/activity/roles/{id}', [\App\Http\Controllers\RoleController::class, 'editActivityRoles'])->name('Edit.activity.roles');
    Route::patch('/update/activity/roles/{id}', [\App\Http\Controllers\RoleController::class, 'updateActivity'])->name('Update.activity.roles');
    Route::post('/create-role', [\App\Http\Controllers\RoleController::class, 'createRole'])->name('create role');
    Route::delete('/destroy-role/{id}', [\App\Http\Controllers\RoleController::class, 'destroyRole'])->name('destroy.role');
    Route::post('/upload/activities', [\App\Http\Controllers\RoleController::class, 'uploadActivities']);


    // users create, edit and view
    // // Route::post('/create_user', 'AdminController@createUser');
    // // Route::get('/get_users', 'AdminController@getUsers');
    // // Route::post('/edit_user', 'AdminController@editUser');
    //       starts here
    Route::get('/manage/user/users', [\App\Http\Controllers\RoleController::class, 'indexUsers'])->name('user.users');
    Route::get('/manage/user/users/{id}', [\App\Http\Controllers\RoleController::class, 'editUser'])->name('Edit.user.users');
    Route::get('/manage/activity/users', [\App\Http\Controllers\RoleController::class, 'ActivityUserIndex'])->name('activity.users');
    Route::get('/manage/activity/users/{id}', [\App\Http\Controllers\RoleController::class, 'editActivityUsers'])->name('Edit.activity.users');
    Route::delete('/users/{id}', [RoleController::class, 'destroy'])->name('users.destroy');

    //        ends here


    //Users Create, View , Delete (Inactive), Edit
    // Route::get('/manage/user/roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('user.roles');
    // Route::get('/manage/user/roles/{id}', [\App\Http\Controllers\RoleController::class, 'editUserRoles'])->name('Edit.user.roles');
    // Route::patch('/update/user/roles/{id}', [\App\Http\Controllers\RoleController::class, 'updateUser'])->name('Update.user.roles');
    // Route::get('/manage/activity/roles', [\App\Http\Controllers\RoleController::class, 'ActivityIndex'])->name('activity.roles');
    // Route::get('/manage/activity/roles/{id}', [\App\Http\Controllers\RoleController::class, 'editActivityRoles'])->name('Edit.activity.roles');
    // Route::patch('/update/activity/roles/{id}', [\App\Http\Controllers\RoleController::class, 'updateActivity'])->name('Update.activity.roles');
    // Route::post('/create-role', [\App\Http\Controllers\RoleController::class, 'createRole'])->name('create role');
    // Route::delete('/destroy-role/{id}', [\App\Http\Controllers\RoleController::class, 'destroyRole'])->name('destroy.role');
    // Route::post('/upload/activities', [\App\Http\Controllers\RoleController::class, 'uploadActivities']);

    //TransportMedia
    Route::get('/transport-media/list', [\App\Http\Controllers\TransportController::class, 'index'])->name('transport.medias');
    Route::post('/create-media', [\App\Http\Controllers\TransportController::class, 'create'])->name('create TM');
    Route::delete('/destroy-media/{id}', [\App\Http\Controllers\TransportController::class, 'destroy'])->name('destroy.role');


    //Operational Planning
    Route::get('operation-planning-activities', [\App\Http\Controllers\OperationalPlanningController::class, 'operationPlanning'])->name('operation-planning');
    Route::get('operation-planning/{id}', [\App\Http\Controllers\OperationalPlanningController::class, 'ChildActivity'])->name('OP activity');
    Route::get('New-Jobcard/{id}', [\App\Http\Controllers\OperationalPlanningController::class, 'NewJobCard'])->name('New job-card');
    Route::post('New-Jobcard', [\App\Http\Controllers\OperationalPlanningController::class, 'store']);
    Route::get('operation-planning/activity/{id}', [\App\Http\Controllers\OperationalPlanningController::class, 'ViewStage'])->name('operation.planning');
    Route::patch('operation-planning/sign/activity/{id}', [\App\Http\Controllers\OperationalPlanningController::class, 'updateActivity']);

    //Communication of approved Plans
    Route::get('communication/activities', [\App\Http\Controllers\CommunicationController::class, 'Communication'])->name('communication');
    Route::get('communication/{id}', [\App\Http\Controllers\CommunicationController::class, 'ChildActivity'])->name('Comm activity');
    Route::get('communication/activity/{id}', [\App\Http\Controllers\CommunicationController::class, 'ViewStage'])->name('communication.activity');
    Route::patch('communication/sign/activity/{id}', [\App\Http\Controllers\CommunicationController::class, 'updateCommunicationStages']);

    //Fruit Collection
    Route::get('Fruit-collection/activities', [\App\Http\Controllers\FruitCollectionController::class, 'FruitCollection'])->name('fruit-collection');
    Route::get('Fruit-collection/activity/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'ChildActivity'])->name('FC activity');
    Route::get('Fruit-collection/plan-approval/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'PlanApproval'])->name('sign.stage7');
    Route::get('Fruit-collection/labelling-gunny-bags/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'LabelGunnyBag'])->name('sign.stage8');
    Route::patch('/save/tree-number/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'storeLabeledGunnyBags']);
    Route::delete('/destroy/tree-number/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'destroyTreeNumber'])->name('destroy.treeNumber');
    Route::get('/complete/labelling-gunning-bags/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'CompleteLabelGunnyBags'])->name('complete.labelling');
    Route::patch('Fruit-collection/sign/activity/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'updatePlanApproval']);
    Route::get('Fruit-collection/collection-from-plus-trees/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'FruitCollectionFromTree'])->name('sign.stage9');
    Route::patch('/store/quantity/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'AssitToStore']);
    Route::get('Fruit-collection/sorting/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'FruitSorting'])->name('sign.stage10');
    Route::get('Fruit-collection/packaging/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'FruitPackaging'])->name('sign.stage11');
    Route::get('Fruit-collection/sign/collection-from-farm/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'FruitCollectionFromFarm'])->name('sign.stage12');
    Route::get('Fruit-collection/collection-point/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'FruitCollectionNurseryTransport'])->name('sign.stage13');
    Route::get('Fruit-collection/load-to-trucks/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'FruitCollectionNurseryTransport'])->name('sign.stage14');
    Route::get('Fruit-collection/truck-departure/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'TruckDeparture'])->name('sign.stage15');
    Route::patch('/update/truck/departure-time/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'UpdateTruckDepartureTime']);
    
    // Route::patch('Fruit-collection/collection-from-plus-trees/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'updateStatus']);

    // in fruit collection additional of status part
    Route::post('/api/update-stockstimer', [StockTimerController::class, 'updateStatus']);



    // Route::get('Fruit-collection/sign/collection-status/{id}', [\App\Http\Controllers\FruitCollectionController::class, 'FruitCollectionStatus'])->name('sign.stage12');


    //Fruit Storage
    Route::get('Fruit-storage/activities', [\App\Http\Controllers\FruitStorageController::class, 'FruitStorage'])->name('fruit-storage');
    Route::get('Fruit-storage/activity/{id}', [\App\Http\Controllers\FruitStorageController::class, 'ChildActivity'])->name('FS activity');
    Route::get('Fruit-storage/activity-one/{id}', [\App\Http\Controllers\FruitStorageController::class, 'TruckArrivalToNursery'])->name('sign.stage16');
    Route::patch('/Fruit-storage/truck-arrival-times/{id}', [\App\Http\Controllers\FruitStorageController::class, 'TruckArrivalTimes']);
    Route::get('Fruit-storage/quantity-check/{id}', [\App\Http\Controllers\FruitStorageController::class, 'QuantityCheckAtNursery'])->name('sign.stage17');
    Route::patch('/Fruit-storage/store/quantity-check/{id}', [\App\Http\Controllers\FruitStorageController::class, 'StoreQuantityCheckAtNursery']);
    Route::get('Fruit-storage/quality-check/{id}', [\App\Http\Controllers\FruitStorageController::class, 'QualityCheckAtNursery'])->name('sign.stage18');
    Route::patch('/Fruit-storage/store/quality-check/{id}', [\App\Http\Controllers\FruitStorageController::class, 'StoreQualityCheckAtNursery']);
    Route::patch('Fruit-storage/sign/quality-check/{id}', [\App\Http\Controllers\FruitStorageController::class, 'signQualityCheck']);
    Route::get('Fruit-storage/activity-four/{id}', [\App\Http\Controllers\FruitStorageController::class, 'Disinfection'])->name('sign.stage19');
    Route::get('Fruit-storage/activity-five/{id}', [\App\Http\Controllers\FruitStorageController::class, 'StorageAfterDisinfection'])->name('sign.stage20');
    Route::patch('/Fruit-storage/store/after-disinfection/{id}', [\App\Http\Controllers\FruitStorageController::class, 'StoreQuantityAfterDisinfection']);

    //Depulping 
    Route::get('Depulping/activities', [\App\Http\Controllers\DepulpingController::class, 'Depulping'])->name('depulping');
    Route::get('Depulping/activity/{id}', [\App\Http\Controllers\DepulpingController::class, 'ChildActivity'])->name('DP activity');
    Route::get('Depulping/stock-issue/{id}', [\App\Http\Controllers\DepulpingController::class, 'StockIssue'])->name('sign.stage21');
    Route::patch('/Depulping/stock-issue/{id}', [\App\Http\Controllers\DepulpingController::class, 'StoreIssuedStock']);
    Route::patch('/Depulping/receive-quantity/{id}', [\App\Http\Controllers\DepulpingController::class, 'ReceivedQuantity']);
    Route::patch('/Depulping/store-quantity/{id}', [\App\Http\Controllers\DepulpingController::class, 'AssistStoreQuantity']);
    Route::delete('/destroy/tree-number/{id}', [\App\Http\Controllers\DepulpingController::class, 'destroyStockIssue'])->name('destroy.stockIssue');
    Route::get('Depulping/fruit-distribution/{id}', [\App\Http\Controllers\DepulpingController::class, 'FruitDistributionDepulpAndDry'])->name('sign.stage22');
    Route::get('Depulping/fruit-depulping/{id}', [\App\Http\Controllers\DepulpingController::class, 'FruitDepulp'])->name('sign.stage23');
    Route::patch('/Depulping/fruit-depulping/{id}', [\App\Http\Controllers\DepulpingController::class, 'AssistStoreWeighedNuts']);
    Route::get('Depulping/nut-drying/{id}', [\App\Http\Controllers\DepulpingController::class, 'FruitDistributionDepulpAndDry'])->name('sign.stage24');
    Route::get('Depulping/nut-storage/{id}', [\App\Http\Controllers\DepulpingController::class, 'NutStorage'])->name('sign.stage25');
    Route::patch('/Depulping/nut-storage/{id}', [\App\Http\Controllers\DepulpingController::class, 'StoreQuantityInStorage']);

    //seed extraction
    Route::get('seed-extraction/activities', [\App\Http\Controllers\SeedExtractionController::class, 'SeedExtraction'])->name('seed-extraction');
    Route::get('seed-extraction/activity/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'ChildActivity'])->name('SE activity');
    Route::get('seed-extraction/stock-issue/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'StockIssue'])->name('sign.stage26');
    Route::patch('/seed-extraction/receive-quantity/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'ReceivedQuantity']);
    Route::patch('/seed-extraction/store-quantity/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'AssitStoreQuantity']);
    Route::patch('/seed-extraction/issue-stock/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'StoreStockIssue']);
    Route::get('seed-extraction/distribution-of-nuts/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'DistributionCrackingAndWeighing'])->name('sign.stage27');
    Route::get('seed-extraction/cracking-of-nuts/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'DistributionCrackingAndWeighing'])->name('sign.stage28');
    Route::get('seed-extraction/sorting/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'SeedSorting'])->name('sign.stage29');
    Route::patch('seed-extraction/sorting/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'StoreSeedSorting']);
    Route::get('seed-extraction/weighing-good-seed/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'DistributionCrackingAndWeighing'])->name('sign.stage30');
    Route::get('seed-extraction/stock-issue-for-storage/{id}', [\App\Http\Controllers\SeedExtractionController::class, 'IssueForStorage'])->name('sign.stage31');
    Route::post('seed-extraction/{id}/stock-issue-for-storage', [\App\Http\Controllers\SeedExtractionController::class, 'StoreIssueForStorage']);


    Route::post('/store-stock-issue', [SeedExtractionController::class, 'StoreStockIssue']);

    //Transport to another site
    Route::get('transport-to-other-sites/activities', [\App\Http\Controllers\TransportToOtherSiteController::class, 'SeedTransportation'])->name('seed-transportation');
    Route::get('transport-to-other-sites/activity/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'ChildActivity'])->name('TS activity');
    Route::get('transport-to-other-sites/request-means-of-transport/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'Transportation'])->name('sign.stage32');
    Route::get('transport-to-other-sites/departure-from-nairobi-kia/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'Transportation'])->name('sign.stage33');
    Route::get('transport-to-other-sites/transport-arrival-to-site/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'Transportation'])->name('sign.stage34');
    Route::patch('transport-to-other-sites/signatures/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'UpdateSignatures'])->name('transport.signature');
    Route::get('transport-to-other-sites/storage-issue/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'StorageIssue'])->name('sign.stage35');
    Route::get('transport-to-other-sites/weigh-of-seeds/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'WeighAndPackage'])->name('sign.stage36');
    Route::get('transport-to-other-sites/package-of-seeds/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'WeighAndPackage'])->name('sign.stage37');
    Route::post('/transport/weigh/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'StoreWeighAndPackage']);
    Route::get('transport-to-other-sites/loading-to-pickup/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'WeighAndPackage'])->name('sign.stage38');
    Route::get('transport-to-other-sites/transport-departure/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'Transportation'])->name('sign.stage39');
    Route::get('transport-to-other-sites/transport-arrival-to-another-site/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'Transportation'])->name('sign.stage40');
    Route::get('transport-to-other-sites/offloading-seeds/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'StorageIssue'])->name('sign.stage41');
    Route::get('transport-to-other-sites/weigh-of-seeds-after-offload/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'WeighAndPackage'])->name('sign.stage42');
    Route::get('transport-to-other-sites/check-quality/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'WeighAndPackage'])->name('sign.stage43');
    Route::get('transport-to-other-sites/seed-storage/{id}', [\App\Http\Controllers\TransportToOtherSiteController::class, 'SeedStorage'])->name('sign.stage44');

    //seed bed preparation
    Route::get('seed-bed-preparation/activities', [\App\Http\Controllers\SeedBedPreparationController::class, 'BedPreparation'])->name('bed-preparation');
    Route::get('seed-bed-preparation/activity/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'ChildActivity'])->name('BP activity');
    Route::get('seed-bed-preparation/identify-point-of-sand-collection/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'PointOfSandCollection'])->name('sign.stage45');
    Route::patch('seed-bed-preparation/identify-point-of-sand-collection/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'StorePointOfSandCollection']);
    Route::get('seed-bed-preparation/sand-testing/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'sandAndWaterTesting'])->name('sign.stage46');
    Route::patch('seed-bed-preparation/sand-testing/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'StoreSandAndWaterTesting']);
    Route::get('seed-bed-preparation/water-testing/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'sandAndWaterTesting'])->name('sign.stage47');
    Route::delete('/destroy/compartment/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'destroyCompartment'])->name('destroy.compartment');
    Route::get('seed-bed-preparation/sand-harvesting/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'SandHarvesting'])->name('sign.stage48');
    Route::get('seed-bed-preparation/transport-sand-to-nursery/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'SandTransportToNursery'])->name('sign.stage49');
    Route::get('seed-bed-preparation/sieveing-sand/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'SandTransportToNursery'])->name('sign.stage50');
    Route::patch('seed-bed-preparation/transport-sand-to-nursery/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'StoreSandTransportToNursery']);
    Route::get('seed-bed-preparation/transport-sand-to-production-area/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'SandTransportToNursery'])->name('sign.stage51');
    Route::get('seed-bed-preparation/cleaning-production-area/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'SandTransportToNursery'])->name('sign.stage52');
    Route::get('seed-bed-preparation/cleaning-plastic-sheets/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'SandTransportToNursery'])->name('sign.stage53');
    Route::get('seed-bed-preparation/lay-sowing-bed-foundation/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'SandTransportToNursery'])->name('sign.stage54');
    Route::get('seed-bed-preparation/apply-chemical-to-sand/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'SandChemicalApplication'])->name('sign.stage55');
    Route::get('seed-bed-preparation/marking-seed-beds/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'MarkSeedBeds'])->name('sign.stage56');
    Route::patch('seed-bed-preparation/marking-seed-beds/{id}', [\App\Http\Controllers\SeedBedPreparationController::class, 'StoreMarkSeedBeds']);
    Route::get('seed-bed-preparation/communicate-with-HO/{id}', [\App\Http\Controllers\CommunicationController::class, 'ViewStage'])->name('sign.stage57');

    //seedling propergation
    Route::get('seed-propergation/activities', [\App\Http\Controllers\SeedPropagationController::class, 'SeedPropergation'])->name('seed-propergate');
    Route::get('seed-propergation/activity/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'ChildActivity'])->name('SP activity');
    Route::get('seed-propergation/prepare-solution-for-soaking/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'PrepareSolution'])->name('sign.stage58');
    Route::get('seed-propergation/seed-soaking/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'SeedSoaking'])->name('sign.stage59');
    Route::get('seed-propergation/nipping-and-slitting/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'NippingAndSlitting'])->name('sign.stage60');
    Route::patch('seed-propergation/nipping-and-slitting/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'StoreNippingAndSlitting']);
    Route::get('seed-propergation/making-farrows/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'MakingFarrows'])->name('sign.stage61');
    Route::patch('seed-propergation/making-farrows/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'StoreMakingFarrows']);
    Route::get('seed-propergation/seed-sowing/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'SeedSowing'])->name('sign.stage62');
    Route::patch('seed-propergation/seed-sowing/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'StoreSeedSoakingAndSowing']);
    Route::get('seed-propergation/cheking-watering/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'AllOtherActivities'])->name('sign.stage63');
    Route::get('seed-propergation/watering-with-fungicide/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'WateringWithFungicide'])->name('sign.stage64');
    Route::patch('seed-propergation/watering-with-fungicide/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'StoreWateringWithFungicide']);
    Route::get('seed-propergation/watering/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'MakingFarrows'])->name('sign.stage65');
    Route::get('seed-propergation/regulate-air-and-moisture/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'MoistureAndAirRegulation'])->name('sign.stage66');
    Route::patch('seed-propergation/regulate-air-and-moisture/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'StoreMoistureAndAirRegulation']);
    Route::patch('seed-propergation/{id}/close-air-and-moisture-regulation', [\App\Http\Controllers\SeedPropagationController::class, 'CloseMoistureAndAirRegulation']);
    Route::get('seed-propergation/humidity-measurement/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'MakingFarrows'])->name('sign.stage67');
    Route::get('seed-propergation/measure-temperature/{id}', [\App\Http\Controllers\SeedPropagationController::class, 'MakingFarrows'])->name('sign.stage68');

    //potting
    Route::get('potting/activities', [\App\Http\Controllers\PottingController::class, 'Potting'])->name('potting');
    Route::get('potting/activity/{id}', [\App\Http\Controllers\PottingController::class, 'ChildActivity'])->name('PT activity');
    //Route::get('potting/material-acqusition-from-store/{id}', [\App\Http\Controllers\PottingController::class, 'MaterialAcquisition']);
    Route::get('potting/transportation/{id}', [\App\Http\Controllers\PottingController::class, 'TransportAndMixingSubstrate'])->name('sign.stage69');
    Route::patch('potting/transportation/{id}', [\App\Http\Controllers\PottingController::class, 'StoreTransportAndMixingSubstrate']);
    Route::get('potting/mixing-substrate/{id}', [\App\Http\Controllers\PottingController::class, 'TransportAndMixingSubstrate'])->name('sign.stage70');
    Route::get('potting/filling-planting-bags/{id}', [\App\Http\Controllers\PottingController::class, 'AllOtherActivities'])->name('sign.stage71');
    Route::get('potting/arrange-filed-pots-in-crates/{id}', [\App\Http\Controllers\PottingController::class, 'AllOtherActivities'])->name('sign.stage72');
    Route::get('potting/crates-transportation/{id}', [\App\Http\Controllers\PottingController::class, 'AllOtherActivities'])->name('sign.stage73');
    Route::get('potting/pots-arranging-in-seedbeds/{id}', [\App\Http\Controllers\PottingController::class, 'PotsArrangementInSeedlingBed'])->name('sign.stage74');
    Route::patch('potting/pots-arranging-in-seedbeds/{id}', [\App\Http\Controllers\PottingController::class, 'StorePotsArrangementInSeedlingBed']);
    Route::get('potting/checking-water/{id}', [\App\Http\Controllers\PottingController::class, 'AllOtherActivities'])->name('sign.stage75');

    //nursery shed construction
    Route::get('nursery-shed/activities', [\App\Http\Controllers\NurseryShedController::class, 'NurseryShed'])->name('nurseryShed');
    Route::get('nursery-shed/activity/{id}', [\App\Http\Controllers\NurseryShedController::class, 'ChildActivity'])->name('NS activity');
    Route::get('nursery-shed/planning/{id}', [\App\Http\Controllers\NurseryShedController::class, 'Planning'])->name('sign.stage76');
    Route::get('nursery-shed/site-identification/{id}', [\App\Http\Controllers\NurseryShedController::class, 'SiteIdentificationForConstruction'])->name('sign.stage77');
    Route::patch('nursery-shed/sign/activity/{id}', [\App\Http\Controllers\NurseryShedController::class, 'updatePlanning']);
    Route::get('nursery-shed/shed-construction/{id}', [\App\Http\Controllers\NurseryShedController::class, 'ShedConstruction'])->name('sign.stage78');
    Route::get('nursery-shed/communication-to-headoffice/{id}', [\App\Http\Controllers\TunnelConstructionController::class, 'Communication'])->name('sign.stage79');

    //Tunnel construction
    Route::get('seedling-bed-construction/activities', [\App\Http\Controllers\TunnelConstructionController::class, 'SeedlingBedConstruction'])->name('SeedlingBedConstruction');
    Route::get('seedling-bed-construction/activity/{id}', [\App\Http\Controllers\TunnelConstructionController::class, 'ChildActivity'])->name('TC activity');
    Route::get('seedling-bed-construction/planning/{id}', [\App\Http\Controllers\NurseryShedController::class, 'Planning'])->name('sign.stage80');
    Route::get('seedling-bed-construction/site-identification/{id}', [\App\Http\Controllers\NurseryShedController::class, 'SiteIdentificationForConstruction'])->name('sign.stage81');
    Route::get('seedling-bed-construction/construction-ongoing/{id}', [\App\Http\Controllers\TunnelConstructionController::class, 'TransportWithies'])->name('sign.stage82');
    Route::get('seedling-bed-construction/label-seedling-beds/{id}', [\App\Http\Controllers\TunnelConstructionController::class, 'LabelSeedlingBeds'])->name('sign.stage83');
    Route::patch('seedling-bed-construction/label-seedling-beds/{id}', [\App\Http\Controllers\TunnelConstructionController::class, 'StoreLabelSeedlingBeds']);
    Route::get('seedling-bed-construction/communication-to-headoffice/{id}', [\App\Http\Controllers\TunnelConstructionController::class, 'Communication'])->name('sign.stage111');

    //Pricking Out  
    //relook into numbers
    Route::get('pricking-out/activities', [\App\Http\Controllers\PrickingOutController::class, 'Pricking'])->name('prickingOut');
    Route::get('pricking-out/activity/{id}', [\App\Http\Controllers\PrickingOutController::class, 'ChildActivity'])->name('PO activity');
    Route::get('pricking-out/planning/{id}', [\App\Http\Controllers\NurseryShedController::class, 'Planning'])->name('sign.stage84');
    Route::get('pricking-out/chemical-preperation-for-treating/{id}', [\App\Http\Controllers\PrickingOutController::class, 'ChemicalPreperation'])->name('sign.stage85');
    Route::get('pricking-out/Extraction-of-seeds-and-place-in-basin-with-chemical/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage86');
    Route::get('pricking-out/place-seeds-in-basin-with-chemicals/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage87');
    Route::get('pricking-out/moving-seeds-to-seedling-area/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage88');
    Route::get('pricking-out/plant-seeds-in-pottingTubes/{id}', [\App\Http\Controllers\PrickingOutController::class, 'PlantSeedsToPottingTubes'])->name('sign.stage89');
    Route::patch('pricking-out/plant-seeds-in-pottingTubes/{id}', [\App\Http\Controllers\PrickingOutController::class, 'StorePlantSeedsToPottingTubes']);
    Route::get('pricking-out/water-seed-with-fungicide/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage90');
    Route::get('pricking-out/cover-seed-with-polythene/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage91');
    Route::get('pricking-out/watering/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage92');
    Route::get('pricking-out/moisture-and-air-regulation/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage93');
    Route::get('pricking-out/humidity-measurement/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage94');
    Route::get('pricking-out/temperature-measurement/{id}', [\App\Http\Controllers\PrickingOutController::class, 'AllOtherActivities'])->name('sign.stage95');

    //First Hardening
    Route::get('first-hardening/activities', [\App\Http\Controllers\FirstHardeningController::class, 'FirstHardening'])->name('FirstHardening');
    Route::get('first-hardening/activity/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'ChildActivity'])->name('FH activity');
    Route::get('first-hardening/covering-and-opening-seedling-beds/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'CoveringAndOpening'])->name('sign.stage96');
    Route::get('first-hardening/watering/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'AllOtherActivities'])->name('sign.stage97');
    Route::get('first-hardening/tunnels-opening/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'AllOtherActivities'])->name('sign.stage98');
    Route::get('first-hardening/tunnels-closing/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'AllOtherActivities'])->name('sign.stage99');
    Route::get('first-hardening/sort-seeds-out/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'Sorting'])->name('sign.stage100');
    Route::patch('first-hardening/sort-seeds-out/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'StoreSorting']);
    Route::get('first-hardening/chemical-spraying/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'ChemicalSpraying'])->name('sign.stage101');
    Route::patch('first-hardening/chemical-spraying/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'StoreChemicalSpraying']);
    //url for Chemical spraying


    //Second Hardening
    Route::get('second-hardening/activities', [\App\Http\Controllers\SecondHardeningController::class, 'SecondHardening'])->name('SecondHardening');
    Route::get('second-hardening/activity/{id}', [\App\Http\Controllers\SecondHardeningController::class, 'ChildActivity'])->name('SH activity');
    Route::get('second-hardening/covering-and-opening-seedling-beds/{id}', [\App\Http\Controllers\SecondHardeningController::class, 'CoveringAndOpening'])->name('sign.stage102');
    Route::get('second-hardening/watering/{id}', [\App\Http\Controllers\SecondHardeningController::class, 'AllOtherActivities'])->name('sign.stage103');
    Route::get('second-hardening/tunnels-opening/{id}', [\App\Http\Controllers\SecondHardeningController::class, 'AllOtherActivities'])->name('sign.stage104');
    Route::get('second-hardening/tunnels-closing/{id}', [\App\Http\Controllers\SecondHardeningController::class, 'AllOtherActivities'])->name('sign.stage105');
    Route::get('second-hardening/sort-seeds-out/{id}', [\App\Http\Controllers\SecondHardeningController::class, 'Sorting'])->name('sign.stage106');
    Route::get('second-hardening/chemical-spraying/{id}', [\App\Http\Controllers\FirstHardeningController::class, 'ChemicalSpraying'])->name('sign.stage107');

    //Seedlings Selection
    Route::get('seedling-selection/activities', [\App\Http\Controllers\SeedlingSelectionController::class, 'SeedlingSelection'])->name('SeedlingSelection');
    Route::get('seedling-selection/activity/{id}', [\App\Http\Controllers\SeedlingSelectionController::class, 'ChildActivity'])->name('SS activity');
    Route::get('seedling-selection/sorting-out/{id}', [\App\Http\Controllers\SecondHardeningController::class, 'Sorting'])->name('sign.stage108');
    Route::get('seedling-selection/seedling-selection/{id}', [\App\Http\Controllers\SecondHardeningController::class, 'Sorting'])->name('sign.stage109');
    Route::get('seedling-selection/arrange-seedlings-in-crate/{id}', [\App\Http\Controllers\SeedlingSelectionController::class, 'SelectSeeds'])->name('sign.stage110');
    Route::patch('seedling-selection/arrange-seedlings-in-crate/{id}', [\App\Http\Controllers\SeedlingSelectionController::class, 'StoreSelectSeeds']);


    //Reports
    Route::get('reports',[\App\Http\Controllers\ReportController::class,'index'])->name('reports.index');
    Route::get('reports/view/{id}/{item}',[\App\Http\Controllers\ReportController::class,'getReport'])->name('view.report');
    Route::get('excel-export',[\App\Http\Controllers\ReportController::class,'exportExcel'])->name('excel.export');

});







require __DIR__ . '/auth.php';